<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editIconModalLabel">Icon Düzenle</h5>
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
        <form id="editIconForm" method="Post" action="{{ route('sosyalmedya.update', ['sosyalmedya' => $icon->Id]) }}">
            @csrf
            @method('Put')
            <div class="modal-body">
                <div class="mb-3">
                    <label for="editIconName" class="form-label">Sosyal Medya Adı</label>
                    <input type="text" class="form-control" id="editIconName" name="editIconName" required>
                </div>
                <div class="mb-3">
                    <label for="editIconLink" class="form-label">Sosyal Medya Link</label>
                    <input type="text" class="form-control" id="editIconLink" name="editIconLink" required>
                </div>
                <p><b style="color: red;"> Eklemiş olduğunuz sosyal medya iconunu değiştirmek için iconu
                        silip tekrardan yüklemeniz gerekir !!!</b></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                <button type="submit" class="btn btn-primary" id="saveChangesBtn"
                    data-ıcon-id="{{ $icon->Id }}">Kaydet</button>
            </div>
        </form>
    </div>
</div>

