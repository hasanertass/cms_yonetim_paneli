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
                            <h5 class="card-title">İletişim Formu Alan Düzenleme Sayfası</h5>
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
                            <form
                                action="{{ route('iletisimformalanları.update',$iletisimFormAlan->AlanId) }}"
                                method="POST">
                                @csrf<!-- CSRF koruması için gerekli alan -->
                                @method('PATCH')
                                <div class="mb-3">
                                    <label for="SirketAdi" class="form-label">Alan Adı</label>
                                    <input type="text" class="form-control" id="AlanName" name="AlanName"
                                        value="{{ old('AlanName',$iletisimFormAlan->AlanName) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="PleaceHolder" class="form-label">PleaceHolder (Formda Görünecek Ad)</label>
                                    <input type="text" class="form-control" id="PleaceHolder" name="PleaceHolder"
                                        value="{{ old('PleaceHolder',$iletisimFormAlan->PleaceHolder) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="AlanType" class="form-label">Alan Tipi</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="AlanType"
                                                    value="text" required
                                                    {{ $iletisimFormAlan->AlanType === 'text' ? 'checked' : '' }}>
                                                <label class="form-check-label">Kısa Metin</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="AlanType"
                                                    value="email" required
                                                    {{ $iletisimFormAlan->AlanType === 'email' ? 'checked' : '' }}>
                                                <label class="form-check-label">Mail</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="AlanType"
                                                    value="number" required
                                                    {{ $iletisimFormAlan->AlanType === 'number' ? 'checked' : '' }}>
                                                <label class="form-check-label">Sayı</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="AlanType"
                                                    value="textarea" required
                                                    {{ $iletisimFormAlan->AlanType === 'textarea' ? 'checked' : '' }}>
                                                <label class="form-check-label">Uzun Metin</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="AlanType"
                                                    value="file" required
                                                    {{ $iletisimFormAlan->AlanType === 'file' ? 'checked' : '' }}>
                                                <label class="form-check-label">Dosya</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="AlanType"
                                                    value="date" required
                                                    {{ $iletisimFormAlan->AlanType === 'date' ? 'checked' : '' }}>
                                                <label class="form-check-label">Tarih</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="AlanSırası" class="form-label">Alan Sırası</label>
                                    <input class="form-control" type="number" id="AlanSırası" name="AlanSırası"
                                        value="{{ old('AlanSırası',$iletisimFormAlan->AlanSırası) }}" rows="3" required>
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
