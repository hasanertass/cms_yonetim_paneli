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
                            <h5 class="card-title">Hakkımzda Bilgileri Düzenleme Sayfası</h5>
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
                            <form action="{{ route('about.update',$about->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf<!-- CSRF koruması için gerekli alan -->
                                @method('PATCH')
                                <div class="mb-3">
                                    <label for="görsel" class="form-label">
                                        Görsel
                                    </label>
                                    <div class="d-flex align-items-center">
                                        <input type="file" class="form-control" name="görsel" id="görsel"
                                            value="{{ old('görsel') }}">
                                        @if(isset($about->görsel))
                                            <img id="görsel-onizleme" src="{{ asset($about->görsel) }}"
                                                alt="Görsel Önizleme" style="max-width: 200px; max-height: 200px;">
                                        @endif
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="görsel2" class="form-label">
                                        Mini Görsel
                                    </label>
                                    <div class="d-flex align-items-center">
                                    <input type="file" class="form-control" name="görsel2" id="görsel2"
                                            value="{{ old('görsel2') }}">
                                        @if(isset($about->görsel))
                                            <img id="görsel-onizleme2" src="{{ asset($about->görsel2) }}"
                                                alt="Görsel Önizleme2" style="max-width: 200px; max-height: 200px;">
                                        @endif
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="baslik" class="form-label">Başlık</label>
                                    <input class="form-control" id="baslik" name="baslik" required
                                        value="{{ old('baslik',$about->baslik) }}">
                                </div>
                                <div class="mb-3">
                                    <label for="aciklama1" class="form-label">Açıklama 1</label>
                                    <textarea class="form-control" id="aciklama1" name="aciklama1" rows="3"
                                        required>{{ old('aciklama1',$about->aciklama1) }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="aciklama2" class="form-label">Açıklama 2</label>
                                    <textarea class="form-control" id="aciklama2" name="aciklama2" rows="5"
                                        required>{{ old('aciklama2',$about->aciklama2) }}</textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="prop1" class="form-label">Özellik 1</label>
                                            <input type="text" class="form-control" id="prop1"
                                                value="{{ old('prop1',$about->prop1) }}" name="prop1">
                                        </div>
                                        <div class="mb-3">
                                            <label for="prop3" class="form-label">Özellik 3</label>
                                            <input type="text" class="form-control" id="prop3" name="prop3"
                                                value="{{ old('prop3',$about->prop3) }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="prop5" class="form-label">özellik 5</label>
                                            <input type="text" class="form-control" id="prop5" name="prop5"
                                                value="{{ old('prop5',$about->prop5) }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="prop7" class="form-label">Özellik 7</label>
                                            <input type="text" class="form-control" id="prop7" name="prop7"
                                                value="{{ old('prop7',$about->prop7) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="prop2" class="form-label">Özellik 2</label>
                                            <input type="text" class="form-control" id="prop2"
                                                value="{{ old('prop2',$about->prop2) }}" name="prop2">
                                        </div>
                                        <div class="mb-3">
                                            <label for="prop4" class="form-label">Özellik 4</label>
                                            <input type="text" class="form-control" id="prop4" name="prop4"
                                                value="{{ old('prop4',$about->prop4) }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="prop6" class="form-label">Özellik 6</label>
                                            <input type="text" class="form-control" id="prop6" name="prop6"
                                                value="{{ old('prop6',$about->prop6) }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="prop8" class="form-label">Özellik 8</label>
                                            <input type="text" class="form-control" id="prop8" name="prop8"
                                                value="{{ old('prop8',$about->prop8) }}">
                                        </div>
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
    @include('layouts.setting')
    <script>
        const görselInput = document.getElementById('görsel');
        const görselOnizleme = document.getElementById('görsel-onizleme');

        görselInput.addEventListener('change', function (event) {
            const dosya = event.target.files[0];
            if (dosya) {
                const dosyaURL = URL.createObjectURL(dosya);
                görselOnizleme.src = dosyaURL;
                görselOnizleme.style.display = 'block';
            } else {
                görselOnizleme.src =
                    '{{ isset($about->görsel) ? asset($about->görsel) : '' }}';
                görselOnizleme.style.display =
                    '{{ isset($about->görsel) ? 'block' : 'none' }}';
            }
        });
        const görselInput2 = document.getElementById('görsel2');
        const görselOnizleme2 = document.getElementById('görsel-onizleme2');

        görselInput2.addEventListener('change', function (event) {
            const dosya = event.target.files[0];
            if (dosya) {
                const dosyaURL = URL.createObjectURL(dosya);
                görselOnizleme2.src = dosyaURL;
                görselOnizleme2.style.display = 'block';
            } else {
                görselOnizleme2.src =
                    '{{ isset($about->görsel2) ? asset($about->görsel2) : '' }}';
                görselOnizleme2.style.display =
                    '{{ isset($about->görsel2) ? 'block' : 'none' }}';
            }
        });

    </script>
    @include('layouts.script')

</body>

</html>
