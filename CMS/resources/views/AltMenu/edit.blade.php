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
                            <h5 class="card-title">Alt Menü Bilgileri Düzenleme Sayfası</h5>
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
                        @if($altmenu)
                            <div class="card-body table-responsive">
                                <form action="{{ route('altmenu.update',$altmenu->ItemId) }}"
                                    method="POST">
                                    @csrf<!-- CSRF koruması için gerekli alan -->
                                    @method('PATCH')
                                    <div class="mb-3">
                                        <label for="MenuId" class="form-label">Menü Yeri</label>
                                        <select class="form-control" id="MenuId" name="MenuId" required>
                                            <option value="">Menü Seçiniz</option>
                                            @foreach($üstMenüList as $ustMenu)
                                                <option value="{{ $ustMenu->MenuId }}"
                                                    {{ $ustMenu->MenuId == $altmenu->MenuId ? 'selected' : '' }}>
                                                    {{ $ustMenu->MenuAdı }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="ItemAdı" class="form-label">Alt Menü Adı</label>
                                        <input type="text" class="form-control" id="ItemAdı" name="ItemAdı"
                                            value="{{ old('ItemAdı',$altmenu->ItemAdı) }}"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="ItemSırası" class="form-label">Alt Menü Sırası</label>
                                        <input class="form-control" id="ItemSırası" name="ItemSırası"
                                            value="{{ old('ItemSırası',$altmenu->ItemSırası) }}"
                                            rows="3" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="MenuLink" class="form-label">Menü Link</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="link_type"
                                                id="internal_link" value="internal" checked>
                                            <label class="form-check-label" for="internal_link">Site İçi
                                                Bağlantı</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="link_type"
                                                id="external_link" value="external">
                                            <label class="form-check-label" for="external_link">Harici Bağlantı</label>
                                        </div>
                                        <select class="form-control" id="MenuLink" name="MenuLink">
                                            <option value="">Sayfa Seçiniz</option>
                                            @foreach($page as $page)
                                                <option value="{{ $page->slug }}">{{ $page->title }}</option>
                                            @endforeach
                                        </select>
                                        <input type="text" class="form-control" name="MenuLink_external"
                                            id="ExternalMenuLink" style="display: none;"
                                            placeholder="Bağlantı Linkini giriniz">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Bağlantı Açılış Yöntemi</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="link_open" id="open-same"
                                                value="same" checked>
                                            <label class="form-check-label" for="open-same">Mevcut Sayfada Aç</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="link_open" id="open-new"
                                                value="new">
                                            <label class="form-check-label" for="open-new">Yeni Sekmede Aç</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary">Kaydet</button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const internalLinkRadio = document.getElementById('internal_link');
            const externalLinkRadio = document.getElementById('external_link');
            const internalLinkField = document.getElementById('MenuLink');
            const externalLinkField = document.getElementById('ExternalMenuLink');

            internalLinkRadio.addEventListener('change', function () {
                if (internalLinkRadio.checked) {
                    internalLinkField.style.display = 'block';
                    externalLinkField.style.display = 'none';
                }
            });

            externalLinkRadio.addEventListener('change', function () {
                if (externalLinkRadio.checked) {
                    internalLinkField.style.display = 'none';
                    externalLinkField.style.display = 'block';
                }
            });
        });

    </script>
    @include('layouts.setting')
    @include('layouts.script')
</body>

</html>
