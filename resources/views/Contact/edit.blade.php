<!DOCTYPE html>
@include('layouts.header')

<body class="g-sidenav-show bg-gray-100">
    <div class="position-absolute w-100 min-height-300 top-0"
        style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/profile-layout-header.jpg'); background-position-y: 50%;">
        <span class="mask bg-primary opacity-6"></span>
    </div>
    @include('layouts.sidebar')
    <div class="main-content position-relative max-height-vh-100 h-100">
        <!-- Navbar -->
        @include('layouts.navbar')
        <!-- End Navbar -->
        <div class="container-fluid py-11">
            <div class="row">
                <div class="col-md-24">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Firma İletişim Bilgileri Düzenleme Sayfası</h5>
                        </div>
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="card-body table-responsive">
                            <form action="{{ route('contact.update',$contact->Id) }}"
                                method="POST">
                                @csrf<!-- CSRF koruması için gerekli alan -->
                                @method('PATCH')
                                <div class="mb-3">
                                    <label for="SirketAdi" class="form-label">Şirket Adı<span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" id="Baslik" name="SirketAdi" value="{{ old('SirketAdi',$contact->SirketAdi)}}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="Adres" class="form-label">Kısa Adres<span style="color:red;">*</span></label>
                                    <input class="form-control" id="Soru" name="Adres" rows="3" required value="{{ old('Adres',$contact->Adres)}}">
                                </div>
                                <div class="mb-3">
                                    <label for="Adres2" class="form-label">Adres</label>
                                    <input class="form-control" id="Cevap" name="Adres2" value="{{ old('Adres2',$contact->Adres2)}}" rows="3" >
                                </div>
                                <div class="mb-3">
                                    <label for="Mail" class="form-label">Mail<span style="color:red;">*</span></label>
                                    <input type="email" class="form-control" id="Mail" name="Mail" value="{{ old('Mail',$contact->Mail)}}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="Mail2" class="form-label">Mail 2</label>
                                    <input type="email" class="form-control" id="Mail" name="Mail2" value="{{ old('Mail2',$contact->Mail2)}}" >
                                </div>
                                <div class="mb-3">
                                    <label for="Telefon" class="form-label">Telefon<span style="color:red;">*</span></label>
                                    <input type="tel" class="form-control" id="Telefon" name="Telefon" value="{{ old('Telefon',$contact->Telefon)}}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="Telefon2" class="form-label">Telefon 2</label>
                                    <input type="tel" class="form-control" id="Telefon" name="Telefon2" value="{{ old('Telefon2',$contact->Telefon2)}}" >
                                </div>
                                <div class="mb-3">
                                    <label for="work" class="form-label">Çalışma Saatleri<span style="color:red;">*</span></label>
                                    <input type="tel" class="form-control" id="Telefon" name="work" value="{{ old('work',$contact->work)}}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="Harita" class="form-label">Harita<span style="color:red;">*</span></label>
                                    <input class="form-control" id="Cevap" name="Harita" rows="2" value="{{ old('Harita',$contact->Harita)}}" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Kaydet</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.setting')
    @include('layouts.script')

</body>

</html>
