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
                            <h5 class="card-title">Markalar</h5>
                        </div>
                        @include('errors')
                        <div class="card-body">
                            <table class="table table-bordered" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Marka Adı</th>
                                        <th>Marka Logosu</th>
                                        <th>Sil</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($markalar as $marka)
                                        <tr>
                                            <td>{{ $marka->MarkaName }}</td>
                                            <td width="55px" height="50px"><img src="{{ asset($marka->MarkaLogo) }}" alt="..."
                                                    width="50px" height="50px">
                                            </td>
                                            <td style="width: 200px;">
                                                <!-- Sil butonu -->
                                                <form
                                                    action="{{ route('marka.destroy', $marka->Id) }}"
                                                    method="POST" id="deleteForm_{{ $marka->Id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" style="display: inline-block; width: 100%;"
                                                        onclick="return confirmDelete({{ $marka->Id }})">Sil</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#addMarkaModal">
                            Yeni Marka Ekle
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Yeni marka ekleme modalı -->
    <div class="modal fade" id="addMarkaModal" tabindex="-1" aria-labelledby="addMarkaModalLabel" aria-hidden="true">
        @include('Marka.create')
    </div>
    <script>
        // Silme işlemi için onay sorusu göster
        function confirmDelete(markaId) {
            if (confirm('Emin misiniz? icon silindiğinde geri alınamaz.')) {
                // Silme işlemi için formu submit et
                document.querySelector(`#deleteForm_${markaId}`).submit();
            } else {
                return false; // İşlemi iptal et
            }
        }
    </script>

    @include('layouts.setting')
    @include('layouts.script')

</body>


</html>
