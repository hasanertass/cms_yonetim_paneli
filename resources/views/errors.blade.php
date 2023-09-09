@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <b><li style="color: #d8d5d5;">{{ $error }}</li></b>
            @endforeach
        </ul>
    </div>
@endif
@if(session('success'))
    <div class="alert alert-success">
        <b style="color: #000000;">{{ session('success') }}</b>
    </div>
@endif

@if(session('warning'))
    <div class="alert alert-warning" style="">
        <b style="color: #ffffff;">{{ session('warning') }}</b>
    </div>
@endif
