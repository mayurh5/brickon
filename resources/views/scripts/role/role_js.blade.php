<script>

  window.onload = function() {
      'use strict';

      var RoleForm = window.RoleForm || {};
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
              RoleForm.processExceptions(e);
          }
      };

      RoleForm.initEvents = function() {

        $('body').on('click','.chk_action',function(e){
                var action = $(this).data('action');
                var data_id = $(this).data('id');

                    if(action == 'view'){

                        if ($(this).is(':checked')){

                            $('.view_menu_chk[data-id="'+data_id+'"]').prop("checked", true);
                        }
                        else{

                            $('.view_menu_chk[data-id="'+data_id+'"]').prop("checked", false);
                        }

                    }

                    if(action == 'create'){

                        if ($(this).is(':checked')){

                            $('.create_menu_chk[data-id="'+data_id+'"]').prop("checked", true);
                        }
                        else{

                            $('.create_menu_chk[data-id="'+data_id+'"]').prop("checked", false);
                        }

                    }

                    if(action == 'update'){

                        if ($(this).is(':checked')){

                            $('.update_menu_chk[data-id="'+data_id+'"]').prop("checked", true);
                        }
                        else{

                            $('.update_menu_chk[data-id="'+data_id+'"]').prop("checked", false);
                        }

                    }

                    if(action == 'delete'){

                        if ($(this).is(':checked')){

                            $('.delete_menu_chk[data-id="'+data_id+'"]').prop("checked", true);
                        }
                        else{

                            $('.delete_menu_chk[data-id="'+data_id+'"]').prop("checked", false);
                        }

                    }

                    if(action == 'export'){

                        if ($(this).is(':checked')){

                            $('.export_menu_chk[data-id="'+data_id+'"]').prop("checked", true);
                        }
                        else{

                            $('.export_menu_chk[data-id="'+data_id+'"]').prop("checked", false);
                        }

                    }

        });

        $('body').on('click', '#saveRoleBtn', function(e){

                var options = {
                    rules: {

                        role_name:{
                            maxlength:255,
                        },

                        role_detail:{
                            maxlength:255,
                        },

                    },
                    messages:{

                        role_name: {
                            maxlength : "The role name must be less than or equal to 255.",
                        },

                        role_detail: {
                            maxlength : "The role detail must be less than or equal to 255.",
                        },

                    },
                };

                $('#user_role_Form_id').validate({

                    rules : options.rules ? options.rules : {},
                    messages : options.messages ? options.messages : {},
                    errorPlacement: function (error, element) {

                        if(element.attr("data-element-ref") == 'select2'){
                            $(':input[name="'+element.attr("name")+'"]').next().append(error);
                            // error.insertAfter(element);
                        }else{
                            error.insertAfter(element);
                        }

                    },
                    submitHandler: function(form, event) {

                        var role_right_array =  [];

                        $(".role_right").each(function() {

                            var right_id = $(this).data('id');

                            if($('.role_right[data-id="'+right_id+'"] .checkbox-input:checked').length > 0){

                                var is_main_menu = $('.view_menu_chk[data-rightid="'+right_id+'"]').data('is-mainmenu');

                                var is_view = 0;
                                var is_create = 0;
                                var is_update = 0;
                                var is_delete = 0;
                                var is_export =  0;

                                if($('.view_menu_chk[data-rightid="'+right_id+'"]').is(":checked")) {
                                    var is_view = $('.view_menu_chk').val();
                                }

                                if($('.create_menu_chk[data-rightid="'+right_id+'"]').is(":checked")) {
                                    var is_create = $('.create_menu_chk').val();
                                }

                                if($('.update_menu_chk[data-rightid="'+right_id+'"]').is(":checked")) {
                                    var is_update = $('.update_menu_chk').val();
                                }

                                if($('.delete_menu_chk[data-rightid="'+right_id+'"]').is(":checked")) {
                                    var is_delete = $('.delete_menu_chk').val();
                                }

                                if($('.export_menu_chk[data-rightid="'+right_id+'"]').is(":checked")) {
                                    var is_export = $('.export_menu_chk').val();
                                }

                                if(is_main_menu == 0){

                                    var parent_id = $('.view_menu_chk[data-rightid="'+right_id+'"]').data('parent-id');

                                    var tab_index = role_right_array.findIndex(x => x.right_id == parent_id);

                                    if (tab_index == -1) {

                                        role_right_array.push({
                                                            right_id:parent_id,
                                                            is_view: 0,
                                                            is_create: 0,
                                                            is_update: 0,
                                                            is_delete: 0,
                                                            is_export:0
                                                    });
                                    }


                                }

                                role_right_array.push({right_id:right_id,
                                                        is_view: is_view,
                                                        is_create: is_create,
                                                        is_update: is_update,
                                                        is_delete: is_delete,
                                                        is_export:is_export
                                                    });

                            }

                            $("#role_right_id").val(JSON.stringify(role_right_array));
                            form.submit();

                        })


                    }
                });
            });

        RoleForm.roleClick();

      }

      RoleForm.roleClick = function(response) {

                  $( "#rights_container" ).html("");
                  showSpinner("#rights_container");

                  var role_id = $("#role_id").val();
console.log(role_id)
                  var formData = new FormData();

                  if(role_id){
                      formData.append('role_id', role_id);
                  }

                  window.getResponseInJsonFromURL(baseUrl + 'roles/get_right_list', formData, (response) => {
                      hideSpinner("#rights_container");
                      RoleForm.loadRightsUi(response.data);

                  }, (error) => { console.log(error); }, 'POST');

      };

      RoleForm.loadRightsUi = function(response) {

          var html = "";

          if(response){

              $.each(response, function( index, value ) {

                  html +='    <div class="collapsible collapse-icon accordion-icon-rotate module_rights_ui">';
                  html +='        <div class="card collapse-header">';
                  html +='            <div class="card-content">';
                  html +='                <div id="headingCollapse5" class="card-header" data-toggle="collapse" role="button" data-target="#collapse'+index+'" aria-expanded="false" aria-controls="collapse'+index+'">';
                  html +='                    <span class="collapse-title">';
                  html +='                        <i class="fas fa-th"></i>';
                  html +='                        <span class="align-middle">'+value.parent_right_name+'</span>';
                  html +='                    </span>';
                  html +='                </div>';

                  html +='              <div id="collapse'+index+'" role="tabpanel" aria-labelledby="headingCollapse5" class="card-header">';
                  html +='                    <div class="card-body">';
                  html +='                        <div class="table">';
                  html +='                            <table id="" class="table">';
                  html +='                                <thead>';
                  html +='                                    <tr>';
                  html +='                                        <th>{{ trans('pages.menu_name') }}</th>';
                  html +='                                        <th>';
                  html +='                                            <div class="checkbox">';
                  html +='                                                <input type="checkbox" class="checkbox-input chk_action" id="chkViewId'+value.parent_right_id+'" data-id="'+value.parent_right_id+'" data-action="view">';
                  html +='                                                <label for="chkViewId'+value.parent_right_id+'" class="pl-25">{{ trans('pages.view') }}</label>';
                  html +='                                            </div>';
                  html +='                                        </th>';
                  html +='                                        <th>';
                  html +='                                            <div class="checkbox">';
                  html +='                                                <input type="checkbox" class="checkbox-input chk_action" id="chkCreateId'+value.parent_right_id+'" data-id="'+value.parent_right_id+'" data-action="create">';
                  html +='                                                <label for="chkCreateId'+value.parent_right_id+'" class="pl-25">{{ trans('pages.create') }}</label>';
                  html +='                                            </div>';
                  html +='                                        </th>';
                  html +='                                        <th>';
                  html +='                                            <div class="checkbox">';
                  html +='                                                <input type="checkbox" class="checkbox-input chk_action" id="chkUpdateId'+value.parent_right_id+'" data-id="'+value.parent_right_id+'" data-action="update">';
                  html +='                                                <label for="chkUpdateId'+value.parent_right_id+'" class="pl-25">{{ trans('pages.update') }}</label>';
                  html +='                                            </div>';
                  html +='                                        </th>';
                  html +='                                        <th>';
                  html +='                                            <div class="checkbox">';
                  html +='                                                <input type="checkbox" class="checkbox-input chk_action" id="chkDeleteId'+value.parent_right_id+'" data-id="'+value.parent_right_id+'" data-action="delete">';
                  html +='                                                <label for="chkDeleteId'+value.parent_right_id+'" class="pl-25">{{ trans('pages.delete') }}</label>';
                  html +='                                            </div>';
                  html +='                                        </th>';
                  html +='                                        <th>';
                  html +='                                            <div class="checkbox">';
                  html +='                                                <input type="checkbox" class="checkbox-input chk_action" id="chkExportId'+value.parent_right_id+'" data-id="'+value.parent_right_id+'" data-action="export">';
                  html +='                                                <label for="chkExportId'+value.parent_right_id+'" class="pl-25">{{ trans('pages.export') }}</label>';
                  html +='                                            </div>';
                  html +='                                        </th>';
                  html +='                                    </tr>';
                  html +='                                </thead>';


                $.each(value.child_right, function( sub_index, sub_value ) {

                    html +='                                <tbody>';
                    html +='                                    <tr class="role_right" data-id="'+sub_value.child_right_id+'">';
                    html +='                                        <td>'+sub_value.child_right_name+'</td>';
                    html +='                                        <td>';
                    html +='                                            <div class="checkbox">';

                    html +='                                                <input type="checkbox" name="IsView" class="checkbox-input view_menu_chk" id="ViewModuleId'+index + sub_index+'" data-id="'+value.parent_right_id+'" data-rightid="'+sub_value.child_right_id+'" data-parent-id="'+value.parent_right_id+'" value="1"  '+(sub_value.is_view == 1 ? 'checked' : '')+' data-is-mainmenu="'+sub_value.is_main_menu+'" >';
                    html +='                                                <label for="ViewModuleId'+index + sub_index+'"></label>';
                    html +='                                            </div>';
                    html +='                                        </td>';
                    html +='                                        <td>';
                    html +='                                            <div class="checkbox">';
                    html +='                                                <input type="checkbox" name="IsCreate" class="checkbox-input create_menu_chk" id="CreateModuleId'+index + sub_index+'" data-id="'+value.parent_right_id+'" data-rightid="'+sub_value.child_right_id+'" data-parent-id="'+value.parent_right_id+'" value="1" '+(sub_value.is_create == 1 ? 'checked' : '')+' data-is-mainmenu="'+sub_value.is_main_menu+'">';
                    html +='                                                <label for="CreateModuleId'+index + sub_index+'"></label>';
                    html +='                                            </div>';
                    html +='                                        </td>';
                    html +='                                        <td>';
                    html +='                                            <div class="checkbox">';
                    html +='                                                <input type="checkbox" name="IsUpdate" class="checkbox-input update_menu_chk" id="UpdateModuleId'+index + sub_index+'" data-id="'+value.parent_right_id+'" data-rightid="'+sub_value.child_right_id+'" data-parent-id="'+value.parent_right_id+'" value="1" '+(sub_value.is_update == 1 ? 'checked' : '')+' data-is-mainmenu="'+sub_value.is_main_menu+'">';
                    html +='                                                <label for="UpdateModuleId'+index + sub_index+'"></label>';
                    html +='                                            </div>';
                    html +='                                        </td>';
                    html +='                                        <td>';
                    html +='                                            <div class="checkbox">';
                    html +='                                                <input type="checkbox" name="IsDelete" class="checkbox-input delete_menu_chk" id="DeleteModuleId'+index + sub_index+'" data-id="'+value.parent_right_id+'" data-rightid="'+sub_value.child_right_id+'" data-parent-id="'+value.parent_right_id+'" value="1" '+(sub_value.is_delete == 1 ? 'checked' : '')+' data-is-mainmenu="'+sub_value.is_main_menu+'">';
                    html +='                                                <label for="DeleteModuleId'+index + sub_index+'"></label>';
                    html +='                                            </div>';
                    html +='                                        </td>';
                    html +='                                        <td>';
                    html +='                                            <div class="checkbox">';
                    html +='                                                <input type="checkbox" name="IsExport" class="checkbox-input export_menu_chk" id="ExportModuleId'+index + sub_index+'" data-id="'+value.parent_right_id+'" data-rightid="'+sub_value.child_right_id+'" data-parent-id="'+value.parent_right_id+'" value="1" '+(sub_value.is_export == 1 ? 'checked' : '')+' data-is-mainmenu="'+sub_value.is_main_menu+'">';
                    html +='                                                <label for="ExportModuleId'+index + sub_index+'"></label>';
                    html +='                                            </div>';
                    html +='                                        </td>';
                    html +='                                   </tr>';
                    html +='                               </tbody>';

                });


                  html +='                           </table>';
                  html +='                         </div>';
                  html +='                       </div>';
                  html +='                     </div>';
                  html +='                   </div>';
                  html +='                 </div>';
                  html +='              </div>';

              });

              $('#rights_container').append(html);
          }
          else{
              $('#rights_container').append(html);
          }

      };

      RoleForm.processExceptions = function(e) {
          showErrorMessage(e);
      };

      RoleForm.initEvents();
  };

</script>


