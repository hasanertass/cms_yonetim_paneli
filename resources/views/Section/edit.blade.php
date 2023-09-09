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
                        <div class="card-header">Bölüm Bilgilerini Düzenle</div>
                        <div class="card-body">
                            <form method="POST"
                                action="{{ route('section.update', $section->section_id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="sayfa_id" class="form-label">Bölüm Sayfası</label>
                                    <select class="form-control" id="sayfa_id" name="sayfa_id" required>
                                        <option value="">Sayfa Seçiniz</option>
                                        @foreach($pageName as $page)
                                            <option required
                                                value="{{ old('sayfa_id', $page->sayfa_id) }}"
                                                @if($section->sayfa_id == $page->sayfa_id) selected
                                                @endif>{{ $page->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="name">Bölüm Adı/Başlığı</label>
                                    <input type="text" name="name" id="name"
                                        value="{{ old('name',$section->section_name) }}"
                                        class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="row">Bölüm Sırası &nbsp; <span style="color:red">Not: Bölüm içeriği bilgisi
                                            sitede geçerli sayfa yüklendiğindeki listelenecek olan bölümlerin sırasını
                                            belirtir.</span></label>
                                    <input type="number" min="0" name="row" id="row"
                                        value="{{ old('row',$section->section_row) }}"
                                        class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="use_placeholder">İçerik Tutucu Kullan</label>
                                    <input type="checkbox" name="use_placeholder" id="use_placeholder">
                                </div>
                                <div class="form-group" id="placeholder_select" style="display: none;">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="placeholder">İçerik Tutucusu Seç</label>
                                            <select class="form-control" id="placeholder" name="placeholder">
                                                <option value="">İçerik Tutucusu Seçin</option>
                                                @foreach($moduls as $modul)
                                                    <option required value="{{ $modul->modul_id }}">{{ $modul->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="data_piece">Listelenecek Veri Sayısı</label>
                                            <input type="number" name="data_piece" id="data_piece" value="{{ old('data_piece', $section->data_piece) }}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="row">Bölümün İçeriği &nbsp; <span style="color: red; font-size: 12px; margin: 0;">Aşağıda görünen yapı sizi yanıltmasın sayfaya içerik eklediğinizde sayfada daha iyi görünebilir. :)</span></label>
                                    <textarea name="content" id="content" class="form-control"
                                        rows="20">{{ old('content',$section->content) }}</textarea>
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const usePlaceholderCheckbox = document.getElementById('use_placeholder');
            const placeholderSelect = document.getElementById('placeholder_select');
            const modul = document.getElementById('placeholder');

            usePlaceholderCheckbox.addEventListener('change', function () {
                if (usePlaceholderCheckbox.checked) {
                    placeholderSelect.style.display = 'block';
                } else {
                    placeholderSelect.style.display = 'none';
                }
            });

            const placeholderSelectElement = document.getElementById('placeholder');
            placeholderSelectElement.addEventListener('change', function () {
                const selectedModuleId = placeholderSelectElement.value;
                if (selectedModuleId) {
                    fetch(`/get-module-content/${selectedModuleId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.content) {
                                // Seçilen içeriği TinyMCE içine ekle
                                tinymce.get('content').setContent(data.content);
                            } else {
                                console.error('Content not found for selected module.');
                            }
                        })
                        .catch(error => {
                            console.error('An error occurred:', error);
                        });
                }
            });

            const entitySelect = document.getElementById('entity_select');
            const entity = document.getElementById('entity');
        });

    </script>
</body>


</html>
