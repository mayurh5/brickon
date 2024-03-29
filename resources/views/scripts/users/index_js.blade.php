<script type="text/javascript">

  window.onload = function() {

      'use strict';
      var UserTbl = window.UserTbl || {};
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
              UserTbl.processExceptions(e);
          }
      };

        UserTbl.UserTbls = '';
        UserTbl.allUserDetails = [];
        UserTbl.filterOption = false;

        UserTbl.WebUserTbls = '';
        UserTbl.allWebUserDetails = [];

      UserTbl.initEvents = function() {

        UserTbl.UserTbls = $('#user_tbl').DataTable( {
                responsive: true,
                processing: true,
                serverSide: true,
                "ajax": {
                    "type" : "POST",
                    "url" : baseUrl+'users/list',
                    "data": function ( d ) {
                        d._token = $('meta[name="csrf-token"]').attr('content'),
                        d.filter = UserTbl.filterOption,
                        d.options = {
                            // 'payment_status_term' :  $('#payment_status_term').val(),
                            // 'status_term' :  $('#status_term').val(),
                            // 'start_date' :  $('#start_date').val() !== '' ? convertLocalDateTimeToUtcDateTime(moment($('#start_date').val()+" 00:00:00", "DD/MM/YYYY h:mm:ss").format("MM-DD-YYYY HH:mm:ss")) : '',
                            // 'end_date' :  $('#end_date').val() !== '' ? convertLocalDateTimeToUtcDateTime(moment($('#end_date').val()+" 23:59:59", "DD/MM/YYYY h:mm:ss").format("MM-DD-YYYY HH:mm:ss")) : '',
                        }
                    },
                    "dataSrc" : function (json) {
                        UserTbl.allUserDetails = json.data;
                        console.log(UserTbl.allUserDetails)
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

                    { "data": "first_name"},

                    {"data": "phone"},
                    {"data": "email"},

                    {
                        "data": "id",
                        "render": function(data, type, row) {

                            var html = '';
                            html += '<div class="custom-control custom-switch"><input type="checkbox" data-id="' + row.id + '" class="custom-control-input product-active-status" id="icon-animation-switch_' + row.id + '" ' + (row.is_active == '1' ? 'checked' : '') + '> <label class="custom-control-label" for="icon-animation-switch_' + row.id + '"></label></div>';
                            return html;
                        }
                    },
                    { "data": "role_type",
                        "render": function ( data, type, row, meta  ) {
                            return row.role_type;
                        }
                    },
                    {
                      "data": "created_at",
                      "render": function(data, type, row) {
                          return row.created_at ? formatDateValueInInput(row.created_at) : '-';
                      }
                  },

                    {
                        "data": "id",
                        "render": function(data, type, row) {
                            var html = '';
                            html += ' <a href="' + baseUrl + 'users/view/' + row.id +'"><i class="bx bx-show text-primary bx-sm mr-50"></i></a>';
                              // html += ' <a href="' + baseUrl + 'product/create/' + row.id + '"><i class="bx bx-edit text-primary bx-sm mr-50"></i></a>';

                            return html;
                        }
                    }

                ],
                "order": [[ 0, 'desc' ]],
                'columnDefs': [
                    {
                        'targets': [8], // column index (start from 0)
                        'orderable': false, // set orderable false for selected columns
                    },
                    { "visible": false,  "targets": [ 0 ] }
                ]
        });


        UserTbl.WebUserTbls = $('#web_user_tbl').DataTable( {
                responsive: true,
                processing: true,
                serverSide: true,
                "ajax": {
                    "type" : "POST",
                    "url" : baseUrl+'users/web_user_json_list',
                    "data": function ( d ) {
                        d._token = $('meta[name="csrf-token"]').attr('content'),
                        d.filter = UserTbl.filterOption,
                        d.options = {
                            // 'payment_status_term' :  $('#payment_status_term').val(),
                            // 'status_term' :  $('#status_term').val(),
                            // 'start_date' :  $('#start_date').val() !== '' ? convertLocalDateTimeToUtcDateTime(moment($('#start_date').val()+" 00:00:00", "DD/MM/YYYY h:mm:ss").format("MM-DD-YYYY HH:mm:ss")) : '',
                            // 'end_date' :  $('#end_date').val() !== '' ? convertLocalDateTimeToUtcDateTime(moment($('#end_date').val()+" 23:59:59", "DD/MM/YYYY h:mm:ss").format("MM-DD-YYYY HH:mm:ss")) : '',
                        }
                    },
                    "dataSrc" : function (json) {
                        UserTbl.allWebUserDetails = json.data;
                        console.log(UserTbl.allWebUserDetails)
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

                    { "data": "first_name",
                        "render": function ( data, type, row, meta  ) {
                            return (row.first_name ? row.first_name : '' + '' + row.last_name ? row.last_name : '') ;
                        }
                    },
                    {"data": "user_name"},

                    {"data": "mobile_no"},

                    {
                        "data": "id",
                        "render": function(data, type, row) {

                            var html = '';
                            html += '<div class="custom-control custom-switch"><input type="checkbox" data-id="' + row.id + '" class="custom-control-input web-user-active-status" id="web_icon-animation-switch_' + row.id + '" ' + (row.is_active == '1' ? 'checked' : '') + '> <label class="custom-control-label" for="web_icon-animation-switch_' + row.id + '"></label></div>';
                            return html;
                        }
                    },
                    { "data": "association_type",
                        "render": function ( data, type, row, meta  ) {
                            return row.association_type;
                        }
                    },
                    {
                        "data": "id",
                        "render": function(data, type, row) {
                            var html = '';
                            html += ' <a href="' + baseUrl + 'users/create/' + row.id +'"><i class="bx bx-edit text-primary bx-sm mr-50"></i></a>';
                              // html += ' <a href="' + baseUrl + 'product/create/' + row.id + '"><i class="bx bx-edit text-primary bx-sm mr-50"></i></a>';

                            return html;
                        }
                    }

                ],
                "order": [[ 0, 'desc' ]],
                'columnDefs': [
                    {
                        'targets': [7], // column index (start from 0)
                        'orderable': false, // set orderable false for selected columns
                    },
                    { "visible": false,  "targets": [ 0 ] }
                ]
        });

      };


      UserTbl.processExceptions = function(e) {
          showErrorMessage(e);
      };
      UserTbl.initEvents();

  };

</script>
