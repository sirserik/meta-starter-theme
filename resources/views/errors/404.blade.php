@php
    $code    = '404';
    $heading = [
        'ru' => 'Страница не найдена',
        'kk' => 'Бет табылмады',
        'en' => 'Page not found',
    ];
    $body = [
        'ru' => 'Запрашиваемая страница не существует или была перемещена.',
        'kk' => 'Сіз іздеген бет жоқ немесе жойылған.',
        'en' => 'The page you are looking for does not exist or has been moved.',
    ];
@endphp
@include('errors.__layout', compact('code', 'heading', 'body'))
