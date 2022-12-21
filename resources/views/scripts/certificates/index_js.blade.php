<script type="text/javascript">

  window.onload = function() {

      'use strict';
      var CertificateForm = window.CertificateForm || {};
      var xhr = null;
      if (window.XMLHttpRequest) {
          xhr = window.XMLHttpRequest;
      }else if(window.ActiveXObject('Microsoft.XMLHTTP')) {

          xhr = window.ActiveXObject('Microsoft.XMLHTTP');
      }
      var send = xhr.prototype.send;
      xhr.prototype.send = function(data) {
          try{
              send.call(this, data);
          }
          catch(e) {
              CertificateForm.processExceptions(e);
          }
      };

        CertificateForm.CertificateTbls = '';
        CertificateForm.allAgencyDetails = [];
        CertificateForm.filterOption = false;

      CertificateForm.initEvents = function() {

        CertificateForm.CertificateTbls = $('#certificate_tbl').DataTable( {
                responsive: true,
                processing: true,
                serverSide: true,
                "ajax": {
                    "type" : "POST",
                    "url" : baseUrl+'certifiactes/list',
                    "data": function ( d ) {
                        d._token = $('meta[name="csrf-token"]').attr('content'),
                        d.filter = CertificateForm.filterOption,
                        d.options = {
                            // 'payment_status_term' :  $('#payment_status_term').val(),
                            // 'status_term' :  $('#status_term').val(),
                            // 'start_date' :  $('#start_date').val() !== '' ? convertLocalDateTimeToUtcDateTime(moment($('#start_date').val()+" 00:00:00", "DD/MM/YYYY h:mm:ss").format("MM-DD-YYYY HH:mm:ss")) : '',
                            // 'end_date' :  $('#end_date').val() !== '' ? convertLocalDateTimeToUtcDateTime(moment($('#end_date').val()+" 23:59:59", "DD/MM/YYYY h:mm:ss").format("MM-DD-YYYY HH:mm:ss")) : '',
                        }
                    },
                    "dataSrc" : function (json) {
                        CertificateForm.allAgencyDetails = json.data;
                        console.log(CertificateForm.allAgencyDetails)
                        return json.data;
                    }
                },
                "columns": [
                    { "data": "certificate_id ",
                        "render": function ( data, type, row ) {
                            return row.certificate_id ;
                        }
                    },
                    { "data": "",
                        "render": function ( data, type, row, meta  ) {
                            return meta.row+1;
                        }
                    },

                    { "data": "certificate_name"},

                    {
                        "data": "certificate_file_path",
                        "render": function(data, type, row) {
                            // return '<img src="' + (row.certificate_file_path != null ? s3_base_url + row.certificate_file_path : defaultNoImg) + '" alt="avtar img holder" height="70" width="70">';
                            return '<a href="'+row.certificate_file_path+'" target="_blank" rel="noopener noreferrer">'+row.certificate_file_path+'</a>';
                        }
                    },
                    {
                        "data": "",
                        "render": function(data, type, row) {
                            var html = '';

                              // html += ' <a href="' + setupBaseUrl + 'agency/agency_list/edit/' + row.agency_id + '"><i class="bx bx-edit text-primary bx-sm mr-50"></i></a>';

                            return html;
                        }
                    },

                ],
                "order": [[ 0, 'desc' ]],
                'columnDefs': [
                    {
                        'targets': [4], // column index (start from 0)
                        'orderable': false, // set orderable false for selected columns
                    },
                    { "visible": false,  "targets": [ 0 ] }
                ]
            });




        $('body').on('click', '#saveCertificateBtn', function(e){

            submitForm('#certificate_form_id', '', '', (response) => {

                // ajax success callback
                hideLoadingDialog();

                if(response.success == 1){
                    showSuccessMessage(response.message);
                    window.location.href = response.redirect_url;

                }else{
                    hideLoadingDialog();
                    showErrorMessage(response.message);
                }

                } , (error) => {
                // ajax error callback
                hideLoadingDialog();
                showErrorMessage(error);

            });
        });


      };



      CertificateForm.processExceptions = function(e) {
          showErrorMessage(e);
      };
      CertificateForm.initEvents();

  };

</script>
