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
                            <h5 class="card-title">Menü Listesi</h5>
                        </div>
                        <div class="card-body table-responsive">
                            <!-- Uyarı mesajı -->
                            @if($hasDuplicateMenuSirası)
                                <div class="alert alert-danger">Menü sırası aynı olan menüler bulunuyor! Lütfen Menü
                                    sıralarını tekrardan kontrol ediniz.</div>
                            @endif
                            @include('errors')
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Menü Alanı</th>
                                        <th>Menü Adı</th>
                                        <th>Menü Sırası</th>
                                        <th>Menü Link Adresi</th>
                                        <th>Link Açılma Yöntemi</th>
                                        <th>Sil</th>
                                        <th>Düzenle</th>
                                        <th>Alt Menü Ekle</th>
                                    </tr>
                                </thead>
                                <tbody id="sortable-list" class="sortable-table">
                                    @foreach($menu as $menu)
                                        <tr data-menu-id="{{ $menu->MenuId }}">
                                            <td>{{ $menu->menuAlan->alan_name }}</td>
                                            <td>{{ $menu->MenuAdı }}</td>
                                            <td>{{ $menu->MenuSırası }}</td>
                                            <td>{{ $menu->MenuLink }}</td>
                                            <td>
                                                @if($menu->link_open=='same')
                                                    Mevcut Sayfa
                                                @else
                                                    Yeni Sayfada
                                                @endif
                                            </td>
                                            <td>
                                                <form
                                                    action="{{ route('menu.destroy', $menu->MenuId) }}"
                                                    method="POST" id="deleteForm_{{ $menu->MenuId }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"
                                                        onclick="return confirmDelete({{ $menu->MenuId }})">Sil
                                                    </button>
                                                </form>
                                            </td>
                                            <td>
                                                <a href="{{ route('menu.edit', $menu->MenuId) }}"
                                                    class="btn btn-success">Düzenle</a>
                                            </td>
                                            <td>
                                                <a href="{{ route('altmenu.show', $menu->MenuId) }}"
                                                    class="btn btn-success">Alt Menü</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#addMenuModal">
                            Yeni Menü Ekle
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Yeni menü ekleme modalı -->
    <div class="modal fade" id="addMenuModal" tabindex="-1" aria-labelledby="addMenuModalLabel" aria-hidden="true">
        @include('menu.create')
    </div>
    <script>
        // Silme işlemi için onay sorusu göster
        function confirmDelete(MenuId) {
            if (confirm('Emin misiniz? Menü silindiğinde menüye ait altmenülerde silinir. Unutmayın silinen veriler geri alınamaz.')) {
                // Silme işlemi için formu submit et
                document.querySelector(`#deleteForm_${MenuId}`).submit();
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
                        url: "{{ route('update-menu-order') }}",
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
