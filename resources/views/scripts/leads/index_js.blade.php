<script type="text/javascript">
  window.onload = function() {

      'use strict';
      var CertificateForm = window.CertificateForm || {};
      var xhr = null;
      if (window.XMLHttpRequest) {
          xhr = window.XMLHttpRequest;
      } else if (window.ActiveXObject('Microsoft.XMLHTTP')) {

          xhr = window.ActiveXObject('Microsoft.XMLHTTP');
      }
      var send = xhr.prototype.send;
      xhr.prototype.send = function(data) {
          try {
              send.call(this, data);
          } catch (e) {
              CertificateForm.processExceptions(e);
          }
      };

      CertificateForm.CertificateTbls = '';
      CertificateForm.allAgencyDetails = [];
      CertificateForm.filterOption = false;

      CertificateForm.initEvents = function() {

          CertificateForm.CertificateTbls = $('#lead_list_tbl').DataTable({
              responsive: true,
              processing: true,
              serverSide: true,
              "ajax": {
                  "type": "POST",
                  "url": baseUrl + 'leads/list',
                  "data": function(d) {
                      d._token = $('meta[name="csrf-token"]').attr('content'),
                          d.filter = CertificateForm.filterOption,
                          d.options = {
                              // 'payment_status_term' :  $('#payment_status_term').val(),
                              // 'status_term' :  $('#status_term').val(),
                              // 'start_date' :  $('#start_date').val() !== '' ? convertLocalDateTimeToUtcDateTime(moment($('#start_date').val()+" 00:00:00", "DD/MM/YYYY h:mm:ss").format("MM-DD-YYYY HH:mm:ss")) : '',
                              // 'end_date' :  $('#end_date').val() !== '' ? convertLocalDateTimeToUtcDateTime(moment($('#end_date').val()+" 23:59:59", "DD/MM/YYYY h:mm:ss").format("MM-DD-YYYY HH:mm:ss")) : '',
                          }
                  },
                  "dataSrc": function(json) {
                      CertificateForm.allAgencyDetails = json.data;
                      console.log(CertificateForm.allAgencyDetails)
                      return json.data;
                  }
              },
              "columns": [{
                      "data": "id",
                      "render": function(data, type, row) {
                          return row.id;
                      }
                  },
                  {
                      "data": "",
                      "render": function(data, type, row, meta) {
                          return meta.row + 1;
                      }
                  },

                  {
                      "data": "first_name",
                      "render": function(data, type, row) {

                          return (row.first_name ? row.first_name + ' ' : '') + (row.last_name ? row.last_name + ' ' : '');
                      }
                  },
                  { "data": "phone" },
                  { "data": "total_tons" },
                  { "data": "final_total" },
                  { "data": "total" },
                  {
                      "data": "created_at",
                      "render": function(data, type, row) {
                          return row.created_at ? formatDateValueInInput(row.created_at) : '-';
                      }
                  },
                  {
                      "data": "due_date",
                      "render": function(data, type, row) {
                          return row.due_date ? formatDateValueInInput(row.due_date) : '-';
                      }
                  },
                  { "data": "total" },
                  {
                      "data": "",
                      "render": function(data, type, row) {
                          var html = '';

                          html += ' <a href="' + baseUrl + 'leads/view/' + row.id +
                              '"><i class="bx bx-show text-primary bx-sm mr-50"></i></a>';

                          return html;
                      }
                  },

              ],
              "order": [
                  [0, 'desc']
              ],
              'columnDefs': [{
                      'targets': [10], // column index (start from 0)
                      'orderable': false, // set orderable false for selected columns
                  },
                  {
                      "visible": false,
                      "targets": [0]
                  }
              ]
          });


      };



      CertificateForm.processExceptions = function(e) {
          showErrorMessage(e);
      };
      CertificateForm.initEvents();

  };
</script>
