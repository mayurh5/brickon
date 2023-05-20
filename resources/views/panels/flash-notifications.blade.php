
    <script>
      @if(Session::has('message'))
          toastr.options =
          {

              "closeButton" : true,
          }
          toastr.success("{{ session('message') }}");

      @endif

      @if(Session::has('error'))
          toastr.options =
          {
              "closeButton" : true,
          }
          toastr.error("{{ session('error') }}");
      @endif

      @if(Session::has('status') && session('status') == '1')
          toastr.options =
          {
              "closeButton" : true,
          }
          toastr.status("{{ session('message') }}");
      @endif

      @if(Session::has('status') && session('status') == '0')
          toastr.options =
          {
              "closeButton" : true,
          }
          toastr.error("{{ session('message') }}");
      @endif

      @if(Session::has('info'))
          toastr.options =
          {
              "closeButton" : true,
          }
          toastr.info("{{ session('info') }}");
      @endif

      @if(Session::has('warning'))
          toastr.options =
          {
              "closeButton" : true,
          }
          toastr.warning("{{ session('warning') }}");
      @endif

  </script>
