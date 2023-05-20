<script type="text/javascript">

  window.onload = function() {

      'use strict';
      var UserForm = window.UserForm || {};
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
              UserForm.processExceptions(e);
          }
      };

        UserForm.CertificateTbls = '';
        UserForm.allAgencyDetails = [];
        UserForm.filterOption = false;

      UserForm.initEvents = function() {

          $('body').on('click', '#saveUserBtn', function(e){

              submitForm('#user_form_id', '', '', (response) => {

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



      UserForm.processExceptions = function(e) {
          showErrorMessage(e);
      };
      UserForm.initEvents();

  };

</script>
