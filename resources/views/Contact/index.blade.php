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
                            <h5 class="card-title">Firma İletişim Bilgileri</h5>
                        </div>
                        @include('errors')
                        <div class="table-responsive ">
                            <table class="table table-bordered"
                                style="text-align: center; width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr>
                                        <th>Şirket Adı</th>
                                        <th>Kısa Adres </th>
                                        <th>Adres</th>
                                        <th>Mail</th>
                                        <th>Mail 2</th>
                                        <th>Telefon</th>
                                        <th>Telefon 2</th>
                                        <th>Çalışma Saatleri</th>
                                        <th>Harita</th>
                                        <th>Sil</th>
                                        <th>Düzenle</th>
                                        <th>Yayınlanma Durumu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($contacts as $contact)
                                        <tr>
                                            <td>{{ $contact->SirketAdi }}</td>
                                            <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis;">{{ $contact->Adres }}</td>
                                            <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis;">{{ $contact->Adres2 }}</td>
                                            <td>{{ $contact->Mail }}</td>
                                            <td>{{ $contact->Mail2 }}</td>
                                            <td>{{ $contact->Telefon }}</td>
                                            <td>{{ $contact->Telefon2 }}</td>
                                            <td>{{ $contact->work }}</td>
                                            <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis;">{{ $contact->Harita }}</td>
                                            <td class="align-middle">
                                                <form
                                                    action="{{ route('contact.destroy', $contact->Id) }}"
                                                    method="POST" id="deleteForm_{{ $contact->Id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"
                                                        onclick="return confirmDelete({{ $contact->Id }})">Sil</button>
                                                </form>
                                            </td>
                                            <td>
                                                <a href="{{ route('contact.edit', $contact->Id) }}"
                                                    class="btn btn-success">Düzenle</a>
                                            </td>
                                            <td>
                                                <form
                                                    action="{{ route('contact.kullanımdurumu', $contact->Id) }}"
                                                    method="post">
                                                    @csrf
                                                    <input type="hidden" name="_method" value="PATCH">
                                                    @if( $contact->KullanımDurumu == 0)
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
                        <a href="{{ route('contact.create') }}" class="btn btn-primary">Yeni Bilgi
                            Ekle</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Silme işlemi için onay sorusu göster
        function confirmDelete(Id) {
            if (confirm('Emin misiniz? İletişim bilgileri silindiğinde geri alınamaz.')) {
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
