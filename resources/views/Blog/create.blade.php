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
                            <h5 class="card-title">Yeni Blog Ekleme Sayfası</h5>
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
                            <form action="{{ route('blog.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf<!-- CSRF koruması için gerekli alan -->
                                <div class="mb-3">
                                    <label for="title" class="form-label">Başlık</label>
                                    <input type="text" class="form-control" id="title"
                                        value="{{ old('title') }}" name="title" required>
                                </div>
                                <div class="mb-3">
                                    <label for="short_description" class="form-label">Kısa Açıklama</label>
                                    <input type="text" class="form-control" id="short_description"
                                        value="{{ old('short_description') }}" name="short_description"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="small_image" class="form-label">Görsel Ekle</label>
                                    <input type="file" class="form-control" name="small_image" id="small_image"
                                        value="{{ old('small_image') }}" required>
                                    @error('small_image')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="date" class="form-label">Tarih</label>
                                    <input type="date" class="form-control" id="date"
                                        value="{{ old('date') }}" name="date" required>
                                </div>
                                <div class="mb-3">
                                    <label for="linkType" class="form-label">Link Türü</label>
                                    <div>
                                        <input type="radio" id="hariciLink" name="linkType" value="harici" required>
                                        <label for="hariciLink">Harici Bağlantı</label>
                                    </div>
                                    <div>
                                        <input type="radio" id="siteIciLink" name="linkType" value="siteIci" required>
                                        <label for="siteIciLink">Site İçi Bağlantı</label>
                                    </div>
                                </div>

                                <div class="mb-3" id="linkDiv" style="display: none;">
                                    <label for="link" class="form-label" style="display: flex; align-items: center;">
                                        <span style="margin-right: 10px;">Link</span>
                                        <p style="color: red; font-size: 16px; margin: 0;">Unutmayın harici bağlantı
                                            site dışında herhangi bir bağlantı olmak zorundadır. Bu yöntemi herhangi bir
                                            dış kaynaktaki blog yazısını göstermek için kullanabilirsiniz.</p>
                                    </label>
                                    <input type="text" class="form-control" id="link" name="link"
                                        value="{{ old('link') }}">
                                </div>
                                <div class="mb-3" id="aciklamaDiv" style="display: none;">
                                    <label for="aciklama" class="form-label"
                                        style="display: flex; align-items: center;">
                                        <span style="margin-right: 10px;">Açıklama</span>
                                        <p style="color: red; font-size: 16px; margin: 0;">Unutmayın site içi bağlantı
                                            verdiğinizde haber içeriği görüntüleme sayfasında burada yazdığınız içerik
                                            görüntülenecektir.</p>
                                    </label>
                                    <textarea class="form-control" id="content" name="content"
                                        rows="10">{{ old('long_description') }}</textarea>
                                </div>
                                <div class="mb-3" id="gorselDiv" style="display: none;">
                                    <label for="görsel2" class="form-label" style="display: flex; align-items: center;">
                                        <span style="margin-right: 10px;">Büyük Görsel</span>
                                        <p style="color: red; font-size: 16px; margin: 0;">Unutmayın site içi bağlantı
                                            verdiğinizde blog içeriği görüntüleme sayfasında burada görsel eklerseniz
                                            yazının sol tarafında görünecektir. Eğer görsel Konumunu kendiniz belirlemek
                                            istiyorsanız acıklama kısmındaki editörden de görsel ekleyebilirsiniz.</p>
                                    </label>
                                    <input type="file" class="form-control" name="large_image" id="large_image"
                                        value="{{ old('large_image') }}">
                                    @error('görsel')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <br>
                                    <label for="meta_title">Meta Başlık <p style="color: red; font-size: 16px; margin: 0;">Bu alan <b>Blog</b> içeriğinin gösterileceği sayfanın CEO optimizasyonu için gerekli bilgidir.</p></label>
                                    <input type="text"class="form-control" id="meta_title" name="meta_title"
                                        value="{{ old('meta_title') }}">
                                    <br>
                                    <label for="meta_description">Meta Açıklama <p style="color: red; font-size: 16px; margin: 0;">Bu alan <b>Blog</b> içeriğinin gösterileceği sayfanın CEO optimizasyonu için gerekli bilgidir.</p></label>
                                    <input type="text"class="form-control" id="meta_description" name="meta_description"
                                        value="{{ old('meta_description') }}">
                                    <br>
                                    <label for="meta_keywords">Meta Keywords <p style="color: red; font-size: 16px; margin: 0;">Bu alan <b>Blog</b> içeriğinin gösterileceği sayfanın CEO optimizasyonu için gerekli bilgidir.</p></label>
                                    <input type="text"class="form-control" id="meta_keywords" name="meta_keywords"
                                        value="{{ old('meta_keywords') }}">
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
        const linkTypeRadios = document.querySelectorAll('input[name="linkType"]');
        const linkDiv = document.getElementById('linkDiv');
        const aciklamaDiv = document.getElementById('aciklamaDiv');
        const gorselDiv = document.getElementById('gorselDiv');

        linkTypeRadios.forEach(radio => {
            radio.addEventListener('change', () => {
                if (radio.value === 'harici') {
                    linkDiv.style.display = 'block';
                    aciklamaDiv.style.display = 'none';
                    gorselDiv.style.display = 'none';
                } else if (radio.value === 'siteIci') {
                    linkDiv.style.display = 'none';
                    aciklamaDiv.style.display = 'block';
                    gorselDiv.style.display = 'block';
                }
            });
        });

    </script>
    @include('layouts.setting')
    @include('layouts.script')
</body>

</html>
