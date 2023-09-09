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
                            <h5 class="card-title">Genel İçerik Ayarları İçerik Ayarları</h5>
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
                            <hr>
                            <h2 style="text-align: center;">Genel İçerik Ayarları</h2>
                            <hr>
                            <form action="{{ route('public.update', $public_setting->id) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf<!-- CSRF koruması için gerekli alan -->
                                @method('PATCH')
                                <div class="row">
                                    <div class="col-md-11">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3 form-group">
                                                    <label for="section_title_color" class="form-label">Bölüm Başlık Renkleri</label>
                                                    <input type="color" class="form-control d-flex align-items-center" id="section_title_color" 
                                                        value="{{ old('section_title_color',$public_setting->section_title_color) }}"
                                                        name="section_title_color" required>
                                                </div>
                                                <label for="görsel" class="form-label">
                                                    Fav İcon (Sekme İkonu)
                                                </label>
                                                <div class="d-flex align-items-center">
                                                    <input type="file" class="form-control" name="fav_icon"
                                                        id="fav_icon" value="{{ old('fav_icon') }}">
                                                    @if(isset($public_setting->fav_icon))
                                                        <img id="görsel-onizleme-1"
                                                            src="{{ asset($public_setting->fav_icon) }}"
                                                            alt="Görsel Önizleme"
                                                            style="max-width: 200px; max-height: 200px;">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="d-flex justify-content-end flex-column h-100">
                                            <button style="height: 100%; white-space: nowrap;" type="submit"
                                                class="btn btn-primary">
                                                <span
                                                    style="writing-mode: vertical-rl; transform: rotate(180deg);">Değişiklikleri
                                                    Kaydet</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <hr>
                            <h2 style="text-align: center;">Üst Bilgi İçerik Ayarları</h2>
                            <hr>
                            <form action="{{ route('head.update', $head_setting->id) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf<!-- CSRF koruması için gerekli alan -->
                                @method('PATCH')
                                <div class="row">
                                    <div class="col-md-11">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3 form-group">
                                                    <label for="text_color" class="form-label">Yazı Renkleri</label>
                                                    <input type="color" class="form-control" id="text_color"
                                                        value="{{ old('text_color',$head_setting->text_color) }}"
                                                        name="text_color" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3 form-group">
                                                    <label for="icon_color" class="form-label">İcon Renkleri</label>
                                                    <input type="color" class="form-control" id="icon_color"
                                                        value="{{ old('icon_color',$head_setting->icon_color) }}"
                                                        name="icon_color" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3 form-group">
                                                    <label for="head_background_color" class="form-label">Üst Bilgi Arka
                                                        Plan
                                                        Rengi</label>
                                                    <input type="color" class="form-control" id="head_background_color"
                                                        value="{{ old('head_background_color',$head_setting->head_background_color) }}"
                                                        name="head_background_color" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <!-- Head Menü Grubu Seçimi -->
                                                <label for="menu_group" class="form-label">Üst Bilgi Menü Grubu</label>
                                                <select class="form-control" id="menu_group" name="menu_group">
                                                    <option value="">Menü Grubu Seçiniz</option>
                                                    @foreach($menu_groups as $grup)
                                                        <option value="{{ $grup->alan_id }}"
                                                            {{ $grup->alan_id == $head_setting->menu_group ? 'selected' : '' }}>
                                                            {{ $grup->alan_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="görsel" class="form-label">
                                                    Üst Bilgi Logo
                                                </label>
                                                <div class="d-flex align-items-center">
                                                    <input type="file" class="form-control" name="head_logo"
                                                        id="head_logo" value="{{ old('head_logo') }}">
                                                    @if(isset($head_setting->head_logo))
                                                        <img id="görsel-onizleme-2"
                                                            src="{{ asset($head_setting->head_logo) }}"
                                                            alt="Görsel Önizleme"
                                                            style="max-width: 200px; max-height: 200px;">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="d-flex justify-content-end flex-column h-100">
                                            <button style="height: 100%; white-space: nowrap;" type="submit"
                                                class="btn btn-primary">
                                                <span
                                                    style="writing-mode: vertical-rl; transform: rotate(180deg);">Değişiklikleri
                                                    Kaydet</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <hr>
                            <h2 style="text-align: center;">Alt Bilgi (Footer) İçerik Ayarları</h2>
                            <hr>
                            <form action="{{ route('footer.update', $footer_setting->id) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf<!-- CSRF koruması için gerekli alan -->
                                @method('PATCH')
                                <div class="row">
                                    <div class="col-md-11">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3 form-group">
                                                    <label for="text_color" class="form-label">Yazı Renkleri</label>
                                                    <input type="color" class="form-control" id="text_color"
                                                        value="{{ old('text_color',$footer_setting->text_color) }}"
                                                        name="text_color" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3 form-group">
                                                    <label for="icon_color" class="form-label">İcon Renkleri</label>
                                                    <input type="color" class="form-control" id="icon_color"
                                                        value="{{ old('icon_color',$footer_setting->icon_color) }}"
                                                        name="icon_color" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3 form-group">
                                                    <label for="footer_background_color" class="form-label">Üst Bilgi
                                                        Arka
                                                        Plan
                                                        Rengi</label>
                                                    <input type="color" class="form-control"
                                                        id="footer_background_color"
                                                        value="{{ old('footer_background_color',$footer_setting->footer_background_color) }}"
                                                        name="footer_background_color" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <!-- Footer Menü Grubu Seçimi -->
                                                <label for="menu_group" class="form-label">Footer Menü Grubu</label>
                                                <select class="form-control" id="menu_group" name="menu_group">
                                                    <option value="">Menü Grubu Seçiniz</option>
                                                    @foreach($menu_groups as $grup)
                                                        <option value="{{ $grup->alan_id }}"
                                                            {{ $grup->alan_id == $footer_setting->menu_group ? 'selected' : '' }}>
                                                            {{ $grup->alan_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="footer_görsel" class="form-label">
                                                    Footer Logo
                                                </label>
                                                <div class="d-flex align-items-center">
                                                    <input type="file" class="form-control" name="footer_logo"
                                                        id="footer_logo" accept="image/*">
                                                    @if(isset($footer_setting->footer_logo))
                                                        <img id="görsel-onizleme-3"
                                                            src="{{ asset($footer_setting->footer_logo) }}"
                                                            alt="Footer Görsel Önizleme"
                                                            style="max-width: 200px; max-height: 200px;">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="d-flex justify-content-end flex-column h-100">
                                            <button style="height: 100%; white-space: nowrap;" type="submit"
                                                class="btn btn-primary">
                                                <span
                                                    style="writing-mode: vertical-rl; transform: rotate(180deg);">Değişiklikleri
                                                    Kaydet</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                $(document).ready(function () {
                    $('#head_logo').on('change', function (e) {
                        var fileInput = e.target;
                        var file = fileInput.files[0];
                        var imgPreview = $('#görsel-onizleme-2');

                        if (file) {
                            var reader = new FileReader();

                            reader.onload = function (e) {
                                imgPreview.attr('src', e.target.result);
                                imgPreview.show(); // Dosya seçildiğinde önizlemeyi göster
                            };

                            reader.readAsDataURL(file);
                        } else {
                            imgPreview.attr('src', ''); // Dosya seçilmediğinde önizlemeyi temizle
                            imgPreview.hide(); // Dosya seçilmediğinde önizlemeyi gizle
                        }
                    });
                });

            </script>
            <script>
                $(document).ready(function () {
                    $('#fav_icon').on('change', function (e) {
                        var fileInput = e.target;
                        var file = fileInput.files[0];
                        var imgPreview = $('#görsel-onizleme-1');

                        if (file) {
                            var reader = new FileReader();

                            reader.onload = function (e) {
                                imgPreview.attr('src', e.target.result);
                                imgPreview.show(); // Dosya seçildiğinde önizlemeyi göster
                            };

                            reader.readAsDataURL(file);
                        } else {
                            imgPreview.attr('src', ''); // Dosya seçilmediğinde önizlemeyi temizle
                            imgPreview.hide(); // Dosya seçilmediğinde önizlemeyi gizle
                        }
                    });
                });

            </script>
            <script>
                $(document).ready(function () {
                    $('#footer_logo').on('change', function (e) {
                        var fileInput = e.target;
                        var file = fileInput.files[0];
                        var imgPreview = $('#görsel-onizleme-3');

                        if (file) {
                            var reader = new FileReader();

                            reader.onload = function (e) {
                                imgPreview.attr('src', e.target.result);
                                imgPreview.show(); // Dosya seçildiğinde önizlemeyi göster
                            };

                            reader.readAsDataURL(file);
                        } else {
                            imgPreview.attr('src', ''); // Dosya seçilmediğinde önizlemeyi temizle
                            imgPreview.hide(); // Dosya seçilmediğinde önizlemeyi gizle
                        }
                    });
                });

            </script>
            @include('layouts.setting')
            @include('layouts.script')
</body>

</html>
