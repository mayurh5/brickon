<script type="text/javascript">

  window.onload = function() {

      'use strict';
      var ProductTbl = window.ProductTbl || {};
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
              ProductTbl.processExceptions(e);
          }
      };

        ProductTbl.CertificateTbls = '';
        ProductTbl.allAgencyDetails = [];
        ProductTbl.filterOption = false;

      ProductTbl.initEvents = function() {

        ProductTbl.CertificateTbls = $('#product_tbl').DataTable( {
                responsive: true,
                processing: true,
                serverSide: true,
                "ajax": {
                    "type" : "POST",
                    "url" : baseUrl+'product/list',
                    "data": function ( d ) {
                        d._token = $('meta[name="csrf-token"]').attr('content'),
                        d.filter = ProductTbl.filterOption,
                        d.options = {
                            // 'payment_status_term' :  $('#payment_status_term').val(),
                            // 'status_term' :  $('#status_term').val(),
                            // 'start_date' :  $('#start_date').val() !== '' ? convertLocalDateTimeToUtcDateTime(moment($('#start_date').val()+" 00:00:00", "DD/MM/YYYY h:mm:ss").format("MM-DD-YYYY HH:mm:ss")) : '',
                            // 'end_date' :  $('#end_date').val() !== '' ? convertLocalDateTimeToUtcDateTime(moment($('#end_date').val()+" 23:59:59", "DD/MM/YYYY h:mm:ss").format("MM-DD-YYYY HH:mm:ss")) : '',
                        }
                    },
                    "dataSrc" : function (json) {
                        ProductTbl.allAgencyDetails = json.data;
                        console.log(ProductTbl.allAgencyDetails)
                        return json.data;
                    }
                },
                "columns": [
                    { "data": "id",
                        "render": function ( data, type, row ) {
                            return row.id ;
                        }
                    },
                    { "data": "id",
                        "render": function ( data, type, row, meta  ) {
                            return meta.row+1;
                        }
                    },

                    { "data": "value"},

                    {"data": "price_difference"},

                    {
                        "data": "id",
                        "render": function(data, type, row) {

                            var html = '';
                            html += '<div class="custom-control custom-switch"><input type="checkbox" data-id="' + row.id + '" class="custom-control-input product-active-status" id="icon-animation-switch_' + row.id + '" ' + (row.is_active == '1' ? 'checked' : '') + '> <label class="custom-control-label" for="icon-animation-switch_' + row.id + '"></label></div>';
                            return html;
                        }
                    },

                    {
                        "data": "id",
                        "render": function(data, type, row) {

                          return primary(row.is_primary);
                        }
                    },

                    {
                        "data": "id",
                        "render": function(data, type, row) {
                            var html = '';

                              html += ' <a href="' + baseUrl + 'product/create/' + row.id + '"><i class="bx bx-edit text-primary bx-sm mr-50"></i></a>';

                            return html;
                        }
                    }

                ],
                "order": [[ 0, 'desc' ]],
                'columnDefs': [
                    {
                        'targets': [5], // column index (start from 0)
                        'orderable': false, // set orderable false for selected columns
                    },
                    { "visible": false,  "targets": [ 0 ] }
                ]
            });

      };



      ProductTbl.processExceptions = function(e) {
          showErrorMessage(e);
      };
      ProductTbl.initEvents();

  };

</script>
