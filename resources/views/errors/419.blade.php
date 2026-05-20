@php
    $code    = '419';
    $heading = [
        'ru' => 'Сессия истекла',
        'kk' => 'Сессия аяқталды',
        'en' => 'Page expired',
    ];
    $body = [
        'ru' => 'Обновите страницу и попробуйте ещё раз.',
        'kk' => 'Бетті жаңартып, қайталап көріңіз.',
        'en' => 'Please refresh the page and try again.',
    ];
@endphp
@include('errors.__layout', compact('code', 'heading', 'body'))
