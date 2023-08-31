    <div class="container-fluid bg-dark text-light footer my-6 mb-0 py-6 wow fadeIn" data-wow-delay="0.1s">
        <div class="container" style="margin-top: 0; padding-top: 0; color:559fa8;">
            <div class="row g-5">
                <div class="col-lg-4 col-md-8" >
                    <div class="d-flex align-items-center">
                        <img style="width: 70px; height: 70px;" src="{{ asset($gecerliLogo->FilePath) }}"  alt="main_logo">
                        <h2 class="text-white mt-2"><i class="text-white me-2"></i>{{ $gecerliBilgi->SirketAdi }}</h2>
                    </div>
                    <br>
                    <p class="mb-2" style="width: 400px; overflow-wrap: break-word;"><i class="fa fa-map-marker-alt me-3"></i>{{ $gecerliBilgi->Adres }}</p>
                    <p class="mb-2" style="width: 400px; overflow-wrap: break-word;"><i class="fa fa-phone-alt me-3"></i>{{ $gecerliBilgi->Telefon }}</p>
                    <p class="mb-2" style="width: 400px; overflow-wrap: break-word;"><i class="fa fa-envelope me-3"></i>{{ $gecerliBilgi->Mail }}</p>    
                </div>
                <div class="col-lg-4 col-md-8">
                    <div class="d-flex align-items-center">
                        <h2 class="text-white mt-2"><i class="text-white me-2"></i>Menü</h2>
                    </div>
                    @foreach ($footerMenu as $menu)
                        @if($menu->altMenuler->isNotEmpty()) <!-- Menünün alt menüleri var mı kontrolü -->
                            <div class="nav-item dropdown">
                                <a href="{{route('page.show',['slug' => str_replace('/', '', $menu->MenuLink)]) }}" class="nav-item nav-link active dropdown-toggle" data-bs-toggle="dropdown">{{ $menu->MenuAdı }}</a>
                                <div class="dropdown-menu bg-light m-0">
                                    @foreach ($menu->altMenuler as $altMenuler)
                                        @php
                                            $itemLink = $altMenuler->ItemLink;
                                        @endphp
                                        <a href="{{ route('page.show', ['slug' => str_replace('/', '',$itemLink)]) }}" class="dropdown-item">{{ $altMenuler->ItemAdı }}</a>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <a href="{{route('page.show',['slug' => str_replace('/', '', $menu->MenuLink)]) }}" class="nav-item nav-link active">{{ $menu->MenuAdı }}</a>
                        @endif
                    @endforeach
                </div>
                <div class="col-lg-4 col-md-6">
                    <h4 class="text-light mt-4">E-Bülten Abonelik</h4>
                    <form method="POST" action="{{ route('bulten.store') }}" onsubmit="return handleFormSubmit(this)">
                        @csrf
                        <div class="input-group">
                            <input type="email" class="form-control p-3 border-0" placeholder="Mail Adresiniz" name="mail" id="mail" value="{{ old('mail') }}" required>
                            <button type="submit" class="btn btn-primary">Abone Ol</button>
                        </div>
                    </form>
                    <h6 class="text-white mt-4 mb-3">Bizi Takip Edin</h6>
                    <div class="d-flex pt-2">
                        @foreach($ıcons as $ıcon)
                            <a class="btn btn-square rounded-0 border-0 border-end border-secondary"
                                href="{{ $ıcon->Link }}">
                                <img class="social-icon" src="{{ asset($ıcon->Icon) }}"
                                    alt="{{ $ıcon->platform }}">
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Copyright Start 
        <div class="container-fluid copyright text-light py-4 wow fadeIn" data-wow-delay="0.1s">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; <a href="#">Your Site Name</a>, All Right Reserved.
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        /*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support.
                        Designed By <a href="https://htmlcodex.com">HTML Codex</a>
                        <br>Distributed By: <a href="https://themewagon.com" target="_blank">ThemeWagon</a>
                    </div>
                </div>
            </div>
        </div>  
    -->
   
