<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editLogoModalLabel">Logo Düzenle</h5>
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
            <form id="editLogoForm" method="post"
                action="{{ route('logo.update', ['logo' => $logo->Id]) }}">
                @csrf
                @method('PATCH')
                <div class="mb-3">
                    <label for="editLogoName" class="form-label">Logo Adı</label>
                    <input type="text" class="form-control" id="editLogoName" name="editLogoName" required>
                </div>
                <div class="mb-3">
                    <label for="editLogoAltText" class="form-label">Logo Alternatif Metin</label>
                    <input type="text" class="form-control" id="editLogoAltText" name="editLogoAltText" required>
                </div>
                <p><b style="color: red;"> Eklemiş olduğunuz logonun fotoğrafını değiştirmek için logoyu
                        silip tekrardan yüklemeniz gerekir !!!</b></p>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
            <button type="button" class="btn btn-primary" id="saveChangesBtn"
                data-logo-id="{{ $logo->Id }}">Kaydet</button>
        </div>
    </div>
</div>
