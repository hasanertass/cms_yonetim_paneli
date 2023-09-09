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
                            <h5 class="card-title">Yeni Firma İletişim Bilgileri Ekleme Sayfası</h5>
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
                            <form action="{{ route('contact.store') }}" method="POST">
                                @csrf<!-- CSRF koruması için gerekli alan -->
                                <div class="mb-3">
                                    <label for="baslik" class="form-label">Şirket Adı <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" id="Baslik" value="{{ old('SirketAdi') }}" name="SirketAdi" required>
                                </div>
                                <div class="mb-3">
                                    <label for="soru" class="form-label">Kısa Adres <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" id="Soru" name="Adres" value="{{ old('Adres') }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="cevap" class="form-label">Adres </label>
                                    <textarea class="form-control" id="Cevap" name="Adres2" rows="3"
                                        >{{ old('Adres2') }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="cevap" class="form-label">Mail<span style="color:red;">*</span></label>
                                    <input type="email" class="form-control" id="Mail" value="{{ old('Mail') }}" name="Mail" required>
                                </div>
                                <div class="mb-3">
                                    <label for="cevap" class="form-label">Mail 2</label>
                                    <input type="email" class="form-control" id="Mail" name="Mail2" value="{{ old('Mail2') }}" >
                                </div>
                                <div class="mb-3">
                                    <label for="cevap" class="form-label">Telefon<span style="color:red;">*</span></label>
                                    <input type="tel" class="form-control" id="Telefon" name="Telefon" value="{{ old('Telefon') }}" required>

                                </div>
                                <div class="mb-3">
                                    <label for="cevap" class="form-label">Telefon 2</label>
                                    <input type="tel" class="form-control" id="Telefon" name="Telefon2" value="{{ old('Telefon2') }}" >
                                </div>
                                <div class="mb-3">
                                    <label for="work" class="form-label">Çalışma Saatleri<span style="color:red;">*</span></label>
                                    <input type="work" class="form-control" id="work" name="work" value="{{ old('work') }}" placeholder="Örnek : Mon - Fri : 09.00 AM - 09.00 PM" required>
                                </div>
                                <div class="mb-3">
                                    <label for="cevap" class="form-label">Harita<span style="color:red;">*</span></label>
                                    <textarea class="form-control" id="Cevap" name="Harita" rows="2"
                                        required>{{ old('Harita') }}</textarea>
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
