
<script>

  @if(Session::has('message'))
      toastr.options =
      {

          "closeButton" : true,
      }
      toastr.success("{{ session('message') }}");
  @endif

  @if(Session::has('error'))
      toastr.options =
      {
          "closeButton" : true,
      }
      toastr.error("{{ session('error') }}");
  @endif

  @if(Session::has('info'))
      toastr.options =
      {
          "closeButton" : true,
      }
      toastr.info("{{ session('info') }}");
  @endif

  @if(Session::has('warning'))
      toastr.options =
      {
          "closeButton" : true,
      }
      toastr.warning("{{ session('warning') }}");
  @endif

  @if(Session::has('success') && session('success') == '1')
      toastr.options =
      {
          "closeButton" : true,
      }
      toastr.success("{{ session('message') }}");
  @endif

  @if(Session::has('success') && session('success') == '0')
      toastr.options =
      {
          "closeButton" : true,
      }
      toastr.error("{{ session('message') }}");
  @endif


  // @if (Auth::check())

  //     function getNotifications(){

  //         window.getResponseInJsonFromURL(baseUrl+'notification/getUnreadAllNotificationsJson', '', (response) => {

  //             processNotificationResponse(response);

  //         }, (error) => { console.log(error); }, 'POST');

  //     }

  //     function processNotificationResponse(response){

  //         $('#notify-badge-count').hide();
  //         $('#notify-badge-count-title').hide();

  //         $('#unread-notifications-container').html('');

  //         if(response.total_count > 0){

  //             $('#notify-badge-count').html(response.total_count);
  //             $('#notify-badge-count-title').html(response.total_count+' new Notification');
  //             $('#notify-badge-count').show();
  //             $('#notify-badge-count-title').show();

  //             var html = '';

  //             $.each(response.data, function (i, value) {

  //                 value.data = JSON.parse(value.data);

  //                 html += '<div class="d-flex justify-content-between cursor-pointer notify-action" data-action-type="'+(value.data.hasOwnProperty("type") ? value.data.type : '')+'" data-action-id="'+(value.data.hasOwnProperty("id") ? value.data.id : '')+'" data-id="'+value.id+'">';
  //                 html += '    <div class="media d-flex align-items-center">';
  //                 html += '         <div class="media-left pr-0">';
  //                 html += '            <div class="avatar bg-rgba-primary m-0 mr-1 p-25">';

  //                 if(value.data.hasOwnProperty("type") && value.data.type == 127){
  //                     // project term - 127 = appointment
  //                     html += '                <div class="avatar-content"><i class="bx bx-calendar-check text-primary"></i></div>';
  //                 }else if(value.data.hasOwnProperty("type") && value.data.type == 128){
  //                     // project term - 128 = test booking
  //                     html += '                <div class="avatar-content"><i class="fa fa-flask text-primary"></i></div>';
  //                 }else{
  //                     html += '                <div class="avatar-content"><i class="bx bxs-bell-ring text-primary"></i></div>';
  //                 }

  //                 html += '            </div>';
  //                 html += '         </div>';
  //                 html += '        <div class="media-body">';
  //                 html += '            <h6 class="media-heading">'+value.notification_description+'</h6>';
  //                 html += '            <small class="notification-text">'+formatDateValue(value.created_at)+'</small>';
  //                 html += '        </div>';
  //                 html += '    </div>';
  //                 html += '</div>';

  //             });

  //             $('#unread-notifications-container').append(html);

  //         }else{
  //             $('#unread-notifications-container').append('<h6 class="text-center text-muted mt-2 mb-2">No Notifications!</h6>');
  //         }

  //     }

  //     $('body').on('click', '.notify-action', function(e) {

  //         e.preventDefault();

  //         var notify_id = $(this).attr('data-id');

  //         getResponseInJsonFromURL(baseUrl+'notification/markAsReadNotification/'+notify_id, '', (response) => {

  //             var action_type = $(this).attr('data-action-type');
  //             var redirec_url = baseUrl+'notification/all';

  //             if(action_type != ''){
  //                 var booking_id = $(this).attr('data-action-id');
  //                 if(action_type == 127){
  //                     if(booking_id != ''){
  //                         redirec_url = baseUrl+'appoinment/view/'+booking_id;
  //                     }
  //                 }else if(action_type == 128){
  //                     if(booking_id != ''){
  //                         redirec_url = baseUrl+'test_booking/view/'+booking_id;
  //                     }
  //                 }

  //             }
  //             window.location.href = redirec_url;

  //         }, (error) => { console.log(error); });


  //     });

  //     $('body').on('click','#notify-all-read-btn',function(){
  //         getResponseInJsonFromURL(baseUrl+'notification/markAsReadAllNotifications', '', (response) => {
  //             getNotifications();
  //         }, (error) => { console.log(error); });
  //     });

  //     getNotifications();

  //     setInterval(getNotifications, 10000);   // 10 seconds(miliseconds)

  // @endif

</script>
