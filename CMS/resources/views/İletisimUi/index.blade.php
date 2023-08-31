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
                            <h5 class="card-title">İletişim Bilgileri</h5>
                        </div>
                        @include('errors')
                        <div class="card-body table-responsive">
                            <!-- Uyarı mesajı -->
                            <table class="table table-bordered" style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr>
                                        <th>Başlık</th>
                                        <th>Açıklama</th>
                                        <th>Form Adı</th>
                                        <th>Form Alanlarını Göster</th>
                                        <th>Sil</th>
                                        <th>Güncelle</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($iletisimler as $iletisim)
                                        <tr>
                                            
                                            <td>{{ $iletisim->title }}</td>
                                            <td>{{ $iletisim->description }}</td>
                                            <td>{{ $iletisim->form_name->FormName }}</td>
                                            <td>
                                                <a href="{{ route('iletisimformalanları.show', $iletisim->contact_form) }}"
                                                    class="btn btn-success">Göster</a>
                                            </td>
                                            <td>
                                                <form
                                                    action="{{ route('iletisimsection.destroy', $iletisim->id) }}"
                                                    method="POST" id="deleteForm_{{ $iletisim->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"
                                                        onclick="return confirmDelete({{ $iletisim->id }})">Sil
                                                    </button>
                                                </form>
                                            </td>
                                            <td>
                                                <a href="{{ route('iletisimsection.edit', $iletisim->id) }}"
                                                    class="btn btn-success">Güncelle</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <a href="{{ route('iletisimsection.create') }}" class="btn btn-primary">Yeni Bilgi
                            Ekle</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Silme işlemi için onay sorusu göster
        function confirmDelete(FormId) {
            if (confirm('Emin misiniz? İletişim Bilgilerini sildiğinizde geri alınamaz.')) {
                // Silme işlemi için formu submit et
                document.querySelector(`#deleteForm_${FormId}`).submit();
            } else {
                return false; // İşlemi iptal et
            }
        }

    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Stil örnekleri - İstenilen şekilde düzenleyebilirsiniz */
        .form-details {
            background-color: #f9f9f9;
            padding: 10px;
            border: 1px solid #ddd;
        }

        .form-details table {
            width: 100%;
        }

        .form-details th,
        .form-details td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

    </style>

    @include('layouts.setting')
    @include('layouts.script')

</body>


</html>
