<script type="text/javascript">
  window.onload = function() {

      'use strict';
      var BannerTbl = window.BannerTbl || {};
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
              BannerTbl.processExceptions(e);
          }
      };

      BannerTbl.BannerTbls = '';
      BannerTbl.allAgencyDetails = [];
      BannerTbl.filterOption = false;

      BannerTbl.initEvents = function() {

          BannerTbl.BannerTbls = $('#banner_tbl').DataTable({
              responsive: true,
              processing: true,
              serverSide: true,
              "ajax": {
                  "type": "POST",
                  "url": baseUrl + 'banner/list',
                  "data": function(d) {
                      d._token = $('meta[name="csrf-token"]').attr('content'),
                          d.filter = BannerTbl.filterOption,
                          d.options = {
                              // 'payment_status_term' :  $('#payment_status_term').val(),
                              // 'status_term' :  $('#status_term').val(),
                              // 'start_date' :  $('#start_date').val() !== '' ? convertLocalDateTimeToUtcDateTime(moment($('#start_date').val()+" 00:00:00", "DD/MM/YYYY h:mm:ss").format("MM-DD-YYYY HH:mm:ss")) : '',
                              // 'end_date' :  $('#end_date').val() !== '' ? convertLocalDateTimeToUtcDateTime(moment($('#end_date').val()+" 23:59:59", "DD/MM/YYYY h:mm:ss").format("MM-DD-YYYY HH:mm:ss")) : '',
                          }
                  },
                  "dataSrc": function(json) {
                      BannerTbl.allAgencyDetails = json.data;
                      console.log(BannerTbl.allAgencyDetails)
                      return json.data;
                  }
              },
              "columns": [{
                      "data": "id ",
                      "render": function(data, type, row) {
                          return row.id;
                      }
                  },
                  {
                      "data": "id",
                      "render": function(data, type, row, meta) {
                          return meta.row + 1;
                      }
                  },

                  {
                      "data": "title"
                  },

                  {
                      "data": "order_no"
                  },

                  {
                      "data": "expiry_date"
                  },
                  {
                        "data": "id",
                        "render": function(data, type, row) {

                            var html = '';
                            html +=
                                '<div class="custom-control custom-switch"><input type="checkbox" data-id="' +
                                row.id +
                                '" class="custom-control-input banner-active-status" id="icon-animation-switch_' +
                                row.id + '" ' + (row.is_active == '1' ? 'checked' : '') +
                                '> <label class="custom-control-label" for="icon-animation-switch_' +
                                row.id + '"></label></div>';
                            return html;
                        }
                    },


                  {
                      "data": "",
                      "render": function(data, type, row) {
                          var html = '';

                          html += ' <a href="' + baseUrl + 'banner/create/' + row.id +'"><i class="bx bx-edit text-primary bx-sm mr-50"></i></a>';

                          return html;
                      }
                  },

              ],
              "order": [
                  [0, 'desc']
              ],
              'columnDefs': [{
                      'targets': [6], // column index (start from 0)
                      'orderable': false, // set orderable false for selected columns
                  },
                  {
                      "visible": false,
                      "targets": [0]
                  }
              ]
          });


          $('body').on('change', '.banner-active-status', function() {

              var formData = new FormData();
              formData.append('id', $(this).attr('data-id'));
              formData.append('is_active', this.checked ? '1' : '0');

              window.getResponseInJsonFromURL(baseUrl + 'certifiactes/status/update', formData, (
                  response) => {

                      if (response.success != '1') {
                          showErrorMessage(response.message);
                      }
                  }, BannerTbl.processExceptions, 'POST');

          });


      };



      BannerTbl.processExceptions = function(e) {
          showErrorMessage(e);
      };
      BannerTbl.initEvents();

  };
</script>
