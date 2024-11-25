<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ isset($meta_title) ? $meta_title .' | '. config('app.name', 'box') : config('app.name', 'box') }}</title>
<meta name="description" content="{{ isset($meta_desc) ? $meta_desc : '' }}">
<meta name="author" content="Roman Kocian">
<link rel="icon" type="image/png" href="{{ asset('/favicon.png') }}">

<!-- Styles -->
<link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
@vite(['resources/css/app.css', 'resources/js/app.js'])