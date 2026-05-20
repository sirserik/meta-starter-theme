@php
    $code    = '500';
    $heading = [
        'ru' => 'Внутренняя ошибка',
        'kk' => 'Ішкі қате',
        'en' => 'Internal server error',
    ];
    $body = [
        'ru' => 'Что-то пошло не так. Мы уже знаем и работаем над этим.',
        'kk' => 'Бірдеңе дұрыс болмады. Біз бұл туралы білеміз.',
        'en' => 'Something went wrong. Our team has been notified.',
    ];
@endphp
@include('errors.__layout', compact('code', 'heading', 'body'))
