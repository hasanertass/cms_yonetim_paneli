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
                            <h5 class="card-title">Blog İçeriği Düzenleme Sayfası</h5>
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
                            <form action="{{ route('blog.update',$blog->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf<!-- CSRF koruması için gerekli alan -->
                                @method('PATCH')
                                <div class="mb-3">
                                    <label for="görsel" class="form-label">
                                        Görsel
                                    </label>
                                    <div class="d-flex align-items-center">
                                        <input type="file" class="form-control" name="small_image" id="small_image"
                                            value="{{ old('small_image') }}">
                                        @if(isset($blog->small_image))
                                            <img id="görsel-onizleme" src="{{ asset($blog->small_image) }}"
                                                alt="Görsel Önizleme" style="max-width: 200px; max-height: 200px;">
                                        @endif
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="title" class="form-label">Başlık</label>
                                    <input class="form-control" id="title" name="title" rows="3" required
                                        value="{{ old('baslik',$blog->title) }}">
                                </div>
                                <div class="mb-3">
                                    <label for="short_description" class="form-label">Kısa Açıklama</label>
                                    <input class="form-control" id="short_description" name="short_description"
                                        value="{{ old('short_description',$blog->short_description) }}"
                                        rows="3" required>
                                </div>
                                <div class="mb-3">
                                    <label for="date" class="form-label">Tarih</label>
                                    <input type="date" class="form-control" id="date" name="date"
                                        value="{{ old('date',$blog->date) }}" required>
                                </div>
                                @if($blog->link=='')
                                    <div class="mb-3">
                                        <label for="aciklama" class="form-label">Açıklama</label>
                                        <textarea class="form-control" id="content" name="content" rows="20"
                                            required>{{ old('long_description',$blog->long_description) }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="görsel2" class="form-label">Büyük Görsel</label>
                                        <div class="d-flex align-items-center">
                                            <input type="file" class="form-control" name="large_image" id="large_image" value="{{ old('large_image')}}">
                                            @if(isset($blog->large_image))
                                                <img id="görsel-onizleme-2" src="{{ asset($blog->large_image) }}"
                                                    alt="Görsel Eklenmemiş"
                                                    style="max-width: 200px; max-height: 200px; display: none;">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="meta_title">Meta Başlık <p
                                                style="color: red; font-size: 16px; margin: 0;">Bu alan Haber içeriğinin
                                                gösterileceği sayfanın CEO optimizasyonu için gerekli bilgidir.</p>
                                            </label>
                                        <input type="text" class="form-control" id="meta_title" name="meta_title"
                                            value="{{ old('meta_title',$blog->meta_title) }}">
                                        <br>
                                        <label for="meta_description">Meta Açıklama <p
                                                style="color: red; font-size: 16px; margin: 0;">Bu alan Haber içeriğinin
                                                gösterileceği sayfanın CEO optimizasyonu için gerekli bilgidir.</p>
                                            </label>
                                        <input type="text" class="form-control" id="meta_description"
                                            name="meta_description"
                                            value="{{ old('meta_description',$blog->meta_description) }}">
                                        <br>
                                        <label for="meta_keywords">Meta Keywords <p
                                                style="color: red; font-size: 16px; margin: 0;">Bu alan Haber içeriğinin
                                                gösterileceği sayfanın CEO optimizasyonu için gerekli bilgidir.</p>
                                            </label>
                                        <input type="text" class="form-control" id="meta_keywords" name="meta_keywords"
                                            value="{{ old('meta_keywords',$blog->meta_keywords) }}">
                                    </div>
                                @else
                                    <div class="mb-3">
                                        <label for="link" class="form-label">Link</label>
                                        <input type="text" class="form-control" id="link" name="link"
                                            value="{{ old('link',$blog->link) }}" required>
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
    @include('layouts.setting')
    @include('layouts.script')

</body>

</html>
