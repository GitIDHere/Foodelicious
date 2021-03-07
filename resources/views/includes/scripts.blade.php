<script src="{{ mix('js/manifest.js') }}"></script>
<script src="{{ mix('js/vendor.js') }}"></script>
<script src="{{ mix('js/app.js') }}"></script>
<script src="{{ mix('js/theme.js') }}"></script>

<script>
    var APP_URL = "{{ url('') . '/' }}";
</script>

@yield('page_scripts')