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
                        <div class="card-header">Yeni Sayfa Oluştur</div>
                        @include('errors')
                        <div class="card-body">
                            <form method="POST" action="{{ route('page.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="title">Sayfa Başlığı</label>
                                        <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}"  required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="url">Sayfa url</label>
                                        <input type="text" name="url" id="url" class="form-control" value="{{ old('url') }}" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="meta_title">Meta Başlığı</label>
                                        <input type="text" name="meta_title" id="meta_title" class="form-control" value="{{ old('meta_title') }}"  required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="meta_keywords">Meta Keywords</label>
                                        <input type="text" name="meta_keywords" id="meta_keywords" class="form-control" value="{{ old('meta_keywords') }}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="meta_description">Meta Açıklama</label>
                                        <input type="text" name="meta_description" id="meta_description" class="form-control" value="{{ old('meta_description') }}" required>
                                </div>
                                <div class="card">
                                    <button type="submit" class="btn btn-primary">Sayfa Oluştur</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.setting')
    @include('layouts.script')

</body>


</html>
