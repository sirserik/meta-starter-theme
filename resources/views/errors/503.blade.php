@php
    $code    = '503';
    $heading = [
        'ru' => 'Сайт на обслуживании',
        'kk' => 'Сайтқа техникалық қызмет көрсетілуде',
        'en' => 'Site under maintenance',
    ];
    $body = [
        'ru' => 'Скоро вернёмся. Спасибо за терпение.',
        'kk' => 'Жуырда қайтып ораламыз. Шыдамдылығыңыз үшін рахмет.',
        'en' => 'We will be back shortly. Thank you for your patience.',
    ];
@endphp
@include('errors.__layout', compact('code', 'heading', 'body'))
