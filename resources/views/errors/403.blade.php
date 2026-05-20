@php
    $code    = '403';
    $heading = [
        'ru' => 'Доступ запрещён',
        'kk' => 'Кіруге тыйым салынған',
        'en' => 'Access denied',
    ];
    $body = [
        'ru' => 'У вас нет прав на просмотр этой страницы.',
        'kk' => 'Бұл бетті көруге құқығыңыз жоқ.',
        'en' => 'You do not have permission to view this page.',
    ];
@endphp
@include('errors.__layout', compact('code', 'heading', 'body'))
