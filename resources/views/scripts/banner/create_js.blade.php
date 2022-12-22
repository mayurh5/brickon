<script type="text/javascript">

  window.onload = function() {

      'use strict';
      var BannerForm = window.BannerForm || {};
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
              BannerForm.processExceptions(e);
          }
      };

        BannerForm.CertificateTbls = '';
        BannerForm.allAgencyDetails = [];
        BannerForm.filterOption = false;

      BannerForm.initEvents = function() {

          $('body').on('click', '#saveBannerBtn', function(e){

              submitForm('#banner_form_id', '', '', (response) => {

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



      BannerForm.processExceptions = function(e) {
          showErrorMessage(e);
      };
      BannerForm.initEvents();

  };

</script>
