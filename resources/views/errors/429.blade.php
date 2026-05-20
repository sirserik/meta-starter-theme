@php
    $code    = '429';
    $heading = [
        'ru' => 'Слишком много запросов',
        'kk' => 'Тым көп сұрау',
        'en' => 'Too many requests',
    ];
    $body = [
        'ru' => 'Подождите немного и попробуйте снова.',
        'kk' => 'Аз күтіп, қайталап көріңіз.',
        'en' => 'Please wait a moment and try again.',
    ];
@endphp
@include('errors.__layout', compact('code', 'heading', 'body'))
