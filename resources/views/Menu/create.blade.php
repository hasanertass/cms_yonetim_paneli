<!-- create.blade.php -->
<form id="menuForm" method="post" action="{{ route('menu.store') }}">
    @csrf
    <div class="modal-dialog container-fluid py-8">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="MenuModalLabel">Yeni Menü Ekle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @include('errors')
            <div class="modal-body">
                <div class="mb-3">
                    <label for="alan_id" class="form-label">Menü Alanı</label>
                    <select class="form-control" id="alan_id" name="alan_id" required>
                        <option value="">Alan Seçiniz</option>
                        @foreach($menu_alanlar as $menu_alan_item)
                            <option value="{{ $menu_alan_item->alan_id }}">{{ $menu_alan_item->alan_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="MenuAdı" class="form-label">Menü Adı</label>
                    <input type="text" class="form-control" name="MenuAdı" id="MenuAdı"
                        value="{{ old('MenuAdı') }}" required>
                </div>
                <div class="mb-3">
                    <label for="MenuSırası" class="form-label">Menü Sırası</label>
                    <input type="text" class="form-control" name="MenuSırası" id="MenuSırası"
                        value="{{ old('MenuSırası') }}" required>
                </div>
                <div class="mb-3">
                    <label for="MenuLink" class="form-label">Menü Link</label>
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
                    <input type="text" class="form-control" name="MenuLink_external" id="ExternalMenuLink" style="display: none;"
                        placeholder="Bağlantı Linkini giriniz">
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
                <button type="submit" class="btn btn-primary">Menü Ekle</button>
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
