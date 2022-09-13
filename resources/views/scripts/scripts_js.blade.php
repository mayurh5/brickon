<script>
  (function(window) {
      'use strict';

      /*
       * Log application events for analytics usage.
       * @param string event The event name.
       * @param object data The event params.
       */

      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      window.getResponseInJsonFromURL = function(urlToCall, dataToSend, furtherFuntionToCall, errorFuntionToCall,
          type = 'post') {

          $.ajax({
              type: type,
              url: urlToCall,
              data: dataToSend,
              processData: false,
              contentType: false,
              success: function(response) {
                  if (typeof furtherFuntionToCall == 'function') {
                      furtherFuntionToCall(response);
                  }

              },
              error: function(jqXHR, textStatus, ex) {
                  if (typeof errorFuntionToCall == 'function') {
                      errorFuntionToCall(jqXHR.responseText);
                  }
              }
          });

      };

      window.getFormInputs = function(form_selector) {

          var formData = new FormData($(form_selector)[0]);

          return formData;
      }

      window.submitForm = function(selector, options, isDirectSubmit = false, furtherFuntionToCall,
          errorFuntionToCall) {

          $(selector).validate({
              rules: options.rules ? options.rules : {},
              messages: options.messages ? options.messages : {},
              errorPlacement: function(error, element) {

                  if (element.attr("data-element-ref") == 'select2') {
                      $(':input[name="' + element.attr("name") + '"]').next().append(error);
                  } else if (element.attr("data-element-ref") == 'image') {
                      error.insertAfter('.image_validate_msg');
                  } else if (element.attr("data-element-ref") == 'watermark_image') {
                      error.insertAfter('.watermark_image_validate_msg');
                  } else {
                      error.insertAfter(element);
                  }

              },
              submitHandler: function(form, event) {

                  event.preventDefault();
                  if (isDirectSubmit == true) {
                      showLoadingDialog();
                      form.submit();
                  } else {

                      showLoadingDialog();

                      var methodType = form.getAttribute('method') != null ? form.getAttribute(
                          'method') : (options.type ? options.type : '');
                      var actionUrl = form.getAttribute('action') != null ? form.getAttribute(
                          'action') : (options.url ? options.url : '');

                      window.getResponseInJsonFromURL(actionUrl, getFormInputs(selector),
                          furtherFuntionToCall, errorFuntionToCall, methodType);

                      return false;
                  }

              }
          });

      }

      var loadingDialogToast = Swal.mixin({
          title: 'Please wait......',
          showConfirmButton: false,
          allowOutsideClick: false
      });

      window.showLoadingDialog = function(target = '') {

          loadingDialogToast.fire({
              target: (target != '' ? document.getElementById(target) : 'body'),
              onBeforeOpen: () => {
                  Swal.showLoading();
              }

          });
      }

      window.hideLoadingDialog = function() {

          loadingDialogToast.close();

      }

      window.showSuccessMessage = function(title = '', sub_title = '') {

          toastr.options = {
              "closeButton": true,
          }
          toastr.success(title, sub_title);
      }

      window.showErrorMessage = function(title = '', sub_title = '') {

          toastr.options = {
              "closeButton": true,
          }
          toastr.error(title, sub_title);

      }

      window.confirmDialogMessage = function(title_msg, sub_title_msg, furtherFuntionToCall, target = '') {

          Swal.fire({
              customClass: {
                  confirmButton: 'primary-bg',
              },
              title: title_msg,
              text: sub_title_msg,
              icon: 'warning',
              showCancelButton: true,
              confirmButtonText: 'Ok',
              target: (target != '' ? document.getElementById(target) : 'body'),
          }).then((result) => {

              if (result.value) {

                  furtherFuntionToCall();

              }

          });

      }

      window.showAlertMessage = function(icon_msg, title_msg, sub_title_msg, target = '', confirmButtonText = '',
          redirect_to = '') {
          Swal.fire({
              icon: icon_msg,
              title: title_msg,
              text: sub_title_msg,
              target: (target != '' ? document.getElementById(target) : 'body'),
              confirmButtonText: confirmButtonText ? confirmButtonText : 'Ok',
          }).then((result) => {

              if (result.value) {

                  if (redirect_to) {

                      window.location.href = redirect_to;

                  }
              }
          });
      }

      window.getDetailsFromObjectByKey = function(obj, id, key) {

          for (var data in obj) {
              var e = obj[data];
              if (e[key] == id) {
                  return e;
              }
          }
      };

      // Date Functions

      window.formatDateValue = function(date, format = '') {
          return moment(date).format(format != '' ? format : 'DD MMM, YYYY');
      }

      window.formatDateValueInInput = function(date, format = '') {
          return moment(date).format(format != '' ? format : 'YYYY-MM-DD');
      }

      window.getAfterDateByDays = function(date ='', days ='') {

          var date = new Date(date);
          var after_date = new Date(date.setDate(date.getDate() + days));
          var formated_after_date = formatDateValueInInput(after_date);
          return formated_after_date;
      }

      window.getBeforeDateByDays = function(date ='', days ='') {

          var date = new Date(date);
          var before_date = new Date(date.setDate(date.getDate() - days));
          var formated_before_date = formatDateValueInInput(before_date);
          return formated_before_date;
      }

      window.showSpinner = function(form_selector, size = 'lg', color = 'primary') {
          $(form_selector).append(
              '<div class="text-center col-12 mt-4 mb-4" id="spinner-ref"><div class="spinner-border spinner-border-' +
              size + ' text-' + color +
              '" role="status">  <span class="sr-only">Loading...</span> </div></div>');
      }

      window.hideSpinner = function(form_selector) {
          $(form_selector + ' #spinner-ref').remove();
      }

      // Get bank account details

      window.getBankAccountDetails = function(selector, id = "", type_term, module_name) {

          var formData = new FormData();
          formData.append('id', id);
          formData.append('type_term', type_term);
          formData.append('module_name', module_name);

          window.getResponseInJsonFromURL(baseUrl + 'get_bank_account_details', formData, (response) => {

              if (response.success == '1') {
                  $('#' + selector).html(response.view);
              } else {
                  $('#' + selector).html(response.view);
              }
          }, (error) => {}, 'POST');

      }

      // Get upload document

      window.getAllDocument = function(selector, id = "", type_term, module_name) {

          var formData = new FormData();
          formData.append('id', id);
          formData.append('type_term', type_term);
          formData.append('module_name', module_name);

          window.getResponseInJsonFromURL(baseUrl + 'get_upload_documents', formData, (response) => {

              if (response.success == '1') {
                  $('#' + selector).html(response.view);
              } else {
                  $('#' + selector).html("");
              }
          }, (error) => {}, 'POST');

      }

      // Preview uploaded file

      window.previewFile = function(url) {

          return window.open(url, '_blank');
      };

  }(window));


  // For select file

  $('body').on('change', 'input[type=file]', function(e) {

      if (this.files && this.files[0]) {

          var selector = $(this).attr('id');
          var allowedExtensions = /(\jpg|\jpeg|\png|\gif|\JPG|\svg)$/i;
          var ext = this.files[0].type.split('/').pop();
          var fileName = e.target.files[0].name;

          fileName = fileName.replace(/ /g, "_").replace(/\./g, '_');

          $('#' + selector + '_preview').html('');


          if (allowedExtensions.exec(ext)) {

              var reader = new FileReader();
              reader.onload = function(e) {
                  $('#' + selector + '_preview').append('<img class="img-fluid" src="' + e.target.result +
                      '" data-filename="' + fileName + '">');
              }
              reader.readAsDataURL(this.files[0]);

          } else {

              $('#' + selector + '_preview').append(
                  '<img class="img-fluid" src="{{ asset('/no_image.jpg') }}">');
          }

      }

      // else{
      //     var selector = $(this).attr('id');
      //     $('#'+selector+'_preview').html('');
      //     $('#'+selector+'_preview').append('<img class="img-fluid" src="{{ asset('/no_image.jpg') }}">');
      // }


  });

  function imagePreview() {

      $('body').on('change', 'input[type=file]', function(e) {

          if (this.files && this.files[0]) {

              var selector = $(this).attr('id');
              var allowedExtensions = /(\jpg|\jpeg|\png|\gif|\JPG|\svg)$/i;
              var ext = this.files[0].type.split('/').pop();
              var fileName = e.target.files[0].name;

              fileName = fileName.replace(/ /g, "_").replace(/\./g, '_');

              $('#' + selector + '_preview').html('');


              if (allowedExtensions.exec(ext)) {

                  var reader = new FileReader();
                  reader.onload = function(e) {
                      $('#' + selector + '_preview').append('<img class="img-fluid" src="' + e.target
                          .result +
                          '" data-filename="' + fileName + '">');
                  }
                  reader.readAsDataURL(this.files[0]);

              } else {

                  $('#' + selector + '_preview').append(
                      '<img class="img-fluid" src="{{ asset('/no_image.jpg') }}">');
              }

          }

      });

  }

  // For address inputs

  $("#city_id").select2({

      width: "100%",
      ajax: {
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: setupBaseUrl + 'city_list',
          dataType: 'json',
          method: "post",
          delay: 250,

          data: function(params) {
              return {
                  city: params.term, // search term
                  page: params.page
              };
          },

          processResults: function(data) {

              var retVal = [];
              for (var i = 0; i < data.data.length; i++) {
                  var lineObj = {
                      id: data.data[i]['id'],
                      text: data.data[i]['city_name'],
                      state: data.data[i]['state_code'],
                  }
                  retVal.push(lineObj);
              }
              return {
                  results: retVal
              };

          },

          cache: true
      },

      placeholder: 'Search for a city',
      minimumInputLength: 1,
      language: {
          inputTooShort: function(args) {
              return "";
          }
      }
  });

  $('.city').on('select2:select', function(e) {

      var state_selector = $(this).data('state_selector');
      var state_code_selector = $(this).data('state_code_selector');
      var country_selector = $(this).data('country_selector');

      show_state_list($(this).val(), e.params.data.state, 'select[name="' + state_selector + '"]',
          'select[name="' + state_code_selector + '"]', 'select[name="' + country_selector + '"]');

  });

  function show_state_list(city_id, selected_id = '', state_selector, state_code_selector, country_selector) {

      $.ajax({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          method: "POST",
          url: setupBaseUrl + 'city/state/' + city_id,
          processData: false,
          contentType: false,

          success: function(response) {

              if (response.data.length > 0) {

                  var stateSelector = $(state_selector);

                  $(stateSelector).empty();
                  $(state_code_selector).val('');
                  $(country_selector).val('');

                  if (response.data.length > 0) {

                      $(stateSelector).prepend("<option value=''>Please Select</option>");

                      $.each(response.data, function(index, value) {

                          $(stateSelector).append($("<option></option>")
                              .attr("value", value.id)
                              .attr("data-country", value.country_id)
                              .attr("data-gst_state_code", value.gst_state_code)
                              .text(value.name));

                      });

                      if (selected_id != '') {

                          $(state_selector + " option[value='" + selected_id + "']").prop("selected",
                              "selected");

                          var state_code = $(state_selector).find(':selected').attr(
                              'data-gst_state_code');
                          $(state_code_selector + " option[value='" + state_code + "']").prop("selected",
                              "selected");

                          var country_id = $(state_selector).find(':selected').attr('data-country');
                          $(country_selector + " option[value='" + country_id + "']").prop("selected",
                              "selected");

                      }

                  }
              }

          },
          error: function(jqXHR, textStatus, ex) {

          }
      });

  }

  function status_term_badge(status_term) {

      var html = '';

      if (status_term == "in progress") {

          html +=
              "<span class='badge badge-info font-small-1' style='padding: 0.25rem 0.45rem;'>In Progress</span>";

      } else if (status_term == "pending") {

          html +=
              "<span class='badge badge-warning font-small-1 ' style='padding: 0.25rem 0.45rem;'>Pending</span>";

      } else if (status_term == "confirmed") {

          html +=
              "<span class='badge badge-primary font-small-1' style='padding: 0.25rem 0.45rem;'>Confirmed</span>";

      } else if (status_term == "completed") {

          html +=
              "<span class='badge badge-success font-small-1' style='padding: 0.25rem 0.45rem;'>Completed</span>";

      } else if (status_term == "cancelled") {

          html +=
              "<span class='badge badge-danger font-small-1' style='padding: 0.25rem 0.45rem;'>Cancelled</span>";

      } else if (status_term == "reject") {

          html +=
              "<span class='badge badge-danger font-small-1' style='padding: 0.25rem 0.45rem;'>Rejected</span>";

      } else if (status_term == "accept") {

          html +=
              "<span class='badge badge-success font-small-1' style='padding: 0.25rem 0.45rem;'>Accepted</span>";

      }

      return html;

  }
</script>
