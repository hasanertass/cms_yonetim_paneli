<!DOCTYPE html>
<html lang="tr">
@include('UiLayer.Uilayouts.header')

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->
    @include('UiLayer.Uilayouts.head')
    
    @foreach($sectionContent as $sectionContent)
        {!! $sectionContent !!}
    @endforeach
    
    <!-- Footer Start -->
    @include('UiLayer.Uilayouts.footer')
    <!-- Footer End -->
    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    @include('UiLayer.Uilayouts.script')
</body>

</html>