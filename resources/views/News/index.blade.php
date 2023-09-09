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
                            <h5 class="card-title">Haberler Sayfası Bilgileri</h5>
                        </div>
                        @include('errors')
                        <div class="table-responsive ">
                            <table class="table table-bordered" style="text-align: center; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Görsel</th>
                                        <th>Büyük Görsel</th>
                                        <th>Başlık</th>
                                        <th>Kısa Açıklama</th>
                                        <th>Açıklama</th>
                                        <th>Tarih</th>
                                        <th>Link</th>
                                        <th>Sil</th>
                                        <th>Düzenle</th>
                                        <th>Durum</th>
                                        <th>Ana Sayfa Durum</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($news as $news)
                                        <tr>
                                            <td class="align-middle" style="width: 150px;"><img
                                                    src="{{ asset($news->görsel) }}" alt="Haber Görsel"
                                                    width="150px" height="150px"></td>
                                            @if($news->görsel2=='')
                                                <td class="align-middle">
                                                    <p style="color: red;">Veri Yok</p>
                                                </td>
                                            @else
                                                <td class="align-middle" style="width: 150px;"><img
                                                        src="{{ asset($news->görsel2) }}" alt="Haber Görsel"
                                                        width="150px" height="150px"></td>
                                            @endif
                                            <td class="align-middle">{{ $news->baslik }}</td>
                                            <td class="align-middle">{{ $news->kisa_aciklama }}</td>
                                            @if($news->link=='')
                                                <td class="align-middle" style="max-width: 300px;"> {!!
                                                    Str::limit(strip_tags($news->aciklama), 65) !!}
                                                </td>
                                            @else
                                                <td class="align-middle">{{ $news->aciklama }}</td>
                                            @endif
                                            <td class="align-middle">{{ $news->tarih }}</td>
                                            @if($news->link=='')
                                                <td class="align-middle">
                                                    <p style="color: red;">Site İçi Bağlantı</p>
                                                </td>
                                            @else
                                                <td class="align-middle">{{ $news->link }}</td>
                                            @endif
                                            <td class="align-middle">
                                                <form
                                                    action="{{ route('news.destroy', $news->id) }}"
                                                    method="POST" id="deleteForm_{{ $news->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"
                                                        onclick="return confirmDelete({{ $news->id }})">Sil</button>
                                                </form>
                                            </td>
                                            <td class="align-middle">
                                                <a href="{{ route('news.edit', $news->id) }}"
                                                    class="btn btn-success">Düzenle</a>
                                            </td>                                            
                                            <form
                                                action="{{ route('news.status', $news->id) }}"
                                                method="POST">
                                                @csrf
                                                <td style="width: 120px;" class="align-middle">
                                                    <button type="submit"
                                                        class="btn btn-outline-{{ $news->status == '0' ? 'info' : 'warning' }}">
                                                        {{ $news->status == '0' ? 'Aktif Yap' : 'Pasif Yap' }}
                                                    </button>
                                                </td>
                                            </form>
                                            <form
                                                action="{{ route('news.home_page_status', $news->id) }}"
                                                method="POST">
                                                @csrf
                                                <td style="width: 120px;" class="align-middle">
                                                    <button type="submit"
                                                        class="btn btn-outline-{{ $news->home_page_status == '0' ? 'info' : 'warning' }}">
                                                        {{ $news->home_page_status == '0' ? 'Kullan' : 'Pasif Yap' }}
                                                    </button>
                                                </td>
                                            </form>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <a href="{{ route('news.create') }}" class="btn btn-primary">Yeni Haber
                            Ekle</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Silme işlemi için onay sorusu göster
        function confirmDelete(Id) {
            if (confirm('Emin misiniz? Haber içeriği silindiğinde geri alınamaz.')) {
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
