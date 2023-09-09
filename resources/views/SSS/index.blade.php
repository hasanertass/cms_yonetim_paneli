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
                    <div class="card" >
                        <div class="card-header">
                            <h5 class="card-title">Sıkça Sorulan Sorular Listesi</h5>
                        </div>
                        @include('errors')
                        <table class="tale table-bordered" style="text-align: center; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Soru Sayfası</th>
                                    <th>Soru</th>
                                    <th>Cevap</th>
                                    <th>Soru Sırası</th>
                                    <th>Sil</th>
                                    <th>Düzenle</th>
                                    <th>Yayınlanma Durumu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sss as $sss)
                                    <tr>
                                        <td style="max-width: 150px; overflow: hidden; text-overflow: ellipsis;">
                                            <!-- white-space: nowrap stilini kaldırdık -->
                                            {{ $sss->soruSayfa->title }}
                                        </td>
                                        <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis;">
                                            <!-- white-space: normal yapmaya gerek yok -->
                                            {{ $sss->Soru }}
                                        </td>
                                        <td style="max-width: 400px; overflow: hidden; text-overflow: ellipsis;">
                                            <!-- white-space: normal yapmaya gerek yok -->
                                            {{ $sss->Cevap }}
                                        </td>
                                        <td>{{ $sss->Sira }}</td>

                                        <td class="align-middle">
                                            <form
                                                action="{{ route('sss.destroy', $sss->Id) }}"
                                                method="POST" id="deleteForm_{{ $sss->Id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"
                                                    onclick="return confirmDelete({{ $sss->Id }})">Sil</button>
                                            </form>
                                        </td>
                                        <td>
                                            <a href="{{ route('sss.edit', $sss->Id) }}"
                                                class="btn btn-success">Düzenle</a>
                                        </td>
                                        <td >
                                            @if( $sss->Durum == 0)
                                                <a href="{{ route('sss.durum', $sss->Id) }}"
                                                    class="btn btn-info">Aktif Yap</a>
                                            @else
                                                <a href="{{ route('sss.durum', $sss->Id) }}"
                                                    class="btn btn-warning">Pasif Yap</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <br>
                        <a href="{{ route('sss.create') }}" class="btn btn-primary">Yeni Soru Ekle</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Silme işlemi için onay sorusu göster
        function confirmDelete(MenuId) {
            if (confirm('Emin misiniz? Soru-Cevap silindiğinde geri alınamaz.')) {
                // Silme işlemi için formu submit et
                document.querySelector(`#deleteForm_${MenuId}`).submit();
            } else {
                return false; // İşlemi iptal et
            }
        }

    </script>

    @include('layouts.setting')
    @include('layouts.script')

</body>


</html>
