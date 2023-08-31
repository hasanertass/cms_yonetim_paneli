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
                            <h5 class="card-title">İletişim Form Listesi</h5>
                        </div>
                        @include('errors')
                        <div class="card-body table-responsive">
                            <!-- Uyarı mesajı -->
                            <table class="table table-bordered" style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr>
                                        <th>Form İd</th>
                                        <th>Form Adı</th>
                                        <th>Form Sayfası</th>
                                        <th>Sil</th>
                                        <th>Güncelle</th>
                                        <th>Form Alanlarını Oluştur</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @foreach($iletisimForms as $iletisimForm)
                                        <tr>
                                            <td>{{ $iletisimForm->FormId }}</td>
                                            <td>{{ $iletisimForm->FormName }}</td>
                                            <td>{{ $iletisimForm->sayfa->title }}</td>
                                            <td>
                                                <form
                                                    action="{{ route('iletisimform.destroy', $iletisimForm->FormId) }}"
                                                    method="POST" id="deleteForm_{{ $iletisimForm->FormId }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"
                                                        onclick="return confirmDelete({{ $iletisimForm->FormId }})">Sil
                                                    </button>
                                                </form>
                                            </td>
                                            <td>
                                                <a href="{{ route('iletisimform.edit', $iletisimForm->FormId) }}"
                                                    class="btn btn-success">Güncelle</a>
                                            </td>
                                            <td>
                                                <a href="{{ route('iletisimformalanları.show', $iletisimForm->FormId) }}"
                                                    class="btn btn-outline-info">Form Alanları</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#addFormModal">
                            Yeni Form Ekle
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Yeni form ekleme modalı -->
    <div class="modal fade" id="addFormModal" tabindex="-1" aria-labelledby="addFormModalLabel" aria-hidden="true">
        @include('iletisimForm.create')
    </div>


    <script>
        // Silme işlemi için onay sorusu göster
        function confirmDelete(FormId) {
            if (confirm('Emin misiniz? Formu sildiğinizde forma ait alanlarda silinir ve geri alınamaz.')) {
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
