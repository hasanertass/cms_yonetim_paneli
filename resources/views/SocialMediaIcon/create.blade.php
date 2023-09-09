<!-- create.blade.php -->
<div class="modal-dialog container-fluid py-8">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="ıconModalLabel">Yeni İcon Ekle</h5>
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
            <form id="iconForm" method="post" action="{{ route('sosyalmedya.store') }}" enctype="multipart/form-data">
                @method('POST')
                @csrf
                <div class="mb-3">
                    <label for="Name" class="form-label">Sosyal Medya Adı</label>
                    <input type="text" class="form-control" name="Name" id="Name" value="{{ old('Name') }}" required>
                </div>
                <div class="mb-3">
                    <label for="Link" class="form-label">Sosyal Medya Link</label>
                    <input type="text" class="form-control" name="Link" id="Link" value="{{ old('Link') }}" required>
                </div>
                <div class="mb-3">
                    <label for="Icon" class="form-label">İcon Yolu</label>
                    <input type="file" class="form-control" name="Icon" id="Icon" value="{{ old('Icon') }}" required>
                    @error('Icon')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Icon Ekle</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                </div>
            </form>
        </div>
    </div>
</div>
