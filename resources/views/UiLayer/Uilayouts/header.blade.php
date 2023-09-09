<head>
    <meta charset="utf-8">
    @if($page->AnaSayfa=="1")
    <title>{{$gecerliBilgi->SirketAdi}}</title>
    @else
    <title>{{$gecerliBilgi->SirketAdi}} - {{$page->title}}</title>
    @endif
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="{{ $page->meta_keywords }}" name="keywords">
    <meta content="{{ $page->meta_description }}" name="description">
    <meta content="{{ $page->meta_title }}" name="title">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css"
        integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css"
        integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <!-- Favicon -->
    @if($gecerliLogo)
        <link rel="icon" type="image/png" class="rounded-circle" href="{{ asset($fav_icon->fav_icon) }}">
    @endif

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>


    <!-- Libraries Stylesheet -->
    <link href="{{ asset('drivin-1.0.0/') }}/lib/animate/animate.min.css" rel="stylesheet">
    <link href="{{ asset('drivin-1.0.0/') }}/lib/owlcarousel/assets/owl.carousel.min.css"
        rel="stylesheet">


    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('drivin-1.0.0/') }}/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('drivin-1.0.0/') }}/css/style.css" rel="stylesheet">

    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

    <script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    
</head>
