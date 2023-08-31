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
                            <h5 class="card-title">Ana Sayfa Ayarları</h5>
                        </div>
                        @include('errors')
                        <div class="table-responsive ">
                            <table class="table table-bordered"
                                style="text-align: center; width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr>
                                        <th>Görsel</th>
                                        <th>Başlık</th>
                                        <th>Açıklama</th>
                                        <th>Buton Link</th>
                                        <th>Sil</th>
                                        <th>Düzenle</th>
                                        <th>Kullanım Durumu</th>
                                        <th>Görseli Diğer Sayfalarda Kullan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($homepages as $homepage)
                                        <tr>
                                            <td class="align-middle"><img src="{{ asset($homepage->image) }}"
                                                    alt="Görsel" width="150px" height="150px">
                                            </td>
                                            <td class="align-middle"
                                                style="max-width: 200px; overflow: hidden; text-overflow: ellipsis;">
                                                {{ $homepage->title }}
                                            </td>
                                            <td class="align-middle">{{ $homepage->description }}</td>
                                            <td class="align-middle">{{ $homepage->buton_link }}</td>
                                            <td class="align-middle">
                                                <form
                                                    action="{{ route('homepage.destroy', $homepage->id) }}"
                                                    method="POST" id="deleteForm_{{ $homepage->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"
                                                        onclick="return confirmDelete({{ $homepage->id }})">Sil</button>
                                                </form>
                                            </td>
                                            <td class="align-middle">
                                                <a href="{{ route('homepage.edit', $homepage->id) }}"
                                                    class="btn btn-success">Düzenle</a>
                                            </td>
                                            <td class="align-middle">
                                                <form
                                                    action="{{ route('homepage.status', $homepage->id) }}"
                                                    method="post">
                                                    @csrf
                                                    <input type="hidden" name="_method" value="PATCH">
                                                    @if( $homepage->status == 0)
                                                        @method('Post')
                                                        <button type="submit" class="btn btn-outline-info">Aktif
                                                            Yap</button>
                                                    @else
                                                        @method('Post')
                                                        <button type="submit" class="btn btn-outline-warning">Pasif
                                                            Yap</button>
                                                    @endif
                                                </form>
                                            </td>
                                            <td class="align-middle">
                                                <form
                                                    action="{{ route('homepage.otherpage', $homepage->id) }}"
                                                    method="post">
                                                    @csrf
                                                    <input type="hidden" name="_method" value="PATCH">
                                                    @if( $homepage->otherpageimage == 0)
                                                        @method('Post')
                                                        <button type="submit"
                                                            class="btn btn-outline-info">Kullan</button>
                                                    @else
                                                        @method('Post')
                                                        <button type="submit" class="btn btn-outline-warning"
                                                            disabled>Kullanılan</button>
                                                    @endif
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <a href="{{ route('homepage.create') }}" class="btn btn-primary">Yeni Görsel
                            Ekle</a>
                    </div>
                    <!-- content2 başlangıcı -->

                    <form action="{{ route('homepage.menü', $menülist->id) }}" method="post">
                        @csrf
                        <input type="hidden" name="_method" value="PATCH">
                        <div class="row">
                            <div class="col-md-6 p-3" style="background-color: #ffffff;">
                                <!-- Ana Sayfa Menü Grubu Seçimi -->
                                <label for="anaSayfaMenuGrubu" class="form-label">Ana Sayfa Menü Grubu</label>
                                <select class="form-control" id="anaSayfaMenuGrubu" name="anaSayfaMenuGrubu">
                                    <option value="">Menü Grubu Seçiniz</option>
                                    @foreach($menu as $grup)
                                        <option value="{{ $grup->alan_id }}"
                                            {{ $grup->alan_id == $menülist->anasayfa_menü  ? 'selected' : '' }}>
                                            {{ $grup->alan_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 p-3" style="background-color: #ffffff;">
                                <!-- Footer Menü Grubu Seçimi -->
                                <label for="footerMenuGrubu" class="form-label">Footer Menü Grubu</label>
                                <select class="form-control" id="footerMenuGrubu" name="footerMenuGrubu">
                                    <option value="">Menü Grubu Seçiniz</option>
                                    @foreach($menu as $grup)
                                        <option value="{{ $grup->alan_id }}"
                                            {{ $grup->alan_id == $menülist->footer_menü ? 'selected' : '' }}>
                                            {{ $grup->alan_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-info col-md-12 p-3">Değişiklikleri Kaydet</button>
                    </form>

                    <!-- content2 sonu -->
                </div>
            </div>
        </div>
    </div>
    <script>
        // Silme işlemi için onay sorusu göster
        function confirmDelete(Id) {
            if (confirm('Emin misiniz? Görsel bilgileri silindiğinde geri alınamaz.')) {
                // Silme işlemi için formu submit et
                document.querySelector(`#deleteForm_${Id}`).submit();
            } else {
                return false; // İşlemi iptal et
            }
        }

    </script>

    @include('layouts.setting')
    @include('layouts.script')

</body>


</html>
