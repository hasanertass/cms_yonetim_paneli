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
                            <h5 class="card-title">Bölüm Listesi</h5>
                            <h6> -> Bağlı Olduğu Sayfa : {{ $pageName->title }}</h6>
                        </div>
                        @include('errors')
                        <div class="table-responsive ">
                            <table class="table table-bordered"
                                style="text-align: center; width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr>
                                        <th>Bölüm Adı/Başlığı</th>
                                        <th>Bölüm Sırası </th>
                                        <th>Sil</th>
                                        <th>Düzenle</th>
                                        <th>İçerik Ayarları</th>
                                        <th>Yayın Durumu</th>
                                    </tr>
                                </thead>
                                <tbody id="sortable-list" class="sortable-table">
                                    @foreach($sections as $section)
                                        <tr data-section-id="{{ $section->section_id }}">
                                            <td>{{ $section->section_name }}</td>
                                            <td>{{ $section->section_row }}</td>
                                            <td class="align-middle">
                                                <form
                                                    action="{{ route('section.destroy', $section->section_id) }}"
                                                    method="POST" id="deleteForm_{{ $section->section_id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"
                                                        onclick="return confirmDelete({{ $section->section_id }})">Sil</button>
                                                </form>
                                            </td>
                                            <td>
                                                <a href="{{ route('section.edit', $section->section_id) }}"
                                                    class="btn btn-success">Düzenle</a>
                                            </td>
                                            <td>
                                                <a href="{{ route('section.setting', $section->section_id) }}"
                                                    class="btn btn-info">Değiştir</a>
                                            </td>
                                            <td>
                                                <form
                                                    action="{{ route('section.status', $section->section_id) }}"
                                                    method="post">
                                                    @csrf
                                                    <input type="hidden" name="_method" value="PATCH">
                                                    @if( $section->section_status == 0)
                                                        @method('Post')
                                                        <button type="submit"
                                                            class="btn btn-outline-info">Yayınla</button>
                                                    @else
                                                        @method('Post')
                                                        <button type="submit" class="btn btn-outline-warning">Yayından
                                                            Kaldır</button>
                                                    @endif
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <a href="{{ route('section.create') }}" class="btn btn-primary">Yeni Bölüm
                            Ekle</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Silme işlemi için onay sorusu göster
        function confirmDelete(Id) {
            if (confirm(
                    'Emin misiniz? Bölüm bilgileri silindiğinde bölümün content içeriği de silinir ve geri alınamaz.'
                )) {
                // Silme işlemi için formu submit et
                document.querySelector(`#deleteForm_${Id}`).submit();
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
                        sortedMenuIds.push($(this).data("section-id"));
                    });

                    // AJAX isteği ile sıralama değişikliklerini veritabanına kaydet
                    $.ajax({
                        url: "{{ route('update-section-order') }}",
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
