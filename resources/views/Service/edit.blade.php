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
                            <h5 class="card-title">Hizmet Bilgileri Düzenleme Sayfası</h5>
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
                            <form
                                action="{{ route('service.update',['service' => $service->id]) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf<!-- CSRF koruması için gerekli alan -->
                                @method('PATCH')
                                <div class="mb-3">
                                    <label for="görsel" class="form-label">
                                        Görsel
                                    </label>
                                    <div class="d-flex align-items-center">
                                        <input type="file" class="form-control" name="small_image" id="small_image"
                                            value="{{ old('small_image') }}">
                                        @if(isset($service->small_image))
                                            <img id="görsel-onizleme" src="{{ asset($service->small_image) }}"
                                                alt="Görsel Önizleme" style="max-width: 200px; max-height: 200px;">
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3 form-group">
                                            <label for="title" class="form-label">Başlık</label>
                                            <input type="text" class="form-control" id="title"
                                                value="{{ old('title',$service->title) }}"
                                                name="title" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3 form-group">
                                            <label for="icon" class="form-label">İkon Sınıfı</label>
                                            <div class="col-md-6 d-flex align-items-center gap-6">
                                                <input type="text" class="form-control" id="icon" name="icon"
                                                    value="{{ old('icon',$service->icon ) }}"
                                                    onkeyup="updateIcon(this.value)">
                                                <i id="selected-icon" class="{{ $icon->icon }}"
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
                                    <label for="short_description" class="form-label">Açıklama</label>
                                    <input type="text" class="form-control" id="short_description"
                                        value="{{ old('short_description',$service->short_description) }}"
                                        name="short_description" required>
                                </div>
                                <div class="mb-3">
                                    <label for="aciklama" class="form-label">Açıklama</label>
                                    <textarea class="form-control" id="content" name="content"
                                        rows="20">{{ old('long_description',$service->long_description) }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="görsel2" class="form-label">Büyük Görsel</label>
                                    <div class="d-flex align-items-center">
                                        <input type="file" class="form-control" name="large_image" id="large_image"
                                            value="{{ old('large_image') }}">
                                        @if(isset($service->large_image))
                                            <img id="görsel-onizleme-2" src="{{ asset($service->large_image) }}"
                                                alt="Görsel Eklenmemiş" style="max-width: 200px; max-height: 200px;">
                                        @endif
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="mb-3">
                                        <label for="meta_title">Meta Başlık <p
                                                style="color: red; font-size: 16px; margin: 0;">Bu alan hizmet detaylarının
                                                gösterileceği sayfanın CEO optimizasyonu için gerekli bilgidir.</p>
                                        </label>
                                        <input type="text" class="form-control" id="meta_title" name="meta_title"
                                            value="{{ old('meta_title',$service->meta_title) }}">
                                        <br>
                                        <label for="meta_description">Meta Açıklama <p
                                                style="color: red; font-size: 16px; margin: 0;">Bu alan hizmet detaylarının
                                                gösterileceği sayfanın CEO optimizasyonu için gerekli bilgidir.</p>
                                        </label>
                                        <input type="text" class="form-control" id="meta_description"
                                            name="meta_description"
                                            value="{{ old('meta_description',$service->meta_description) }}">
                                        <br>
                                        <label for="meta_keywords">Meta Keywords <p
                                                style="color: red; font-size: 16px; margin: 0;">Bu alan hizmet detaylarının
                                                gösterileceği sayfanın CEO optimizasyonu için gerekli bilgidir.</p>
                                        </label>
                                        <input type="text" class="form-control" id="meta_keywords" name="meta_keywords"
                                            value="{{ old('meta_keywords',$service->meta_keywords) }}">
                                    </div>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Güncelle</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const görselInput = document.getElementById('small_image');
        const görselOnizleme = document.getElementById('görsel-onizleme');

        görselInput.addEventListener('change', function (event) {
            const dosya = event.target.files[0];
            if (dosya) {
                const dosyaURL = URL.createObjectURL(dosya);
                görselOnizleme.src = dosyaURL;
                görselOnizleme.style.display = 'block';
            } else {
                görselOnizleme.src =
                    '{{ isset($blog->small_image) ? asset($blog->small_image) : '' }}';
                görselOnizleme.style.display =
                    '{{ isset($blog->small_image) ? 'block' : 'none' }}';
            }
        });

        const görselInput2 = document.getElementById('large_image');
        const görselOnizleme2 = document.getElementById('görsel-onizleme-2');

        görselInput2.addEventListener('change', function (event) {
            const dosya = event.target.files[0];
            if (dosya) {
                const dosyaURL = URL.createObjectURL(dosya);
                görselOnizleme2.src = dosyaURL;
                görselOnizleme2.style.display = 'block';
            } else {
                görselOnizleme2.src =
                    '{{ isset($blog->large_image) ? asset($blog->large_image) : '' }}';
                görselOnizleme2.style.display =
                    '{{ isset($blog->large_image) ? 'block' : 'none' }}';
            }
        });

    </script>
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
