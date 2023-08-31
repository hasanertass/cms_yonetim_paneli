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
                        <form action="{{ route('admin.update',$admin->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="card-header pb-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="mb-0">Profil bilgileri</p>
                                    <div>
                                        <button type="submit" class="btn btn-primary btn-sm ms-1" onclick="return confirm('Bilgilerinizi değiştirmek istediğinize emin misiniz? Tamam butonuna tıklarsanız sayfada görmüş olduğunuz bilgiler bilgileriniz değiştirlecektir.')">Bilgileri
                                            Düzenle</button>
                                        <button type="button" id="passwordChangeModalBtn"
                                            class="btn btn-warning btn-sm ms-1" data-toggle="modal"
                                            data-target="#passwordChangeModal">
                                            Şifreyi Değiştir
                                        </button>
                                    </div>
                                </div>
                            </div>

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="card-body">
                                <p class="text-uppercase text-sm">Kişisel Bilgiler</p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Kullanıcı
                                                Adı</label>
                                            <input class="form-control" type="text" id="username" name="username"
                                                value="{{ $admin->username }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Mail
                                                Adresi</label>
                                            <input class="form-control" type="email" id="email" name="email"
                                                value="{{ $admin->email }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Ad</label>
                                            <input class="form-control" type="text" id="name" name="name"
                                                value="{{ $admin->name }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Soyad</label>
                                            <input class="form-control" type="text" id="lastname" name="lastname"
                                                value="{{ $admin->lastname }}">
                                        </div>
                                    </div>
                                </div>
                                <hr class="horizontal dark">
                                <p class="text-uppercase text-sm">İletişim Bilgileri</p>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Adres</label>
                                            <input class="form-control" type="text" id="address" name="address"
                                                value="{{ $admin->address }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">İl</label>
                                            <input class="form-control" type="text" id="city" name="city"
                                                value="{{ $admin->city }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">İlçe</label>
                                            <input class="form-control" type="text" id="county" name="county"
                                                value="{{ $admin->county }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="passwordChangeModal" tabindex="-1" role="dialog"
        aria-labelledby="passwordChangeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="passwordChangeModalLabel">Şifreyi Değiştir</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form
                    action="{{ route('admin.changePassword', ['id' => $admin->id]) }}"
                    method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="current_password">Eski Şifre</label>
                            <input type="password" class="form-control" id="current_password" name="current_password"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="new_password">Yeni Şifre</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                        </div>
                        <div class="form-group">
                            <label for="new_password_confirmation">Yeni Şifre Tekrar</label>
                            <input type="password" class="form-control" id="new_password_confirmation"
                                name="new_password_confirmation" required>
                            <small id="passwordMismatch" style="color: red; display: none;">Yeni şifreler
                                eşleşmiyor.</small>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                        <button type="submit" class="btn btn-primary" id="changePasswordButton">Şifreyi
                            Değiştir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        var newPasswordInput = document.getElementById('new_password');
        var newPasswordConfirmationInput = document.getElementById('new_password_confirmation');
        var passwordMismatchMessage = document.getElementById('passwordMismatch');
        var changePasswordButton = document.getElementById('changePasswordButton');



        newPasswordConfirmationInput.addEventListener('input', function () {
            if (newPasswordInput.value !== newPasswordConfirmationInput.value) {
                passwordMismatchMessage.style.display = 'block';
                changePasswordButton.disabled = true;
            } else {
                passwordMismatchMessage.style.display = 'none';
                changePasswordButton.disabled = false;
            }
        });

    </script>
    <script>
        $(document).ready(function () {
            // Initialize the password change modal
            $('#passwordChangeModal').modal();

            // Şifreyi Değiştir butonuna tıklandığında modalı aç
            $('#passwordChangeModalBtn').click(function () {
                $('#passwordChangeModal').modal('show');

            });

            // Modal kapatıldığında formu temizle
            $('#passwordChangeModal').on('hidden.bs.modal', function () {
                $('#passwordChangeForm')[0].reset();
            });
        });

    </script>
    @include('layouts.setting')
    @include('layouts.script')

</body>


</html>
