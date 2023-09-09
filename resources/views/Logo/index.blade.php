<!--
=========================================================
* Argon Dashboard 2 - v2.0.4
=========================================================

* Product Page: https://www.creative-tim.com/product/argon-dashboard
* Copyright 2022 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
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
                            <h5 class="card-title">Logolar</h5>
                        </div>
                        @include('errors')
                        <div class="card-body">
                            <table class="table table-bordered" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Logo</th>
                                        <th>Logo Adı</th>
                                        <th>Logo Alternatif Metin</th>
                                        <th>Logo Yolu</th>
                                        <th>Sil</th>
                                        <th>Düzenle</th>
                                        <th>Kullan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($logos as $logo)
                                        <tr>
                                            <td style="width: 60px;"><img src="{{ asset($logo->FilePath) }}"
                                                    alt="{{ $logo->Alt_text }}" width="50px" height="50px"></td>
                                            <td>{{ $logo->Name }}</td>
                                            <td>{{ $logo->Alt_text }}</td>
                                            <td>{{ $logo->FilePath }}</td>
                                            <td>
                                                <!-- Sil butonu -->
                                                <form
                                                    action="{{ route('logo.destroy', $logo->Id) }}"
                                                    method="POST" id="deleteForm_{{ $logo->Id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"
                                                        onclick="return confirmDelete({{ $logo->Id }})">Sil</button>
                                                </form>
                                            </td>
                                            <td>
                                                <!-- Güncelleme butonu -->
                                                <button type="button" class="btn btn-success btn-update"
                                                    data-logo-id="{{ $logo->Id }}">Düzenle</button>

                                            </td>
                                            <td>
                                                <!-- Aktif hale getirme/pasif yapma butonu -->
                                                <form
                                                    action="{{ route('logo.activate', $logo->Id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <input type="hidden" name="_method" value="PATCH">
                                                    @if($logo->KullanimDurumu == 1)
                                                        @method('post')
                                                        <button type="submit" class="btn btn-outline-warning"
                                                            disabled>Kullanılan</button>
                                                    @else
                                                        @method('post')
                                                        <button type="submit" class="btn btn-outline-info">Kullan
                                                        </button>
                                                    @endif
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#addLogoModal">
                            Yeni Logo Ekle
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--  logo düzenleme modalı -->
    <div class="modal fade" id="editLogoModal" tabindex="-1" aria-labelledby="editLogoModalLabel" aria-hidden="true">
        @if(isset($logo))
            @include('logo.edit')
        @endif
    </div>

    <!-- Yeni logo ekleme modalı -->
    <div class="modal fade" id="addLogoModal" tabindex="-1" aria-labelledby="addLogoModalLabel" aria-hidden="true">
        @include('logo.create')
    </div>
    <script>
        // Güncelleme butonuna tıklanınca modalı aç ve ilgili logo bilgilerini doldur
        document.querySelectorAll('.btn-update').forEach(btn => {
            btn.addEventListener('click', function () {
                const logoId = this.getAttribute('data-logo-id');

                // Sunucudan verileri almak için fetch kullanalım
                fetch(`/logo/${logoId}/edit`)
                    .then(response => response.json())
                    .then(logo => {
                        // Modal içindeki alanları doldur
                        const modal = document.getElementById('editLogoModal');
                        modal.querySelector('#editLogoName').value = logo.Name;
                        modal.querySelector('#editLogoAltText').value = logo.Alt_text;

                        document.getElementById('saveChangesBtn').setAttribute('data-logo-id',
                            logoId);
                        // Modalı aç
                        const bsModal = new bootstrap.Modal(modal);
                        bsModal.show();
                    })
                    .catch(error => {
                        console.error('Hata:', error);
                        alert('Logo bilgileri alınırken bir hata oluştu. Lütfen tekrar deneyin.');
                    });
            });
        });

    </script>
    <script>
        // saveChangesBtn click olayı
        document.getElementById('saveChangesBtn').addEventListener('click', function () {
            const logoId = this.getAttribute('data-logo-id');
            const editLogoForm = document.getElementById('editLogoForm');
            const formData = new FormData(editLogoForm);
            formData.append('_token', '{{ csrf_token() }}');
            fetch(`/logo/${logoId}`, {
                    method: 'POST', // POST metodu ile sunucuya gönderiyoruz
                    headers: {
                        'X-HTTP-Method-Override': 'PATCH' // Sunucuya aslında PATCH işlemi olduğunu belirtiyoruz
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Logo güncellenirken bir hata oluştu.');
                    }
                    return response.json();
                })
                .then(data => {
                    // Başarılı sonuç aldıysak modalı kapat ve sayfayı yenile
                    const bsModal = bootstrap.Modal.getInstance(document.getElementById('editLogoModal'));
                    bsModal.hide();
                    window.location.reload();
                })
                .catch(error => {
                    console.error('Hata:', error);
                    alert(error.message);
                });
        });

    </script>

    <script>
        // Silme işlemi için onay sorusu göster
        function confirmDelete(logoId) {
            if (confirm('Emin misiniz? Logo silindiğinde geri alınamaz.')) {
                // Silme işlemi için formu submit et
                document.querySelector(`#deleteForm_${logoId}`).submit();
            } else {
                return false; // İşlemi iptal et
            }
        }

    </script>
    <script>
        document.getElementById('logoForm').addEventListener('submit', function (event) {
            event.preventDefault();
            const formData = new FormData(this);

            fetch(this.action, {
                    method: 'POST',
                    body: formData
                }).then(response => response.text())
                .then(data => {
                    alert('Logo başarıyla eklendi.');
                    document.getElementById('logoForm').reset();
                    window.location.reload();
                })
                .catch(error => {
                    console.error('Hata:', error);
                    alert(error);
                });
        });

    </script>
    @include('layouts.setting')
    @include('layouts.script')
</body>


</html>
