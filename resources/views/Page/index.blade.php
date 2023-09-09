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
                        <div class="card-header">Sayfa Listesi</div>
                        <div class="table-responsive ">
                            @include('errors')
                            <table class="table table-bordered"
                                style="text-align: center; width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr>
                                        <th>Sayfa Adı/Başlığı</th>
                                        <th>Sayfa URL </th>
                                        <th>Meta Başlık </th>
                                        <th>Meta Açıklama </th>
                                        <th>Meta Açıklama </th>
                                        <th>İçerik İşlemleri</th>
                                        <th>Sil</th>
                                        <th>Düzenle</th>
                                        <th>Kullanım Durumu</th>
                                        <th>Ana Sayfa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pages as $page)
                                        <tr>
                                            <td>{{ $page->title }}</td>
                                            <td>{{ $page->slug }}</td>
                                            <td>{{ $page->meta_title }}</td>
                                            <td>{{ $page->meta_description }}</td>
                                            <td>{{ $page->meta_keywords }}</td>
                                            <td>
                                                <a href="{{ route('section.show', $page->sayfa_id) }}"
                                                    class="btn btn-info">İçerikler</a>
                                            </td>
                                            <td class="align-middle">
                                                <form
                                                    action="{{ route('page.destroy', $page->sayfa_id) }}"
                                                    method="POST" id="deleteForm_{{ $page->sayfa_id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"
                                                        onclick="return confirmDelete({{ $page->sayfa_id }})">Sil</button>
                                                </form>
                                            </td>
                                            <td>
                                                <a href="{{ route('page.edit', $page->sayfa_id) }}"
                                                    class="btn btn-success">Düzenle</a>
                                            </td>
                                            <td>
                                                <form
                                                    action="{{ route('page.yayindurumu', $page->sayfa_id) }}"
                                                    method="post">
                                                    @csrf
                                                    <input type="hidden" name="_method" value="PATCH">
                                                    @if( $page->yayin_durumu == 0)
                                                        @method('Post')
                                                        <button type="submit"
                                                            class="btn btn-outline-info">Yayınla</button>
                                                    @else
                                                        @method('Post')
                                                        <button type="submit" class="btn btn-outline-warning">Yayından
                                                            Kaldır</button>
                                                    @endif
                                                </form>
                                            </td>
                                            <td>
                                                <form
                                                    action="{{ route('page.anasayfa',$page->sayfa_id) }}"
                                                    method="post">
                                                    @csrf
                                                    <input type="hidden" name="_method" value="PATCH">
                                                    @if($page->AnaSayfa==1)
                                                        @method('post')
                                                        <button type="submit" class="btn btn-outline-warning">Geçerli
                                                            Anasayfa</button>
                                                    @else
                                                        @method('Post')
                                                        <button type="submit" class="btn btn-outline-info">
                                                            AnaSayfa Olarak Ayarla</button>
                                                    @endif
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <a href="{{ route('page.create') }}" class="btn btn-primary">Yeni Sayfa
                            Ekle</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Silme işlemi için onay sorusu göster
        function confirmDelete(Id) {
            if (confirm(
                    'Emin misiniz? Sayfa bilgileri silindiğinde sayfaya bağlı olan bütün bölümler ve içeriklerde silinir ve geri alınamaz.'
                )) {
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
