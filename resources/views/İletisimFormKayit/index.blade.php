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
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h5 class="card-title" style="margin: 0;">İletişim Formu Verileri <span style="color: #ff1f1f;">Geçerli Form: {{$formName->FormName}}</span></h5>
                            <div>
                                <a href="{{ route('excele-aktar', ['veri' => $formName->FormId, 'select' => 0]) }}" class="btn btn-outline-danger">Excel'e Aktar</a>
                                <a href="{{ route('pdf-aktar', ['veri' => $formName->FormId, 'select' => 0]) }}" class="btn btn-outline-primary" id="pdfAktarButton">PDF'e Aktar</a>
                                <!--<a href="" class="btn btn-outline-warning">Toplu Mail Gönder</a>-->
                            </div>
                        </div>
                    </div>
                        @include('errors')
                        <div class="card-body table-responsive">
                            <!-- Uyarı mesajı -->
                            <table class="table table-bordered" style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr>
                                        @foreach($formAlanları as $formAlan)
                                            <th>{{$formAlan->AlanName}}</th>
                                        @endforeach
                                        <th class="align-middle">Durum 
                                            <select class="ms-1" id="statusFilter">
                                                <option value="">Hepsi</option>
                                                <option value="1">İncelendi</option>
                                                <option value="0">İncelenmedi</option>
                                            </select>
                                        <th>Sil</th>
                                        <th>İncele</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($forms as $form)
                                        <tr>
                                            @for($i=1; $i<=$formAlanları->count();$i++)
                                                <td class="align-middle">
                                                    @if($form['column' . $i] && $formAlanları[$i - 1]->AlanType == 'file')
                                                        <a href="{{ asset($form['column' . $i]) }}" target="_blank">
                                                            Dosya Görüntüle
                                                        </a>
                                                    @else
                                                        {{ $form['column' . $i] }}
                                                    @endif
                                                </td>
                                            @endfor
                                            <td class="align-middle" style="max-width: 50px;">
                                                @if($form->status==0)
                                                    <span data-status="0">İncelenmedi</span>
                                                @else
                                                    <span data-status="1">İncelendi</span>
                                                @endif
                                            </td>
                                            <td class="align-middle">
                                                <form
                                                    action="{{ route('forms.destroy', $form->id) }}"
                                                    method="POST" id="deleteForm_{{ $form->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger"
                                                        onclick="deleteFormAlan({{ $form->id }})">Sil</button>
                                                </form>
                                            </td>
                                            <td class="align-middle">
                                                <a href="{{ route('forms.edit', $form->id) }}"
                                                    class="btn btn-success">İncele</a>
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
    <script>
        function deleteFormAlan(formId) {
            if (confirm('Emin misiniz? Form alanı silindiğinde geri alınamaz.')) {
                document.getElementById('deleteForm_' + formId).submit();
            }
        }
        $(document).ready(function () {
            $("#statusFilter").change(function () {
                filterTable();
            });

            function filterTable() {
                var selectedStatus = $("#statusFilter").val();
                var statusColumnIndex = $("thead th").length - 3; // Sondan üçüncü sütunun indeksi (sıfır tabanlı indexleme)

                $("tbody tr").each(function () {
                    var rowContent = $(this).find("td:eq(" + statusColumnIndex + ") span").text();
                    var rowStatus = $(this).find("td:eq(" + statusColumnIndex + ") span").data("status");

                    if (selectedStatus === "" || rowStatus == selectedStatus) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            }
        });
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
    <script>
    // Sayfa yüklendiğinde ve select elementi değiştiğinde çalışacak kod
    window.addEventListener('DOMContentLoaded', function () {
        var selectElement = document.getElementById('statusFilter');
        var pdfAktarButton = document.getElementById('pdfAktarButton');
        var exceleAktarLink = document.querySelector('.btn-outline-danger');
        var formId = "{{$formName->FormId}}"; // Form ID'sini alın

        // Select elementi değiştiğinde
        selectElement.addEventListener('change', function () {
            updateButtonsHref(); // Butonların href'ini güncelle
        });

        // Sayfa yüklendiğinde
        updateButtonsHref();

        function updateButtonsHref() {
            var selectedValue = selectElement.value;
            if (selectedValue === "") {
                selectedValue = "all"; // veya başka bir değer atayın
            }
            // "PDF'e Aktar" butonunun href'sini güncelle
            pdfAktarButton.href = "{{ route('pdf-aktar', ['veri' => $formName->FormId]) }}/" + selectedValue;

            // "Excel'e Aktar" butonunun href'sini güncelle
            exceleAktarLink.href = "{{ route('excele-aktar', ['veri' => $formName->FormId]) }}/" + selectedValue;
        }
    });
</script>

    @include('layouts.setting')
    @include('layouts.script')

</body>


</html>
