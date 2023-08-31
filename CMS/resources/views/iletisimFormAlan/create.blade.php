<!-- create.blade.php -->
<form id="alanForm" method="post" action="{{ route('iletisimformalanları.store') }}">
    @csrf
    <div class="modal-dialog container-fluid py-8">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="alanModalLabel">Yeni Alan Ekle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="FormId" class="form-label">Form Adı</label>
                    <select class="form-control" id="FormId" name="FormId" required>
                        <option value="">Form Seçiniz</option>
                        @foreach($iletisimForm as $iletisimForm)
                            <option value="{{ $iletisimForm->FormId }}">{{ $iletisimForm->FormName }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="AlanName" class="form-label">Alan Adı</label>
                    <input type="text" class="form-control" name="AlanName" id="AlanName" required>
                </div>
                <div class="mb-3">
                    <label for="PleaceHolder" class="form-label">Pleace Holder (Formda Görnecek Ad)</label>
                    <input type="text" class="form-control" name="PleaceHolder" id="PleaceHolder" required>
                </div>
                <div class="mb-3">
                    <label for="AlanType" class="form-label">Alan Tipi </label>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="AlanType" value="text" required>
                                <label class="form-check-label">Kısa Metin</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="AlanType" value="email" required>
                                <label class="form-check-label">Mail</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="AlanType" value="number" required>
                                <label class="form-check-label">Sayı</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="AlanType" value="textarea" required>
                                <label class="form-check-label">Uzun Metin</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="AlanType" value="file" required>
                                <label class="form-check-label">Dosya</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="AlanType" value="date" required>
                                <label class="form-check-label">Tarih</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="AlanSırası" class="form-label">Alan Sırası </label>
                    <input type="number" class="form-control" name="AlanSırası" id="AlanSırası" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Kaydet</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
            </div>
        </div>
    </div>
</form>
