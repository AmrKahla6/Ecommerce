<!-- REQUIRED JS SCRIPTS -->
<script>
    window.Laravel = {!! json_encode([
            'user' => auth()->check() ? auth()->user()->id : null,
        ]) !!};
</script>
<script src="{{ asset('js/app.js') }}"></script>
<!-- jQuery 2.2.3 -->
<script src="{{ asset('plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('plugins/select2/select2.full.min.js') }}"></script>
<!-- Toaster -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
@yield('js')
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
<!-- Slimscroll -->
<script src="{{ asset('plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('plugins/fastclick/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/app.min.js') }}"></script>
<script>
    $(document).ready(function()
    {
        Notification.requestPermission().then(function(result) {
            console.log(result);
        });
        @if ($errors->any())
        @foreach ($errors->all() as $error)
        toastr['error']("{{ $error }}")
        @endforeach
        @endif
        @if(session('status', '') == 'success')
        toastr['success']("{{ session('message', '') }}")
        @elseif(session('status', '') == 'error')
        toastr['error']("{{ session('message', '') }}")
        @endif
    })
</script>