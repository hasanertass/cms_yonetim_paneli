<form id="altmenuForm" method="post" action="{{ route('altmenu.store') }}">
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
                    <label for="MenuId" class="form-label">Menü Yeri</label>
                    <select class="form-control" id="MenuId" name="MenuId" required>
                        <option value="">Menü Seçiniz</option>
                        @foreach($üstMenüList as $ustMenu)
                            <option value="{{ $ustMenu->MenuId }}">{{ $ustMenu->MenuAdı }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="ItemAdı" class="form-label">Alt Menü Adı</label>
                    <input type="text" class="form-control" name="ItemAdı"
                        value="{{ old('ItemAdı') }}" id="ItemAdı" required>
                </div>
                <div class="mb-3">
                    <label for="ItemSırası" class="form-label">Alt Menü Sırası</label>
                    <input type="text" class="form-control" name="ItemSırası"
                        value="{{ old('ItemSırası') }}" id="ItemSırası" required>
                </div>

                <div class="mb-3">
                    <label for="MenuLink" class="form-label">Alt Menü Link</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="link_type" id="internal_link"
                            value="internal" checked>
                        <label class="form-check-label" for="internal_link">Site İçi Bağlantı</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="link_type" id="external_link"
                            value="external">
                        <label class="form-check-label" for="external_link">Harici Bağlantı</label>
                    </div>
                    <select class="form-control" id="MenuLink" name="MenuLink">
                        <option value="">Sayfa Seçiniz</option>
                        @foreach($page as $page)
                            <option value="{{ $page->slug }}">{{ $page->title }}</option>
                        @endforeach
                    </select>
                    <input type="text" class="form-control" name="MenuLink_external" id="ExternalMenuLink"
                        style="display: none;" placeholder="Bağlantı Linkini giriniz">
                </div>
                <div class="mb-3">
                    <label class="form-label">Bağlantı Açılış Yöntemi</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="link_open" id="open-same" value="same"
                            checked>
                        <label class="form-check-label" for="open-same">Mevcut Sayfada Aç</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="link_open" id="open-new" value="new">
                        <label class="form-check-label" for="open-new">Yeni Sekmede Aç</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Alt Menü Ekle</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
            </div>
        </div>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const internalLinkRadio = document.getElementById('internal_link');
        const externalLinkRadio = document.getElementById('external_link');
        const internalLinkField = document.getElementById('MenuLink');
        const externalLinkField = document.getElementById('ExternalMenuLink');

        internalLinkRadio.addEventListener('change', function () {
            if (internalLinkRadio.checked) {
                internalLinkField.style.display = 'block';
                externalLinkField.style.display = 'none';
            }
        });

        externalLinkRadio.addEventListener('change', function () {
            if (externalLinkRadio.checked) {
                internalLinkField.style.display = 'none';
                externalLinkField.style.display = 'block';
            }
        });
    });

</script>
