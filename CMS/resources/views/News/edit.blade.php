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
                            <h5 class="card-title">Haber İçeriği Düzenleme Sayfası</h5>
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
                            <form action="{{ route('news.update',$new->id) }}" method="POST"
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
                                        @if(isset($new->görsel))
                                            <img id="görsel-onizleme" src="{{ asset($new->görsel) }}"
                                                alt="Görsel Önizleme" style="max-width: 200px; max-height: 200px;">
                                        @endif
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="baslik" class="form-label">Başlık</label>
                                    <input class="form-control" id="baslik" name="baslik" rows="3" required
                                        value="{{ old('baslik',$new->baslik) }}">
                                </div>
                                <div class="mb-3">
                                    <label for="kisa_aciklama" class="form-label">Kısa Açıklama</label>
                                    <input class="form-control" id="kisa_aciklama" name="kisa_aciklama"
                                        value="{{ old('kisa_aciklama',$new->kisa_aciklama) }}"
                                        rows="3" required>
                                </div>
                                <div class="mb-3">
                                    <label for="tarih" class="form-label">Tarih</label>
                                    <input type="date" class="form-control" id="tarih" name="tarih"
                                        value="{{ old('tarih',$new->tarih) }}" required>
                                </div>
                                @if($new->link=='')
                                    <div class="mb-3">
                                        <label for="aciklama" class="form-label">Açıklama</label>
                                        <textarea class="form-control" id="content" name="content" rows="20"
                                            required>{{ old('aciklama',$new->aciklama) }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="görsel2" class="form-label">Büyük Görsel</label>
                                        <div class="d-flex align-items-center">
                                            <input type="file" class="form-control" name="görsel2" id="görsel2" value="{{ old('görsel2') }}">
                                            @if(isset($new->görsel2))
                                                <img id="görsel-onizleme-2" src="{{ asset($new->görsel2) }}"
                                                    alt="Görsel Eklenmemiş"
                                                    style="max-width: 200px; max-height: 200px; display: none;">
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <div class="mb-3">
                                        <label for="link" class="form-label">Link</label>
                                        <input type="text" class="form-control" id="link" name="link"
                                            value="{{ old('link',$new->link) }}" required>
                                    </div>
                                @endif

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
    @include('layouts.setting')
    <script>
        const görselInput2 = document.getElementById('görsel2');
        const görselOnizleme2 = document.getElementById('görsel-onizleme-2');

        görselInput2.addEventListener('change', function (event) {
            const dosya = event.target.files[0];
            if (dosya) {
                const dosyaURL = URL.createObjectURL(dosya);
                görselOnizleme2.src = dosyaURL;
                görselOnizleme2.style.display = 'block';
            } else {
                görselOnizleme2.src =
                    '{{ isset($new->görsel2) ? asset($new->görsel2) : '' }}';
                görselOnizleme2.style.display =
                    '{{ isset($new->görsel2) ? 'block' : 'none' }}';
            }
        });

    </script>
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
                    '{{ isset($new->görsel) ? asset($new->görsel) : '' }}';
                görselOnizleme.style.display =
                    '{{ isset($new->görsel) ? 'block' : 'none' }}';
            }
        });

    </script>
    @include('layouts.script')

</body>

</html>
