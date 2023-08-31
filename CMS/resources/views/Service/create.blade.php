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
                            <h5 class="card-title">Yeni Hizmet Bilgileri Ekleme Sayfası</h5>
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
                        <div class="card-body table-responsive">
                            <form action="{{ route('service.store') }}" method="POST">
                                @csrf<!-- CSRF koruması için gerekli alan -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3 form-group">
                                            <label for="title" class="form-label">Başlık</label>
                                            <input type="text" class="form-control" id="title"
                                                value="{{ old('title') }}" name="title" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3 form-group">
                                            <label for="icon" class="form-label">İkon Sınıfı</label>
                                            <div class="col-md-6 d-flex align-items-center gap-6">
                                                <input type="text" class="form-control" id="icon" name="icon"
                                                    onkeyup="updateIcon(this.value)">
                                                <i id="selected-icon" class="fa fa-star-o fa-fw"
                                                    style="font-size: 36px;"></i>
                                            </div>
                                            <button class="btn btn-primary form-control mt-2" type="button"
                                                onclick="showIconPicker()">İkon Seç</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="icon-grid mb-3" id="iconGrid" style="display: none;">
                                    @foreach($icons as $icon)
                                        <div class="icon-item" data-icon="{{ $icon->icon }}">
                                            <i class="{{ $icon->icon }}"></i>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Açıklama</label>
                                    <input type="text" class="form-control" id="description"
                                        value="{{ old('description') }}" name="description" required>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Kaydet</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            var selectedIconClass = ''; // Başlangıçta seçilen ikonun class'ını boş bir şekilde tanımla

            // İkon seçimine tıklandığında ve input değiştiğinde updateIcon fonksiyonunu çağır
            $('#iconGrid').on('click', '.icon-item', updateIcon);

            function updateIcon() {
                $('.icon-item').removeClass('selected');
                $(this).addClass('selected');
                selectedIconClass = $(this).data('icon'); // Seçilen ikonun class'ını değişkene kaydet
                $('#icon').val(selectedIconClass); // Inputa seçilen ikonun class'ını yaz

                // İkon class'ını güncelle
                var selectedIconClass = $('#icon').val();

                // İkon class'ını güncelle
                $('#selected-icon').removeClass().addClass(selectedIconClass);
            }

            // Input değeri değiştiğinde
            $('#icon').on('keyup', function () {
                var inputIconClass = $(this).val(); // Inputa girilen değeri al
                updateIconClass(inputIconClass); // İkon class'ını güncelle
            });

            function updateIconClass(iconClass) {
                $('#selected-icon').removeClass().addClass(iconClass);
            }
        });
        var counter = 0;

        function showIconPicker() {
            counter++;
            if (counter % 2 == 1) {
                $('#iconGrid').show();
            } else {
                $('#iconGrid').hide();
            }
        }

    </script>



    @include('layouts.setting')
    @include('layouts.script')


</body>

</html>
