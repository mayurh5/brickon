<script>
  var assetBaseUrl = "{{ asset('') }}";
  var baseUrl = "{{ url('/') }}"+'/';

  var s3_base_url = "{{ config('custom.s3_base_url') }}";

  var setupBaseUrl = "{{ url('/setup') }}"+'/';
  var productionBaseUrl = "{{ url('/production') }}"+'/';
  var inventoryBaseUrl = "{{ url('/inventory') }}"+'/';
  var salesBaseUrl = "{{ url('/sales') }}"+'/';

  var defaultNoImg =  "{{ asset('/no_image.jpg') }}";

  var rightActions = @if(isset($rightActions)) @json($rightActions) @else ''; @endif;
</script>

<!-- BEGIN: Vendor JS -->


<script src="{{asset('vendors/js/vendors.min.js')}}"></script>
<script src="{{asset('vendors/js/forms/select/select2.full.min.js')}}"></script>

<script src="{{asset('vendors/js/tables/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/datatables.checkboxes.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/dataTables.buttons.min.js')}}"></script>

<script src="{{asset('vendors/js/extensions/toastr.min.js')}}"></script>
<script src="{{asset('vendors/js/extensions/sweetalert2.all.min.js')}}"></script>

<script src="{{asset('vendors/js/pickers/pickadate/picker.js')}}"></script>
<script src="{{asset('vendors/js/pickers/pickadate/picker.date.js')}}"></script>
<script src="{{asset('vendors/js/pickers/pickadate/picker.time.js')}}"></script>
<script src="{{asset('vendors/js/extensions/moment.min.js')}}"></script>
<script src="{{asset('vendors/js/pickers/pickadate/legacy.js')}}"></script>
<script src="{{asset('vendors/js/pickers/daterange/daterangepicker.js')}}"></script>
<script src="{{asset('vendors/js/forms/validation/jquery.validate.min.js')}}"></script>


<script src="{{asset('fonts/LivIconsEvo/js/LivIconsEvo.tools.js')}}"></script>
<script src="{{asset('fonts/LivIconsEvo/js/LivIconsEvo.defaults.js')}}"></script>
<script src="{{asset('fonts/LivIconsEvo/js/LivIconsEvo.min.js')}}"></script>

<script src="{{asset('vendors/js/extensions/jquery.steps.min.js')}}"></script>



@yield('vendor-scripts')

<!-- END: Vendor JS -->



<!-- BEGIN: Theme JS-->

<script src="{{asset('js/scripts/forms/wizard-steps.js')}}"></script>

{{-- @if($configData['mainLayoutType'] == 'vertical-menu')
<script src="{{asset('js/scripts/configs/vertical-menu-light.js')}}"></script>
@else
<script src="{{asset('js/scripts/configs/horizontal-menu.js')}}"></script>
@endif --}}

<script src="{{asset('js/scripts/configs/vertical-menu-light.js')}}"></script>


<script src="{{asset('js/scripts/ckeditor/ckeditor.js')}}"></script>


<script src="{{asset('js/core/app-menu.js')}}"></script>
<script src="{{asset('js/core/app.js')}}"></script>
<script src="{{asset('js/scripts/components.js')}}"></script>
<script src="{{asset('js/scripts/footer.js')}}"></script>
<script src="{{asset('js/scripts/customizer.js')}}"></script>
<script src="{{asset('assets/js/scripts.js')}}"></script>
<script src="{{asset('js/scripts/tooltip/tooltip.js')}}"></script>
<script src="{{asset('js/scripts/forms/select/form-select2.js')}}"></script>
<script src="{{asset('js/scripts/extensions/toastr.js')}}"></script>
<script src="{{asset('js/scripts/pages/scripts.js')}}"></script>
<script src="{{asset('js/scripts/pickers/dateTime/pick-a-datetime.js')}}"></script>

<!-- END: Theme JS -->



<!-- BEGIN: Page JS-->
@yield('page-scripts')
<!-- END: Page JS-->


@include('panels.flash-notifications')
@include('scripts.scripts_js');
