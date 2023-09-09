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
                            <h5 class="card-title">Menü Düzenleme Sayfası</h5>
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
                            <form method="post"
                                action="{{ route('menu.update', ['menu' => $menu->MenuId]) }}">
                                @csrf
                                @method('PATCH')
                                <div class="mb-3">
                                    <label for="alan_id" class="form-label">Menü Alanı</label>
                                    <select class="form-control" id="alan_id" name="alan_id" required>
                                        <option value="">Alan Seçiniz</option>
                                        @foreach($menu_alanlar as $menu_alan_item)
                                            <option value="{{ $menu_alan_item->alan_id }}" @if($menu->alan_id==
                                                $menu_alan_item->alan_id)
                                                selected @endif>{{ $menu_alan_item->alan_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="MenuAdı" class="form-label">Menü Adı</label>
                                    <input type="text" class="form-control" id="MenuAdı" name="MenuAdı"
                                        value="{{ old('MenuAdı',$menu->MenuAdı) }}"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="MenuSırası" class="form-label">Menü Sırası</label>
                                    <input type="text" class="form-control" id="MenuSırası" name="MenuSırası"
                                        value="{{ old('MenuSırası',$menu->MenuSırası) }}"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="MenuLink" class="form-label">Menü Link</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="link_type" id="internal_link"
                                            value="internal"
                                            {{ !str_starts_with($menu->MenuLink, 'http') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="internal_link">Site İçi Bağlantı</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="link_type" id="external_link"
                                            value="external"
                                            {{ str_starts_with($menu->MenuLink, 'http') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="external_link">Harici Bağlantı</label>
                                    </div>
                                    <select class="form-control" id="MenuLink" name="MenuLink" style="{{ !str_starts_with($menu->MenuLink, 'http') ? '' : 'display: none;' }}">
                                        <option value="">Sayfa Seçiniz</option>
                                        @foreach($page as $pageItem)
                                            <option value="{{ $pageItem->slug }}"
                                                {{ $menu->MenuLink === $pageItem->slug ? 'selected' : '' }}>
                                                {{ $pageItem->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="text" class="form-control" name="MenuLink_external"
                                        id="ExternalMenuLink"
                                        style="{{ str_starts_with($menu->MenuLink, 'http') ? '' : 'display: none;' }}"
                                        value="{{ str_starts_with($menu->MenuLink, 'http') ? $menu->MenuLink : '' }}"
                                        placeholder="Bağlantı Linkini giriniz">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Bağlantı Açılış Yöntemi</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="link_open" id="open-same"
                                            value="same"
                                            {{ $menu->link_open === 'same' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="open-same">Mevcut Sayfada Aç</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="link_open" id="open-new"
                                            value="new"
                                            {{ $menu->link_open === 'new' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="open-new">Yeni Sekmede Aç</label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Kaydet</button>
                            </form>
                        </div>
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
