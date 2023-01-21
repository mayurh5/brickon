<script>

  window.onload = function() {
      'use strict';

      var LoginClass = window.LoginClass || {};
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
              LoginClass.processExceptions(e);
          }
      };

      LoginClass.initEvents = function() {

          $('#loginFrmBtn').on('click', function(e) {

              submitForm('#login-form', "", "", (response) => {

                  hideLoadingDialog();
                  if(response.success=='1')
                  {

                      window.location.href = response.redirect_url;
                      showSuccessMessage(response.message);
                      
                  }else{
                      showErrorMessage(response.message);

                  }
              }, LoginClass.processExceptions);
          });

      };

      LoginClass.processExceptions = function(e) {
          showErrorMessage(e);
      };

      LoginClass.initEvents();
  };

</script>

