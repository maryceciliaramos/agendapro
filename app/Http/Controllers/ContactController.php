<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        // 1. Pegamos o termo de busca (se houver)
        $search = $request->input('search');

        // 2. Iniciamos a consulta vinculada ao usuário logado
        $query = auth()->user()->contacts();

        // 3. Se houver busca, aplicamos os filtros (usando o WHERE do SQL)
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        // 4. Pegamos os resultados ordenados pelo mais recente
        $contacts = $query->latest()->get();

        return view('contacts.index', compact('contacts', 'search'));
    }

    public function create()
    {
        return view('contacts.create');
    }

    public function store(Request $request)
    {
        // Validação
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email',
            'type' => 'required|in:Pessoal,Trabalho,Outros',
            'notes' => 'nullable|string',
            'photo' => 'nullable|image|max:2048' // Máximo 2MB
        ]);

        if ($request->hasFile('photo')) {
            // Salva a imagem na pasta 'contacts' dentro de 'public'
            $data['photo'] = $request->file('photo')->store('contacts', 'public');
        }

        // Criação vinculada ao usuário
        auth()->user()->contacts()->create($data);

        // Redireciona com mensagem de sucesso
        return redirect()->route('contacts.index')->with('success', 'Contato cadastrado com sucesso!');
    }

    public function edit(Contact $contact)
    {
        // Segurança: Verifica se o contato pertence ao usuário
        if ($contact->user_id !== auth()->id()) {
            abort(403, 'Acesso negado.');
        }

        return view('contacts.edit', compact('contact'));
    }

    public function update(Request $request, Contact $contact)
    {
        // Segurança: Verifica se o contato pertence ao usuário
        if ($contact->user_id !== auth()->id()) {
            abort(403);
        }

        // Validação igual ao store
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email',
            'type' => 'required|in:Pessoal,Trabalho,Outros',
            'notes' => 'nullable|string',
            'photo' => 'nullable|image|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            // Apaga a foto antiga se existir
            if ($contact->photo) {
                Storage::disk('public')->delete($contact->photo);
            }
            // Salva a nova
            $data['photo'] = $request->file('photo')->store('contacts', 'public');
        }

        $contact->update($data);

        return redirect()->route('contacts.index')->with('update', 'Contato atualizado com sucesso!');
    }

    public function destroy(Contact $contact)
    {
        // Segurança
        if ($contact->user_id !== auth()->id()) {
            abort(403);
        }

        if ($contact->photo) {
            Storage::disk('public')->delete($contact->photo);
        }

        $contact->delete();

        return redirect()->route('contacts.index')->with('delete', 'Contato removido com sucesso!');
    }

    public function exportPdf()
    {
        $contacts = auth()->user()->contacts()->latest()->get();

        // Carrega a view específica para o PDF e passa os contatos
        $pdf = Pdf::loadView('contacts.pdf', compact('contacts'));

        // Faz o download do arquivo com o nome 'minha_agenda.pdf'
        return $pdf->download('minha_agenda.pdf');
    }
}