<!-- create.blade.php -->
<form id="menuForm" method="post" action="{{ route('menualan.store') }}">
    @csrf
    <div class="modal-dialog container-fluid py-8">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="MenuModalLabel">Yeni Menü Alanı Ekle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
            @include('errors')
            <div class="modal-body">
                <div class="mb-3">
                    <label for="alan_name" class="form-label">Menü Alanı Adı</label>
                    <input type="text" class="form-control" name="alan_name" id="alan_name" value="{{ old('alan_name') }}" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Menü Alanı Ekle</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
            </div>
        </div>
    </div>
</form>
