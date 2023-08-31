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
                            <h5 class="card-title">Görsel Bilgileri Düzenleme Sayfası</h5>
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
                            <form action="{{ route('homepage.update',$homepage->id) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf<!-- CSRF koruması için gerekli alan -->
                                @method('PATCH')
                                <div class="mb-3">
                                    <label for="image" class="form-label">
                                        Görsel
                                    </label>
                                    <div class="d-flex align-items-center">
                                        <input type="file" class="form-control" name="image" id="image" value="{{ old('image') }}"
                                            onchange="previewImage(event)">
                                        @if(isset($homepage->image))
                                            <img id="görsel-onizleme" src="{{ asset($homepage->image) }}"
                                                alt="Görsel Önizleme" style="max-width: 200px; max-height: 200px;">
                                        @else
                                            <img id="görsel-onizleme" src="#" alt="Görsel Önizleme"
                                                style="max-width: 200px; max-height: 200px; display: none;">
                                        @endif
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="title" class="form-label">Başlık</label>
                                    <input class="form-control" id="title" name="title" required
                                        value="{{ old('title',$homepage->title) }}">
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Açıklama</label>
                                    <input class="form-control" id="description" name="description" required
                                        value="{{ old('description',$homepage->description) }}">
                                </div>
                                <div class="mb-3">
                                    <label for="buton_link" class="form-label">Buton Linki</label>
                                    <select class="form-control" id="buton_link" name="buton_link" required>
                                        <option value="">Sayfa Seçiniz</option>
                                        @foreach($page as $page)
                                            <option value="{{ $page->slug }}"
                                                {{ $page->slug == $homepage->buton_link ? 'selected' : '' }}>
                                                {{ $page->title }}</option>
                                        @endforeach
                                    </select>
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
                    '{{ isset($homepage->image) ? asset($homepage->image) : '' }}';
                görselOnizleme.style.display =
                    '{{ isset($homepage->image) ? 'block' : 'none' }}';
            }
        });

        function previewImage(event) {
            var output = document.getElementById('görsel-onizleme');
            output.style.display = "block";
            output.src = URL.createObjectURL(event.target.files[0]);
        }

    </script>
    @include('layouts.script')

</body>

</html>
