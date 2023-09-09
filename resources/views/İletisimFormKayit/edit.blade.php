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
                            <h5 class="card-title">Form Bilgileri İnceleme Sayfası</h5>
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
                            @foreach($formAlanları as $alan)
                                @if($alan->AlanType=='textarea')
                                    <div class="mb-3">
                                        <label for="Harita" class="form-label">{{$alan->AlanName}}</label>
                                        <textarea class="form-control" id="Cevap" name="Harita" rows="3"
                                            required>{{ $forms['column' . $i] }}</textarea>
                                    </div>
                                    @php $i += 1; @endphp
                                @else
                                    <div class="mb-3">
                                        <label for="SirketAdi" class="form-label">{{$alan->AlanName}}</label>
                                        <input type="text" class="form-control" id="Baslik" name="SirketAdi"
                                            value="{{ $forms['column' . $i] }}" required>
                                    </div>
                                    @php $i += 1; @endphp
                                @endif
                            @endforeach
                            <form action="{{ route('forms.update', $forms->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="id" value="{{$forms->form_id}}">
                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-primary w-100" name="status" value="0">İncelenmedi Olarak Kaydet</button>
                                    <button type="submit" class="btn btn-success w-100" name="status" value="1">İncelendi Olarak Kaydet</button>
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
