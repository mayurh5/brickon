<script>

  window.onload = function() {
      'use strict';

      var RoleRef = window.RoleRef || {};
      var xhr = null;

      if (window.XMLHttpRequest) {
          xhr = window.XMLHttpRequest;
      }
      else if(window.ActiveXObject('Microsoft.XMLHTTP')) {
          xhr = window.ActiveXObject('Microsoft.XMLHTTP');
      }

      var send = xhr.prototype.send;

      xhr.prototype.send = function(data) {
          try{
              send.call(this, data);
          }
          catch(e) {
              RoleRef.processExceptions(e);
          }
      };

      RoleRef.roleTbls = '';
      RoleRef.allRoleDetails = [];
      RoleRef.filterOption = false;

      RoleRef.initEvents = function() {

          RoleRef.roleTbls = $('#userrole_list_tbl').DataTable( {
              responsive: true,
              processing: true,
              serverSide: true,
              "ajax": {
                  "type" : "POST",
                  "url" : baseUrl + 'roles/get_role_list_json',
                  "data": function ( d ) {
                      d._token = $('meta[name="csrf-token"]').attr('content'),
                      d.filter = RoleRef.filterOption,
                      d.options = {
                          // 'payment_status_term' :  $('#payment_status_term').val(),
                          // 'status_term' :  $('#status_term').val(),
                          // 'start_date' :  $('#start_date').val() !== '' ? convertLocalDateTimeToUtcDateTime(moment($('#start_date').val()+" 00:00:00", "DD/MM/YYYY h:mm:ss").format("MM-DD-YYYY HH:mm:ss")) : '',
                          // 'end_date' :  $('#end_date').val() !== '' ? convertLocalDateTimeToUtcDateTime(moment($('#end_date').val()+" 23:59:59", "DD/MM/YYYY h:mm:ss").format("MM-DD-YYYY HH:mm:ss")) : '',
                      }
                  },
                  "dataSrc" : function (json) {
                      RoleRef.allRoleDetails = json.data;
                      return json.data;
                  }
              },
              "columns": [
                  { "data": "role_id",
                      "render": function ( data, type, row ) {
                          return row.role_id;
                      }
                  },
                  { "data": "",
                      "render": function ( data, type, row, meta  ) {
                          return meta.row+1;
                      }
                  },
                  { "data": "role_name"},

                  { "data": "role_detail"},

                  {
                      "data": "is_active",
                      "render": function(data, type, row) {

                          var html = '';



                              html +=     '<div class="custom-control custom-switch mr-1">';
                              html +=     '<input type="checkbox" data-id="' + row.role_id + '" class="custom-control-input status_term role_active_status" id="icon-animation-switch_' + row.role_id + '" ' + (row.is_active == '1' ? 'checked' : '') + '>';
                              html +=     '<label class="custom-control-label" for="icon-animation-switch_' + row.role_id + '"></label> ';
                              html +=     '</div>';



                          return html;
                      }
                  },

                  {
                      "data": "",
                      "render": function(data, type, row) {

                          var html = '';


                              html += ' <a href="' + baseUrl + 'roles/create/' + row.role_id + '"><i class="bx bx-edit text-primary bx-sm mr-50"></i></a>';



                          return html;
                      }
                  },

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

          $('body').on('change', '.role_active_status', function() {

              let is_active = $(this).prop('checked') === true ? "1" : "0";
              let id = $(this).data('id');

              $.ajax({

                  type: "GET",
                  url:  baseUrl + 'roles/status/update',
                  data: { 'is_active': is_active, 'id': id },
                  success: function(data) {
                      console.log(data.message);
                  }
              });
          });

      }

      RoleRef.processExceptions = function(e) {
          showErrorMessage(e);
      };

      RoleRef.initEvents();
  };

</script>


