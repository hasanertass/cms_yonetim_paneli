<!-- create.blade.php -->
<form id="markaForm" method="post" action="{{ route('marka.store') }}">
    @csrf
    <div class="modal-dialog container-fluid py-8">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="markaModalLabel">Yeni İcon Ekle</h5>
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
                    <label for="MarkaName" class="form-label">Marka Adı</label>
                    <input type="text" class="form-control" name="MarkaName" id="MarkaName" value="{{ old('MarkaName') }}" required>
                </div>
                <div class="mb-3">
                    <label for="MarkaLogo" class="form-label">Marka Logosu</label>
                    <input type="file" class="form-control" name="MarkaLogo" id="MarkaLogo" value="{{ old('MarkaLogo') }}" required>
                    @error('MarkaLogo')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Marka Ekle</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
            </div>
        </div>
    </div>
</form>
<script>
    document.getElementById('markaForm').addEventListener('submit', function (event) {
        event.preventDefault();
        const formData = new FormData(this);

        fetch(this.action, {
                method: 'POST',
                body: formData
            }).then(response => response.text())
            .then(data => {
                alert('Marka başarıyla eklendi.');
                document.getElementById('markaForm').reset();
                window.location.reload();
            })
            .catch(error => {
                console.error('Hata:', error);
                alert(error);
            });
    });

</script>
