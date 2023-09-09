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
                            <h5 class="card-title">Hizmetler Bölüm Bilgileri</h5>
                        </div>
                        @include('errors')
                        <div class="table-responsive ">
                            <table class="table table-bordered"
                                style="text-align: center; width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr>
                                        <th>Başlık</th>
                                        <th>Kısa Açıklama</th>
                                        <th>Detay Açıklama</th>
                                        <th>İcon</th>
                                        <th>Mini Görsel</th>
                                        <th>Detay Görsel</th>
                                        <th>Sil</th>
                                        <th>Düzenle</th>
                                        <th>Durum</th>
                                        <th>Ana Sayfa Durum</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($services as $service)
                                        <tr>
                                            <td class="align-middle">{{ $service->title }}</td>
                                            <td class="align-middle">{{ $service->short_description }}</td>
                                            <td class="align-middle" style="max-width: 300px;">{!!
                                                Str::limit(strip_tags($service->long_description), 65) !!}</td>
                                            <td class="align-middle"><i class="{{ $service->icon }}"
                                                    style="font-size: 50px;"></i></td>
                                            <td class="align-middle" style="width: 150px;"><img
                                                    src="{{ asset($service->small_image) }}" alt="Hizmet Görsel"
                                                    width="150px" height="150px"></td>
                                            @if($service->large_image=='')
                                                <td class="align-middle">
                                                    <p style="color: red;">Veri Yok</p>
                                                </td>
                                            @else
                                                <td class="align-middle" style="width: 150px;"><img
                                                        src="{{ asset($service->large_image) }}" alt="Hizmet Görsel"
                                                        width="150px" height="150px"></td>
                                            @endif
                                            <td class="align-middle">
                                                <form
                                                    action="{{ route('service.destroy', $service->id) }}"
                                                    method="POST" id="deleteForm_{{ $service->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"
                                                        onclick="return confirmDelete({{ $service->id }})">Sil</button>
                                                </form>
                                            </td>
                                            <td class="align-middle">
                                                <a href="{{ route('service.edit', ['service' => $service->id]) }}"
                                                    class="btn btn-success">Düzenle</a>
                                            </td>
                                            <form
                                                action="{{ route('service.status', $service->id) }}"
                                                method="POST">
                                                @csrf
                                                <td style="width: 120px;" class="align-middle">
                                                    <button type="submit"
                                                        class="btn btn-outline-{{ $service->status == '0' ? 'info' : 'warning' }}">
                                                        {{ $service->status == '0' ? 'Aktif Yap' : 'Pasif Yap' }}
                                                    </button>
                                                </td>
                                            </form>
                                            <form
                                                action="{{ route('service.home_page_status', $service->id) }}"
                                                method="POST">
                                                @csrf
                                                <td style="width: 120px;" class="align-middle">
                                                    <button type="submit"
                                                        class="btn btn-outline-{{ $service->home_page_status == '0' ? 'info' : 'warning' }}">
                                                        {{ $service->home_page_status == '0' ? 'Kullan' : 'Pasif Yap' }}
                                                    </button>
                                                </td>
                                            </form>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <a href="{{ route('service.create') }}" class="btn btn-primary">Yeni Hizmet
                            Ekle</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Silme işlemi için onay sorusu göster
        function confirmDelete(Id) {
            if (confirm('Emin misiniz? Hizmet bilgileri silindiğinde geri alınamaz.')) {
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
