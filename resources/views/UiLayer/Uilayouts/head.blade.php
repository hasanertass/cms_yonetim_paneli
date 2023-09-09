<!-- Topbar Start -->
@if($gecerliBilgi&&$ıcons)
    <div class="container-fluid text-light p-0" style="background-color: {{$head_setting->head_background_color}};">
        <div class="row gx-0 d-none d-lg-flex">
            <div class="col-lg-7 px-5 text-start">
                <div class="h-100 d-inline-flex align-items-center me-4">
                    <small style="color: {{$head_setting->icon_color}};" class="fas fa-map-marker-alt me-2"></small>
                    <a href="https://www.google.com/maps/search/{{ urlencode($gecerliBilgi->Adres) }}" style="color: {{$head_setting->text_color}};" target="_blank">{{ $gecerliBilgi->Adres }}</a>
                </div>
                <div class="h-100 d-inline-flex align-items-center">
                    <small style="color: {{$head_setting->icon_color}};" class="far fa-clock me-2"></small>
                    <small style="color: {{$head_setting->text_color}};">{{ $gecerliBilgi->work }}</small>&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
                <div class="h-100 d-inline-flex align-items-center me-4">
                    <small style="color: {{$head_setting->icon_color}};" class="fa fa-phone-alt me-2"></small>
                    <a type= "tel" href="tel:{{ $gecerliBilgi->Telefon }}" style="color: {{$head_setting->text_color}};">{{ $gecerliBilgi->Telefon }}</a>
                </div>
            </div>
            <div class="col-lg-5 px-5 text-end">
                <div class="h-100 d-inline-flex align-items-center">
                @foreach ($ıcons as $ıcon)
                    <a class="btn btn-square btn-link rounded-0 border-0 border-end border-secondary" href="{{ $ıcon->Link }}" target="_blank">
                        <img class="social-icon" src="{{ asset($ıcon->Icon) }}" alt="{{ $ıcon->Name }}">
                    </a>
                @endforeach
                </div>
            </div>
        </div>
    </div>
@endif
<!-- Topbar End -->

<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top p-0">
    @if($gecerliBilgi&&$gecerliLogo)
        <a href="/" class="navbar-brand d-flex align-items-center border-end px-4 px-lg-5">
            <img style="width: 100px; height: 100px;" src="{{ asset($head_setting->head_logo) }}" class="navbar-brand-img h-100" alt="main_logo">
            <h2 class="m-0"><i class="text-primary me-2"></i>{{ $gecerliBilgi->SirketAdi }}</h2>
        </a>
    @endif
    @include('errors')
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto p-4 p-lg-0">
            @foreach($head_menu as $menu)
                @if($menu->altMenuler->isNotEmpty()) <!-- Menünün alt menüleri var mı kontrolü -->
                    <div class="nav-item dropdown">
                        <a  href="#" class="nav-item nav-link active dropdown-toggle" data-bs-toggle="dropdown">{{ $menu->MenuAdı }}</a>
                        <div class="dropdown-menu bg-light m-0">
                            @foreach ($menu->altMenuler as $altMenuler)
                                @php
                                    $itemLink = $altMenuler->ItemLink;
                                    $linkOpen = $altMenuler->link_open; // Bu kısmı veritabanından alınan link_open değeri olarak değiştirin
                                    $linkHref = !str_starts_with($itemLink, 'http') ? route('page.show', ['slug' => str_replace('/', '', $itemLink)]) : $itemLink;
                                @endphp
                                    <a href="{{ $linkHref }}" class="dropdown-item"  @if ($linkOpen === 'new') target="_blank" @endif>{{ $altMenuler->ItemAdı }}</a>
                            @endforeach
                        </div>
                    </div>
                @else
                @php
                    $linkOpen = $menu->link_open; // Bu kısmı veritabanından alınan link_open değeri olarak değiştirin
                    $linkHref = !str_starts_with($menu->MenuLink, 'http') ? route('page.show', ['slug' => str_replace('/', '', $menu->MenuLink)]) : $menu->MenuLink;
                @endphp
                    <a href="{{ $linkHref }}" class="nav-item nav-link{{ $linkOpen === 'new' ? ' active' : '' }}" @if ($linkOpen === 'new') target="_blank" @endif>{{ $menu->MenuAdı }}</a>
                @endif
            @endforeach
        </div>
    </div>
</nav>
<!-- Navbar End -->
