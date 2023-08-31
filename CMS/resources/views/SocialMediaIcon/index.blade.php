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
                    <div class="card" style="background-color: #f5f5f5;">
                        <div class="card-header">
                            <h5 class="card-title">Sosyal Medya</h5>
                        </div>
                        @include('errors')
                        <div>
                            <table class="table table-bordered" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>İcon</th>
                                        <th>Sosyal Medya Adı</th>
                                        <th>Link</th>
                                        <th>Sil</th>
                                        <th>Güncelle</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($icons as $icon)
                                        <tr>
                                            <td style="width: 60px;"><img style="text-align: center;" src="{{ asset($icon->Icon) }}" alt="..."
                                                    width="50px" height="50px"></td>
                                            <td>{{ $icon->Name }}</td>
                                            <td>{{ $icon->Link }}</td>
                                            <td>
                                                <!-- Sil butonu -->
                                                <form
                                                    action="{{ route('sosyalmedya.destroy', $icon->Id) }}"
                                                    method="POST" id="deleteForm_{{ $icon->Id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"
                                                        onclick="return confirmDelete({{ $icon->Id }})">Sil</button>
                                                </form>
                                            </td>
                                            <td>
                                                <!-- Güncelleme butonu -->
                                                <button type="button" class="btn btn-success btn-update"
                                                    data-ıcon-id="{{ $icon->Id }}">Düzenle</button>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#addIconModal">
                            Yeni İcon Ekle
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--  Icon düzenleme modalı -->
    <div class="modal fade" id="editIconModal" tabindex="-1" aria-labelledby="editIconModallabel" aria-hidden="true">
        @if(isset($icon))
            @include('SocialMediaIcon.edit')
        @endif
    </div>

    <!-- Yeni logo ekleme modalı -->
    <div class="modal fade" id="addIconModal" tabindex="-1" aria-labelledby="addIconModalLabel" aria-hidden="true">
        @include('SocialMediaIcon.create')
    </div>

    <script>
        // Güncelleme butonuna tıklanınca modalı aç ve ilgili logo bilgilerini doldur
        document.querySelectorAll('.btn-update').forEach(btn => {
            btn.addEventListener('click', function () {
                const iconId = this.getAttribute('data-ıcon-id');

                // Sunucudan verileri almak için fetch kullanalım
                fetch(`/sosyalmedya/${iconId}/edit`)
                    .then(response => response.json())
                    .then(icon => {
                        // Modal içindeki alanları doldur
                        const modal = document.getElementById('editIconModal');
                        modal.querySelector('#editIconName').value = icon.Name;
                        modal.querySelector('#editIconLink').value = icon.Link;
                        // Diğer alanları da doldurabilirsiniz (örneğin, Icon ve Link alanları)
                        
                        document.getElementById('saveChangesBtn').setAttribute('data-ıcon-id',
                            iconId);
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
        document.getElementById('iconForm').addEventListener('submit', function (event) {
            event.preventDefault();
            const formData = new FormData(this);

            fetch(this.action, {
                    method: 'POST',
                    body: formData
                }).then(response => response.text())
                .then(data => {
                    alert('İcon başarıyla eklendi.');
                    document.getElementById('iconForm').reset();
                    window.location.reload();
                })
                .catch(error => {
                    console.error('Hata:', error);
                    alert(error);
                });
        });

    </script>
    <script>
        // Silme işlemi için onay sorusu göster
        function confirmDelete(iconId) {
            if (confirm('Emin misiniz? icon silindiğinde geri alınamaz.')) {
                // Silme işlemi için formu submit et
                document.querySelector(`#deleteForm_${iconId}`).submit();
            } else {
                return false; // İşlemi iptal et
            }
        }

    </script>

    @include('layouts.setting')
    @include('layouts.script')

</body>


</html>
