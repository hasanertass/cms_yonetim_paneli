
<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 "
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        @if($gecerliLogo&&$gecerliBilgi)
            <a class="navbar-brand m-0"
                target="_blank">
                <img src="{{ asset($gecerliLogo->FilePath) }}" class="navbar-brand-img h-100" alt="main_logo">
                <span class="ms-1 font-weight-bold">{{ $gecerliBilgi->SirketAdi }}</span>
            </a>
        @endif
    </div>
    <br>
    <hr class="horizontal dark mt-0">
    <ul class="navbar-nav">
        <!-- Site Ayarları -->
        <li class="nav-item  {{ Request::is('') ? 'active' : '' }}">
            <a class="nav-link" data-bs-toggle="collapse" href="#site-settings" role="button" aria-expanded="false"
                aria-controls="site-settings">
                <div
                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="ni ni-settings-gear-65 text-warning text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Site Ayarları</span>
            </a>
            <div class="collapse nav-submenu-submenu " id="site-settings" >
                <ul class="nav flex-column ml-5">
                    <!-- Daha fazla boşluk -->
                    <!-- Logo -->
                    <li class="nav-item  {{ Request::is('homepage*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('homepage.index') }}">
                            <i class="fas fa-home text-dark"></i> <!-- İstenilen icon -->
                            <span class="nav-link-text ms-2">Ana Sayfa İçerikleri</span>
                        </a>
                    </li>
                    <li class="nav-item  {{ Request::is('logo*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('logo.index') }}">
                            <i class="fas fa-image text-primary"></i> <!-- İstenilen icon -->
                            <span class="nav-link-text ms-2">Logo</span>
                        </a>
                    </li>
                    <!-- Sosyal Medya -->
                    <li class="nav-item  {{ Request::is('sosyalmedya*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('sosyalmedya.index') }}">
                            <i class="fab fa-facebook text-info"></i> <!-- İstenilen icon -->
                            <span class="nav-link-text ms-2">Sosyal Medya</span>
                        </a>
                    </li>
                    <!-- Menü Bilgileri -->
                    <li class="nav-item ">
                        <a class="nav-link" data-bs-toggle="collapse" href="#anasayfa-menu" role="button"
                            aria-expanded="false" aria-controls="anasayfa-menu">
                            <i class="fas fa-bars text-success"></i>
                            <span class="nav-link-text ms-2">Menüler</span>
                        </a>
                        <div class="collapse nav-submenu" id="anasayfa-menu">
                            <ul class="nav flex-column ml-3">
                                <li class="nav-item  {{ Request::is('menualan*') ? 'active' : '' }}">
                                    <a class="nav-link"
                                        href="{{ route('menualan.index') }}">
                                        <i class="fa fa-bars text-warning"></i>
                                        <span class="nav-link-text ms-1">Menu Alanları</span>
                                    </a>
                                </li>
                                <!-- Alt Menü -->
                                @foreach($menuAlan as $menuAlan)
                                    <li class="nav-item  {{ Request::is('menualan*') ? 'active' : '' }}">
                                        <a class="nav-link"
                                            href="{{ route('menu.show',$menuAlan->alan_id) }}">
                                            <i class="fa fa-bars text-dark"></i>
                                            <span class="nav-link-text ms-1">{{ $menuAlan->alan_name }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                    <!-- İletişim Bilgileri -->
                    <li class="nav-item  {{ Request::is('contact') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('contact.index') }}">
                            <i class="fas fa-phone-alt text-danger"></i> <!-- İstenilen icon -->
                            <span class="nav-link-text ms-2">İletişim Bilgileri</span>
                        </a>
                    </li>
                    <!-- İletişim Form Bilgileri -->
                    <li class="nav-item  {{ Request::is('iletisimform') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('iletisimform.index') }}">
                            <i class="fa fa-wpforms text-dark"></i> <!-- İstenilen icon -->
                            <span class="nav-link-text ms-2">İletişim Formları</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <!-- Sayfalar -->
        <li class="nav-item  {{ Request::is('page') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('page.index') }}">
                <div
                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="ni ni-books text-success text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Sayfalar</span>
            </a>
        </li>
        <!-- Site İçerikleri -->
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#site-icerikleri" role="button" aria-expanded="false"
                aria-controls="site-icerikleri">
                <div
                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="ni ni-archive-2 text-info text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Site İçerikleri</span>
            </a>
            <div class="collapse nav-submenu-submenu" id="site-icerikleri">
                <ul class="nav flex-column ml-5">
                    <li class="nav-item  {{ Request::is('about*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('about.index') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="fa fa-list text-dark text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-2">Hakkımızda(Anasayfa)</span>
                        </a>
                    </li>
                    <li class="nav-item  {{ Request::is('service*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('service.index') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="fa fa-list text-dark text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-2">Hizmetler(Anasayfa)</span>
                        </a>
                    </li>
                    <li class="nav-item  {{ Request::is('marka*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('marka.index') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="fa fa-list text-dark text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-2">Referanslar</span>
                        </a>
                    </li>
                    <li class="nav-item  {{ Request::is('news*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('news.index') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="fa fa-list text-dark text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-2">Haberler</span>
                        </a>
                    </li>
                    <li class="nav-item  {{ Request::is('blog*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('blog.index') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="fa fa-list text-dark text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-2">Blog</span>
                        </a>
                    </li>
                    <li class="nav-item  {{ Request::is('sss*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('sss.index') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="fa fa-list text-dark text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-2">SSS</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <!-- Kullanıcı Ayarları -->
        <li class="nav-item  {{ Request::is('') ? 'active' : '' }}">
            <a class="nav-link" href="#">
                <div
                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="ni ni-circle-08 text-danger text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Kullanıcı Ayarları</span>
            </a>
        </li>
        <li class="nav-item  {{ Request::is('') ? 'active' : '' }}">
            <a class="nav-link" href="#form-name" data-bs-toggle="collapse" role="button" aria-expanded="false"
                aria-controls="form-name">
                <div
                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="ni ni-email-83 text-dark text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">İletişim Form Verileri</span>
            </a>
            <div class="collapse nav-submenu-submenu" id="form-name">
                <ul class="nav flex-column ml-3">
                    <!-- Alt Menü -->
                    @foreach($contactForm as $formName)
                        <li class="nav-item  {{ Request::is('') ? 'active' : '' }}">
                            <a class="nav-link"
                                href="{{ route('forms.show', ['form' => $formName->FormId]) }}">
                                <i class="fa fa-envelope fa-beat text-dark text-sm opacity-10"></i>
                                <span class="nav-link-text">{{ $formName->FormName }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </li>
        <!-- E-Bülten Abonelik -->
        <li class="nav-item  {{ Request::is('bulten') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('bulten.index') }}">
                <div
                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="ni ni-send text-primary text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">E-Bülten Abonelik</span>
            </a>
        </li>
        <li class="nav-item  {{ Request::is('admin') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.index') }}">
                <div
                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="fa fa-user text-warning text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Profilim</span>
            </a>
        </li>
        <li class="nav-item  {{ Request::is('') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('login.signout') }}">
                <div
                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="fa fa-sign-out text-danger text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Çıkış Yap</span>
            </a>
        </li>
    </ul>
</aside>
