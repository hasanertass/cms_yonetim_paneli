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
                            <h5 class="card-title">Yeni Soru Ekleme Sayfası</h5>
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
                            <form action="{{ route('sss.store') }}" method="POST">
                                @csrf<!-- CSRF koruması için gerekli alan -->
                                <div class="mb-3">
                                    <label for="sayfa_id" class="form-label">Sayfa Adı</label>
                                    <select class="form-control" id="sayfa_id" name="sayfa_id" required>
                                        <option value="">Sayfa Seçiniz</option>
                                        @foreach($sayfalar as $sayfa)
                                            <option value="{{ $sayfa->sayfa_id }}">{{ $sayfa->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="soru" class="form-label">Soru</label>
                                    <textarea class="form-control" id="Soru" name="Soru" rows="3" value="{{ old('Soru') }}" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="cevap" class="form-label">Cevap</label>
                                    <textarea class="form-control" id="Cevap" name="Cevap" rows="3" value="{{ old('Cevap') }}" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="sira" class="form-label">Sıra</label>
                                    <input type="number" class="form-control" id="Sira" name="Sira" value="{{ old('Sira') }}" required>
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
