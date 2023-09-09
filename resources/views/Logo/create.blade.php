<!-- create.blade.php -->
<form id="logoForm" method="post" action="{{ route('logo.store') }}">
    @csrf
    <div class="modal-dialog container-fluid py-8">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoModalLabel">Yeni Logo Ekle</h5>
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
            <div class="modal-body">
                <div class="mb-3">
                    <label for="Name" class="form-label">Logo Adı</label>
                    <input type="text" class="form-control" name="Name" id="Name" value="{{ old('Name') }}" required>
                </div>
                <div class="mb-3">
                    <label for="Alt_text" class="form-label">Logo Alternatif Metin</label>
                    <input type="text" class="form-control" name="Alt_text" id="Alt_text" value="{{ old('Alt_Text') }}" required>
                </div>
                <div class="mb-3">
                    <label for="FilePath" class="form-label">Logo Yolu</label>
                    <input type="file" class="form-control" name="FilePath" id="FilePath" value="{{ old('FilePath') }}" required>
                    @error('FilePath')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Logo Ekle</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
            </div>
        </div>
    </div>
</form>
