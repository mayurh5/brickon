<script type="text/javascript">

  window.onload = function() {

      'use strict';
      var ProductForm = window.ProductForm || {};
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
              ProductForm.processExceptions(e);
          }
      };

        ProductForm.CertificateTbls = '';
        ProductForm.allAgencyDetails = [];
        ProductForm.filterOption = false;

      ProductForm.initEvents = function() {

          $('body').on('click', '#saveProductBtn', function(e){

              submitForm('#product_form_id', '', '', (response) => {

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



      ProductForm.processExceptions = function(e) {
          showErrorMessage(e);
      };
      ProductForm.initEvents();

  };

</script>
