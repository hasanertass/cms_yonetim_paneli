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
                            <h5 class="card-title"><span style="color: red;">{{$form_name->sayfa->title}} <span style="color: black;"> Sayfası / </span> {{$form_name->FormName}}</span> Form Alanları Listesi</h5>
                        </div>
                        @if($hasDuplicateAlanSirası)
                            <div class="alert alert-danger">Alan sırası aynı olan alanlar bulunuyor! Lütfen alan
                                sıralarını tekrardan kontrol ediniz.</div>
                        @endif
                        @include('errors')
                        <div class="card-body table-responsive">
                            <!-- Uyarı mesajı -->
                            <table class="table table-bordered" style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr>
                                        <th>Alan Adı</th>
                                        <th>Pleace Holder (Formda Görünecek Ad)</th>
                                        <th>Alan Tipi</th>
                                        <th>Alan Sırası</th>
                                        <th>Sil</th>
                                        <th>Düzenle</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($iletisimFormAlanlar as $iletisimFormAlan)
                                        <tr>
                                            <td class="align-middle">{{ $iletisimFormAlan->AlanName }}</td>
                                            <td class="align-middle" style="max-width: 200px;">{{ $iletisimFormAlan->PleaceHolder }}</td>
                                            <td class="align-middle">{{ $iletisimFormAlan->AlanType }}</td>
                                            <td class="align-middle">{{ $iletisimFormAlan->AlanSırası }}</td>
                                            <td class="align-middle">
                                                <form
                                                    action="{{ route('iletisimformalanları.destroy', $iletisimFormAlan->AlanId) }}"
                                                    method="POST" id="deleteForm_{{ $iletisimFormAlan->AlanId }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger"
                                                        onclick="deleteFormAlan({{ $iletisimFormAlan->AlanId }})">Sil</button>
                                                </form>
                                            </td>
                                            <td>
                                                <a href="{{ route('iletisimformalanları.edit', $iletisimFormAlan->AlanId) }}"
                                                    class="btn btn-success">Düzenle</a>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#addFormAlanModal">
                            Yeni Alan Ekle
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Yeni alan ekleme modalı -->
    <div class="modal fade" id="addFormAlanModal" tabindex="-1" aria-labelledby="addFormAlanModalLabel"
        aria-hidden="true">
        @include('iletisimFormAlan.create')

    </div>
    <script>
        function deleteFormAlan(formId) {
            if (confirm('Emin misiniz? Form alanı silindiğinde geri alınamaz.')) {
                document.getElementById('deleteForm_' + formId).submit();
            }
        }

    </script>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Stil örnekleri - İstenilen şekilde düzenleyebilirsiniz */
        .form-details {
            background-color: #f9f9f9;
            padding: 5px;
            border: 1px solid #ddd;
        }

        .form-details table {
            
        }

        .form-details th,
        .form-details td {
            padding: 5px;
            border-bottom: 1px solid #ddd;
        }

    </style>

    @include('layouts.setting')
    @include('layouts.script')

</body>


</html>
