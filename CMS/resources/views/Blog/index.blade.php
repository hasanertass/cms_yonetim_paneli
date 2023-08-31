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
                            <h5 class="card-title">Blog Sayfası Bilgileri</h5>
                        </div>
                        @include('errors')
                        <div class="table-responsive ">
                            <table class="table table-bordered" style="text-align: center; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Görsel</th>
                                        <th>Büyük Görsel</th>
                                        <th>Başlık</th>
                                        <th>Kısa Açıklama</th>
                                        <th>Açıklama</th>
                                        <th>Tarih</th>
                                        <th>Link</th>
                                        <th>Sil</th>
                                        <th>Düzenle</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($blogs as $blog)
                                        <tr>
                                            <td class="align-middle" style="width: 150px;"><img
                                                    src="{{ asset($blog->small_image) }}" alt="Haber Görsel"
                                                    width="150px" height="150px"></td>
                                            @if($blog->large_image=='')
                                                <td class="align-middle"><p style="color: red;">Veri Yok</p></td>
                                            @else
                                                <td class="align-middle" style="width: 150px;"><img
                                                        src="{{ asset($blog->large_image) }}" alt="Haber Görsel"
                                                        width="150px" height="150px"></td>
                                            @endif
                                            <td class="align-middle">{{ $blog->title }}</td>
                                            <td class="align-middle">{{ $blog->short_description }}</td>
                                            <td class="align-middle" style="max-width: 300px;">{!! Str::limit(strip_tags($blog->long_description), 65) !!}
                                            </td>
                                            <td class="align-middle">{{ $blog->date }}</td>
                                            @if($blog->link=='')
                                                <td class="align-middle"><p style="color: red;">Site İçi Bağlantı</p></td>
                                            @else
                                                <td class="align-middle">{{ $blog->link }}</td>
                                            @endif
                                            <td class="align-middle">
                                                <form
                                                    action="{{ route('blog.destroy', $blog->id) }}"
                                                    method="POST" id="deleteForm_{{ $blog->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"
                                                        onclick="return confirmDelete({{ $blog->id }})">Sil</button>
                                                </form>
                                            </td>
                                            <td class="align-middle">
                                                <a href="{{ route('blog.edit', $blog->id) }}"
                                                    class="btn btn-success">Düzenle</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <a href="{{ route('blog.create') }}" class="btn btn-primary">Yeni Blog
                            Ekle</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Silme işlemi için onay sorusu göster
        function confirmDelete(Id) {
            if (confirm('Emin misiniz? Blog içeriği silindiğinde geri alınamaz.')) {
                // Silme işlemi için formu submit et
                document.querySelector(`#deleteForm_${Id}`).submit();
            } else {
                return false; // İşlemi iptal et
            }
        }

    </script>

    @include('layouts.setting')
    @include('layouts.script')

</body>


</html>
