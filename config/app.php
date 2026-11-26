<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Nome da Aplicação
    |--------------------------------------------------------------------------
    |
    | Este valor é o nome da sua aplicação, usado quando o framework precisar
    | exibir o nome do sistema em notificações ou outros elementos da interface.
    |
    */

    'name' => env('APP_NAME', 'Agenda Pro'),

    /*
    |--------------------------------------------------------------------------
    | Ambiente da Aplicação
    |--------------------------------------------------------------------------
    |
    | Determina em qual ambiente a aplicação está rodando no momento. Isso
    | define como certos serviços são configurados. Ajuste no arquivo ".env".
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Modo de Depuração (Debug)
    |--------------------------------------------------------------------------
    |
    | Quando ativado, erros detalhados com rastreamento de pilha serão exibidos.
    | Quando desativado, uma página genérica de erro é mostrada ao usuário.
    |
    */

    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | URL da Aplicação
    |--------------------------------------------------------------------------
    |
    | Essa URL é usada pelo console para gerar links corretamente ao rodar
    | comandos Artisan. Configure para a URL raiz do seu projeto.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Fuso Horário (Timezone)
    |--------------------------------------------------------------------------
    |
    | Define o fuso horário padrão usado pelas funções de data e hora do PHP
    | e da aplicação.
    |
    */

    'timezone' => env('APP_TIMEZONE', 'America/Fortaleza'),

    /*
    |--------------------------------------------------------------------------
    | Configuração de Idioma (Locale)
    |--------------------------------------------------------------------------
    |
    | Define o idioma padrão usado pelas funções de tradução e localização do
    | Laravel.
    |
    */

    'locale' => env('APP_LOCALE', 'pt_BR'),

    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'pt_BR'),

    'faker_locale' => env('APP_FAKER_LOCALE', 'pt_BR'),

    /*
    |--------------------------------------------------------------------------
    | Chave de Criptografia
    |--------------------------------------------------------------------------
    |
    | Usada pelos serviços de criptografia do Laravel. Deve ser uma string
    | aleatória de 32 caracteres para manter os dados criptografados seguros.
    |
    */

    'cipher' => 'AES-256-CBC',

    'key' => env('APP_KEY'),

    'previous_keys' => [
        ...array_filter(
            explode(',', (string) env('APP_PREVIOUS_KEYS', ''))
        ),
    ],

    /*
    |--------------------------------------------------------------------------
    | Driver do Modo de Manutenção
    |--------------------------------------------------------------------------
    |
    | Define o driver usado para controlar o estado de modo de manutenção da
    | aplicação.
    |
    */

    'maintenance' => [
        'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
        'store' => env('APP_MAINTENANCE_STORE', 'database'),
    ],

];