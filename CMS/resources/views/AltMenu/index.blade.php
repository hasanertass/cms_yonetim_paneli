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
                            <h5 class="card-title">Alt Menü Listesi</h5>
                            <h6> -> Bağlı Olduğu Menü : {{ $ustMenu->MenuAdı }}</h6>
                        </div>
                        <div class="card-body table-responsive">
                            <!-- Uyarı mesajı -->
                            @if($hasDuplicateAlanSirası)
                                <div class="alert alert-danger">Alt menü sırası aynı olan alt menüler bulunuyor! Lütfen
                                    alt menü
                                    sıralarını tekrardan kontrol ediniz.</div>
                            @endif
                            @include('errors')
                            <table class="table table-bordered" style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr>
                                        <th>Alt Menü Adı</th>
                                        <th>Alt Menü Sırası</th>
                                        <th>Alt Menü Link Adresi</th>
                                        <th>Link Açılma Yönetmi</th>
                                        <th>Sil</th>
                                        <th>Düzenle</th>
                                    </tr>
                                </thead>
                                <tbody id="sortable-list">
                                    @foreach($altMenu as $altMenus)
                                        @if($altMenus)
                                            <tr data-menu-id="{{ $altMenus->ItemId }}">
                                                <td>{{ $altMenus->ItemAdı }}</td>
                                                <td>{{ $altMenus->ItemSırası }}</td>
                                                <td>{{ $altMenus->ItemLink }}</td>
                                                <td>
                                                    @if($altMenus->link_open=='same')
                                                        Mevcut Sayfa
                                                    @else
                                                        Yeni Sayfada
                                                    @endif
                                                </td>
                                                <td>
                                                    <form
                                                        action="{{ route('altmenu.destroy', $altMenus->ItemId) }}"
                                                        method="POST" id="deleteForm_{{ $altMenus->ItemId }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger"
                                                            onclick="return confirmDelete({{ $altMenus->ItemId }})">Sil
                                                        </button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <a href="{{ route('altmenu.edit', $altMenus->ItemId) }}"
                                                        class="btn btn-success">Düzenle</a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#addMenuModal">
                            Yeni Alt Menü Ekle
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Yeni menü ekleme modalı -->
    <div class="modal fade" id="addMenuModal" tabindex="-1" aria-labelledby="addMenuModalLabel" aria-hidden="true">
        @include('AltMenu.create')
    </div>
    <script>
        // menü ekleme 
        $(document).ready(function () {
            $('#menuForm').submit(function (event) {
                event.preventDefault();
                const formData = new FormData(this);

                fetch(this.action, {
                        method: 'POST',
                        body: formData
                    }).then(response => response.json())
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
        });

    </script>
    <script>
        // Güncelleme butonuna tıklanınca modalı aç ve ilgili menü bilgilerini doldur
        document.querySelectorAll('.btn-update').forEach(btn => {
            btn.addEventListener('click', function () {
                const menuId = this.getAttribute('data-menu-id');

                // Sunucudan verileri almak için fetch kullanalım
                fetch(`/menu/${menuId}/edit`)
                    .then(response => response.json())
                    .then(menu => {
                        // Modal içindeki alanları doldur
                        const modal = document.getElementById('editMenuModal');
                        modal.querySelector('#editMenuAdı').value = menu.MenuAdı;
                        modal.querySelector('#editMenuSırası').value = menu.MenuSırası;
                        modal.querySelector('#editMenuLink').value = menu.MenuLink;

                        document.getElementById('saveChangesBtn').setAttribute('data-menu-id',
                            menuId);
                        // Modalı aç
                        const bsModal = new bootstrap.Modal(modal);
                        bsModal.show();
                    })
                    .catch(error => {
                        console.error('Hata:', error);
                        alert(error);
                    });
            });
        });

    </script>
    <script>
        // Silme işlemi için onay sorusu göster
        function confirmDelete(ItemId) {
            if (confirm('Emin misiniz? Alt menü silindiğinde geri alınamaz.')) {
                // Silme işlemi için formu submit et
                document.querySelector(`#deleteForm_${ItemId}`).submit();
            } else {
                return false; // İşlemi iptal et
            }
        }

    </script>
    <script>
        function reloadPage() {
            location.reload(true); // Sayfanın yeniden yüklenmesi
        }

    </script>
    <script>
        $(document).ready(function () {
            $("#sortable-list").sortable({
                update: function (event, ui) {
                    var sortedMenuIds = [];
                    $(this).find("tr").each(function () {
                        sortedMenuIds.push($(this).data("menu-id"));
                    });

                    // AJAX isteği ile sıralama değişikliklerini veritabanına kaydet
                    $.ajax({
                        url: "{{ route('update-altmenu-order') }}",
                        method: "POST",
                        data: {
                            menuIds: sortedMenuIds,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            if (response.success) {
                                reloadPage();
                            } else {
                                console.error("Veritabanı güncelleme hatası: " +
                                    response.error);
                            }
                        }
                    });
                }
            });
        });

    </script>
    @include('layouts.setting')
    @include('layouts.script')

</body>


</html>
