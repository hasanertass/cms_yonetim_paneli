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
                            <h5 class="card-title">İletişim Bilgileri Düzenleme Sayfası</h5>
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
                            <form action="{{ route('iletisimform.update',$iletisimForm->FormId) }}"
                                method="POST">
                                @csrf<!-- CSRF koruması için gerekli alan -->
                                @method('PATCH')
                                <input type="hidden" name="FormId" value="{{ old('FormId',$iletisimForm->FormId)}}">
                                <div class="mb-3">
                                    <label for="FormName" class="form-label">Form Adı</label>
                                    <input type="text" class="form-control" id="FormName" name="FormName" value="{{ old('FormName',$iletisimForm->FormName)}}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="form_description" class="form-label">Form Açıklama</label>
                                    <input type="text" class="form-control" id="form_description" name="form_description" value="{{ old('form_description',$iletisimForm->form_description)}}" required>
                                </div>
                                <div class="form-group">
                                    <label for="sayfa_id" class="form-label">Form Sayfası</label>
                                    <select class="form-control" id="sayfa_id" name="sayfa_id" required>
                                        <option value="">Sayfa Seçiniz</option>
                                        @foreach($page as $page)
                                            <option required value="{{ old('sayfa_id', $page->sayfa_id) }}" @if($iletisimForm->sayfa_id == $page->sayfa_id) selected @endif>{{ $page->title }}
                                            </option>
                                        @endforeach
                                    </select>
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
