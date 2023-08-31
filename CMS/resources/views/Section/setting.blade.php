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
                        <div class="card-header">Bölüm İçerik Ayarları</div>
                        <div class="card-body">
                            <form method="POST"
                                action="{{ route('setting.update', $section->section_id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                @foreach($modulSettings as $modulSetting)
                                    <div class="form-group">
                                        <label for="name">{{$modulSetting->setting_name}}</label>
                                        @if($modulSetting->setting_type === 'location')
                                            <select name="{{ $modulSetting->setting_name2 }}" id="{{ $modulSetting->setting_name2 }}" class="form-control" required>
                                                <option value="sol">Sol</option>
                                                <option value="sağ">Sağ</option>
                                            </select>
                                        @elseif($modulSetting->setting_type === 'location_2')
                                            <select name="{{ $modulSetting->setting_name2 }}" id="{{ $modulSetting->setting_name2 }}" class="form-control" required>
                                                <option value="start-0 top-0 pe-3 pb-3">Sol Üst</option>
                                                <option value="start-0 bottom-0 pe-3 pt-3">Sol alt</option>
                                                <option value="end-0 top-0 ps-3 pb-3">Sağ Üst</option>
                                                <option value="end-0 bottom-0 ps-3 pt-3">Sağ Alt</option>
                                            </select>
                                        @elseif($modulSetting->setting_type === 'color')
                                            <input type="color" name="{{ $modulSetting->setting_name2 }}" id="{{ $modulSetting->setting_name2 }}" class="form-control" required>
                                        @elseif($modulSetting->setting_type === 'number')
                                            <input type="number" name="{{ $modulSetting->setting_name2 }}" id="{{ $modulSetting->setting_name2 }}" 
                                            class="form-control" placeholder="Site yapısı açısından önerilen rakamlar : 1,2,3,4,6" required>
                                        @else
                                            <input type="text" name="{{ $modulSetting->setting_name2 }}" id="{{ $modulSetting->setting_name2 }}" class="form-control" required>
                                        @endif
                                    </div>
                                @endforeach
                                <div class="form-group">
                                    <label for="row">Bölümün İçeriği &nbsp;  <span style="color: red; font-size: 12px; margin: 0;">Aşağıda görmüş olduğunuz yapı sizi yanıltmasın sayfadaki içerik aşağıda görünen yapıdan daha iyi olabilir. :)</span></label>
                                    <textarea name="content" id="content" class="form-control"
                                        rows="20">{{ old('content',$modul->content) }}</textarea>
                                </div>
                                <div class="card">
                                    <button type="submit" class="btn btn-primary">Bölüm Bilgilerini Güncelle</button>
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
