<script type="text/javascript">
  window.onload = function() {

      'use strict';
      var LeadFormView = window.LeadFormView || {};
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
              LeadFormView.processExceptions(e);
          }
      };

      LeadFormView.CertificateTbls = '';
      LeadFormView.allAgencyDetails = [];
      LeadFormView.filterOption = false;

      LeadFormView.initEvents = function() {

        $('body').on('click', '.lead_status', function(e) {

                e.preventDefault();

                var lead_id = $(this).data('lead-order-id');
                var status_action = $(this).data('action');
                
                var formData = new FormData();
                formData.append('lead_id', lead_id);
                formData.append('status_action', status_action);

                if (status_action == "confirmed") {

                  var title = "Confirm Lead Order";
                  var description = "Are you sure you want to confirm this lead order ?";

                } else if (status_action == "cancelled") {

                  var title = "Cancle Lead Order";
                  var description = "Are you sure you want to cancle this lead order ?";

                } else {

                  var title = "Complate Lead Order";
                  var description = "Are you sure you want to complate this lead order ?";

                }

                confirmDialogMessage(title, description, () => {
                    showLoadingDialog();
                    window.getResponseInJsonFromURL("{{route('leads.status_update')}}", formData, (response) => {

                        hideLoadingDialog();
                        if(response.success=='1')
                        {
                            // window.location.href = response.redirect_url;
                            showSuccessMessage(response.message);
                            location.reload();
                        }else{
                            hideLoadingDialog();
                            showErrorMessage(response.message);
                        }
                    },  LeadFormView.processExceptions, 'POST');

                });

            });



      };



      LeadFormView.processExceptions = function(e) {
          showErrorMessage(e);
      };
      LeadFormView.initEvents();

  };
</script>
