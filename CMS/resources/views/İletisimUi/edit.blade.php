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
                            <form action="{{ route('iletisimsection.update',$iletisim->id) }}"
                                method="POST">
                                @csrf<!-- CSRF koruması için gerekli alan -->
                                @method('PATCH')
                                <div class="mb-3">
                                    <label for="title" class="form-label">Başlık</label>
                                    <input class="form-control" id="title" name="title" required
                                        value="{{ old('title',$iletisim->title) }}">
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Açıklama 1</label>
                                    <textarea class="form-control" id="description" name="description" rows="3"
                                        required>{{ old('description',$iletisim->description) }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="contact_form" class="form-label">İletişim Formu</label>
                                    <select class="form-control" id="contact_form" name="contact_form" required>
                                        <option value="">Form Seçiniz</option>
                                        @foreach($forms as $form)
                                            <option value="{{ $form->FormId }}" @if($form->FormId ==
                                                $iletisim->contact_form) selected @endif>
                                                {{ $form->FormName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Güncelle</button>
                                </div>
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
