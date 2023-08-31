<style>
    .vertical-table {
        display: flex;
        flex-direction: column;
        border: 1px solid #ccc;
        max-width: 300px;
        /* İsteğe bağlı genişlik */
    }

    .table-row {
        display: flex;
        border-bottom: 1px solid #ccc;
    }

    .table-header,
    .table-data {
        padding: 10px;
        flex: 1;
        text-align: left;
    }

    .table-header {
        font-weight: bold;
        background-color: #f1f1f1;
    }

</style>
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
                            <h5 class="card-title">Hakkımızda Bölüm Bilgileri</h5>
                        </div>
                        @include('errors')
                        <div class="table-responsive ">
                            <table class="table table-bordered"
                                style="text-align: center; width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr>
                                        <th>Görsel</th>
                                        <th>Mini Görsel </th>
                                        <th>Başlık</th>
                                        <th>Açıklama</th>
                                        <th>Açıklama 2</th>
                                        <th>Özellikler</th>
                                        <th>Sil</th>
                                        <th>Düzenle</th>
                                        <th>Kullanım Durumu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($abouts as $about)
                                        <tr>
                                            <td class="align-middle"><img src="{{ asset($about->görsel) }}"
                                                    alt="Haber Görsel" width="150px" height="150px">
                                            </td>
                                            <td class="align-middle"
                                                style="max-width: 200px; overflow: hidden; text-overflow: ellipsis;">
                                                @if($about->görsel2)
                                                    <img src="{{ asset($about->görsel2) }}" alt="Haber Görsel"
                                                        width="150px" height="150px">
                                                @else
                                                    Görsel Eklenmemiş
                                                @endif
                                            </td>
                                            <td class="align-middle"
                                                style="max-width: 200px; overflow: hidden; text-overflow: ellipsis;">
                                                {{ $about->baslik }}
                                            </td>
                                            <td class="align-middle">{{ $about->aciklama1 }}</td>
                                            <td class="align-middle">{{ $about->aciklama2 }}</td>
                                            <td class="align-middle">
                                                @for($i = 1; $i <= 8; $i++)
                                                    @if( $about['prop' . $i] )
                                                        <i class="fa fa-check-circle-o"
                                                            aria-hidden="true">{{ $about['prop' . $i] }}
                                                        </i>
                                                        <br><br>
                                                    @endif                                                    
                                                @endfor
                                            </td>
                                            <td class="align-middle">
                                                <form
                                                    action="{{ route('about.destroy', $about->id) }}"
                                                    method="POST" id="deleteForm_{{ $about->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"
                                                        onclick="return confirmDelete({{ $about->id }})">Sil</button>
                                                </form>
                                            </td>
                                            <td class="align-middle">
                                                <a href="{{ route('about.edit', $about->id) }}"
                                                    class="btn btn-success">Düzenle</a>
                                            </td>
                                            <td class="align-middle">
                                                <form
                                                    action="{{ route('about.kullanımdurumu', $about->id) }}"
                                                    method="post">
                                                    @csrf
                                                    <input type="hidden" name="_method" value="PATCH">
                                                    @if( $about->durum == 0)
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
                        <a href="{{ route('about.create') }}" class="btn btn-primary">Yeni Bilgi
                            Ekle</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Silme işlemi için onay sorusu göster
        function confirmDelete(Id) {
            if (confirm('Emin misiniz? Hakkımızda bilgileri silindiğinde geri alınamaz.')) {
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
