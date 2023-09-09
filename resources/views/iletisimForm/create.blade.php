<form id="iletisimForm" method="post" action="{{ route('iletisimform.store') }}">
    @csrf
    <div class="modal-dialog container-fluid py-8">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">Yeni Form Ekle</h5>
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
                    <label for="FormName" class="form-label">Form Adı</label>
                    <input type="text" class="form-control" name="FormName" id="FormName" required>
                </div>
                <div class="mb-3">
                    <label for="form_description" class="form-label">Form Açıklaması</label>
                    <input type="text" class="form-control" name="form_description" id="form_description" required>
                </div>
                <div class="form-group">
                    <label for="sayfa_id" class="form-label">Form Sayfası</label>
                    <select class="form-control" id="sayfa_id" value="{{ old('sayfa_id') }}"
                        name="sayfa_id" required>
                        <option value="">Sayfa Seçiniz</option>
                        @foreach($page as $page)
                            <option required value="{{ $page->sayfa_id }}">{{ $page->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Form Ekle</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
            </div>
        </div>
    </div>
</form>
