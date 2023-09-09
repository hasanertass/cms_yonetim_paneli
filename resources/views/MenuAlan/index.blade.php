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
                            <h5 class="card-title">Menü Alan Listesi</h5>
                        </div>
                        <div class="card-body table-responsive">
                            <!-- Uyarı mesajı -->
                            @include('errors')
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Menü Alan Adı</th>
                                        <th>Menüler</th>
                                        <th>Sil</th>
                                        <th>Düzenle</th>
                                        <th>Alt Menü Ekle</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($menualans as $menualan)
                                        <tr>
                                            <td>{{ $menualan->alan_name }}</td>
                                            <td>
                                                @foreach($menus as $menu)
                                                    @if($menu->alan_id==$menualan->alan_id)
                                                        <i class="fa fa-check-circle-o"
                                                            aria-hidden="true">{{ $menu->MenuAdı }}
                                                        </i>
                                                        <br>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                <form
                                                    action="{{ route('menualan.destroy', $menualan->alan_id) }}"
                                                    method="POST" id="deleteForm_{{ $menualan->alan_id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"
                                                        onclick="return confirmDelete({{ $menualan->alan_id }})">Sil
                                                    </button>
                                                </form>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-success btn-update-menu"
                                                    data-menu-id="{{ $menualan->alan_id }}">Düzenle</button>
                                            </td>
                                            <td>
                                                <a href="{{ route('menu.show', $menualan->alan_id) }}"
                                                    class="btn btn-success">Menüler</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#addMenuModal">
                            Yeni Menü Alanı Ekle
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Yeni menü ekleme modalı -->
    <div class="modal fade" id="addMenuModal" tabindex="-1" aria-labelledby="addMenuModalLabel" aria-hidden="true">
        @include('menualan.create')
    </div>
    <div class="modal fade" id="editMenuModal" tabindex="-1" aria-labelledby="editMenuModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editMenuModalLabel">Menüyü Düzenle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editMenuForm" action="" method="POST">
                    <div class="modal-body">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="menu_name">Menü Adı</label>
                            <input type="text" class="form-control" id="menu_name" name="menu_name" value="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                        <button type="submit" id="saveMenuChangesBtn" class="btn btn-primary">Değişiklikleri
                            Kaydet</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.querySelectorAll('.btn-update-menu').forEach(btn => {
            btn.addEventListener('click', function () {
                const menuId = this.getAttribute('data-menu-id');
                // Sunucudan verileri almak için fetch kullanalım
                fetch(`/menualan/${menuId}/edit`)
                    .then(response => response.json())
                    .then(menualan => {
                        // Modal içindeki alanları doldur
                        const modal = document.getElementById('editMenuModal');
                        modal.querySelector('#menu_name').value = menualan.alan_name;
                        // Diğer alanları doldurabilirsiniz

                        // Formun action URL'sini güncelleyin
                        const editMenuForm = document.getElementById('editMenuForm');
                        editMenuForm.action = `/menualan/${menuId}`;

                        // Modalı aç
                        const bsModal = new bootstrap.Modal(modal);
                        bsModal.show();
                    })
                    .catch(error => {
                        console.error('Hata:', error);
                        alert('Menü bilgileri alınırken bir hata oluştu. Lütfen tekrar deneyin.');
                    });
            });
        });

    </script>
    <script>
        // menü ekleme 
        document.getElementById('menuForm').addEventListener('submit', function (event) {
            event.preventDefault();
            const formData = new FormData(this);

            fetch(this.action, {
                    method: 'POST',
                    body: formData
                }).then(response => response.text())
                .then(data => {
                    alert('Menü başarıyla eklendi.');
                    document.getElementById('menuForm').reset();
                    window.location.reload();
                })
                .catch(error => {
                    console.error('Hata:', error);
                    alert('Menü eklenirken bir hata oluştu. Lütfen tekrar deneyin.');
                });
        });

    </script>
    <script>
        // Silme işlemi için onay sorusu göster
        function confirmDelete(MenuId) {
            if (confirm(
                    'Emin misiniz? Menü alanı silindiğinde bu alana bağlı bütün menüler ve menülere bağlı alt menülerde silineceketir. Unutmayın silinen veriler geri alınamaz.'
                )) {
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
