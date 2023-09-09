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
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">E bülten Abone Listesi</h5>
                            <h6 class="mb-0" style="color: #114ca2;">Toplam Abone Sayısı : {{ $toplamAbone }}</h6>
                            <h6 class="mb-0" style="color: #00a01d;">Toplam Aktif Abone Sayısı : {{ $aktifAbone }}</h6>
                            <h6 class="mb-0" style="color: #ff1f1f;">Toplam Pasif Abone Sayısı : {{ $pasifAbone }}</h6>
                        </div>
                        @include('errors')
                        <div class="card-body">
                            <table class="table table-bordered" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Mail Adresi <input class="ms-10" type="text" id="searchInput"
                                                placeholder="Filtrele"> </th>
                                        <th>Sil</th>
                                        <th>Durum <select class="ms-8" id="statusFilter">
                                                <option value="">Hepsi</option>
                                                <option value="1">Aktif</option>
                                                <option value="0">Pasif</option>
                                            </select></th>
                                        <th>Mail Gönder</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bultens as $bulten)
                                        <tr>
                                            <td class="align-middle" style="width: 650px;">{{ $bulten->mail }}</td>
                                            <td class="align-middle" style="width: 200px;">
                                                <!-- Sil butonu -->
                                                <form
                                                    action="{{ route('bulten.destroy', $bulten->id) }}"
                                                    method="POST" id="deleteForm_{{ $bulten->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-warning"
                                                        style="display: inline-block; width: 100%;"
                                                        onclick="return confirmDelete({{ $bulten->id }})">Sil</button>
                                                </form>
                                            </td>
                                            <td class="align-middle" style="width: 200px;">
                                                <form
                                                    action="{{ route('bulten.update', $bulten->id) }}"
                                                    method="post">
                                                    @csrf
                                                    <input type="hidden" name="_method" value="PATCH">
                                                    @if( $bulten->status == 0)
                                                        @method('PATCH')
                                                        <button type="submit"
                                                            style="display: inline-block; width: 100%;" data-status="0"
                                                            class="btn btn-success">Aktif Yap</button>
                                                    @else
                                                        @method('PATCH')
                                                        <button type="submit"
                                                            style="display: inline-block; width: 100%;" data-status="1"
                                                            class="btn btn-danger">
                                                            Pasif Yap</button>
                                                    @endif
                                                </form>
                                            </td>
                                            <td class="align-middle" style="width: 200px;">
                                                <!-- Mail Gönder butonu -->
                                                <button type="button" class="btn btn-primary"
                                                    id="sendMailModalbtn_{{ $bulten->id }}"
                                                    style="display: inline-block; width: 100%;" data-toggle="modal"
                                                    data-target="#sendMailModal_{{ $bulten->id }}">
                                                    Mail Gönder
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @foreach($bultens as $bulten)
        <!-- Modal -->
        <div class="modal fade" id="sendMailModal_{{ $bulten->id }}" tabindex="-1" role="dialog" aria-labelledby="sendMailModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="sendMailModalLabel">Mail Gönder</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form
                        action="{{ route('bulten.sendMail', ['id' => $bulten->id]) }}"
                        method="POST">
                        @csrf
                        @method('POST')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="current_password">Mail Adresi</label>
                                <input type="text" class="form-control" id="mail" value="{{ $bulten->mail }}"
                                    name="mail" required>
                            </div>
                            <div class="form-group">
                                <label for="subject">Konu</label>
                                <input type="text" class="form-control" id="subject" name="subject"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="message">Mesaj</label>
                                <textarea type="text" class="form-control" id="message" rows="5"
                                    name="message" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                            <button type="submit" class="btn btn-primary">Mail Gönder</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
    @foreach($bultens as $bulten)
        <script>
            $(document).ready(function () {
                // Initialize the password change modal
                $('#sendMailModal_{{ $bulten->id }}').modal();

                // Mail Gönder butonuna tıklandığında modalı aç
                $('#sendMailModalbtn_{{ $bulten->id }}').click(function () {
                    $('#sendMailModal_{{ $bulten->id }}').modal('show');
                });
            });
        </script>
    @endforeach
    <script>
        //Mail adresine göre filtreleme
        $(document).ready(function () {
            $("#searchInput").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                $("tbody tr").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
        // durum filtreleme
        $(document).ready(function () {
            $("#statusFilter").change(function () {
                filterTable();
            });

            function filterTable() {
                var selectedStatus = $("#statusFilter").val();
                $("tbody tr").each(function () {
                    var rowStatus = $(this).find("td:eq(2) button").data(
                        "status"); // 3. sütundaki (Durum) butonun data-status değeri alınır

                    if (selectedStatus === "" || rowStatus == selectedStatus) {
                        $(this).show(); // Durum seçilmedi veya durum uyuşuyorsa göster
                    } else {
                        $(this).hide(); // Durum uyuşmuyorsa gizle
                    }
                });
            }
        });

        // Silme işlemi için onay sorusu göster
        function confirmDelete(aboneId) {
            if (confirm('Emin misiniz? E-Bülten abone bilgisi silindiğinde geri alınamaz.')) {
                // Silme işlemi için formu submit et
                document.querySelector(`#deleteForm_${aboneId}`).submit();
            } else {
                return false; // İşlemi iptal et
            }
        }

    </script>

    @include('layouts.setting')
    @include('layouts.script')

</body>


</html>
