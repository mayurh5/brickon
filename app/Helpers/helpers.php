<?php // Code within app\Helpers\Helper.php
namespace App\Helpers;
use Config;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use DateTime;
use DateTimeZone;
use DatePeriod;
use DateInterval;
use File;
use Storage;
use Hash;
use DB;
use Log;

class Helper
{
    public static function applClasses()
    {
      // Demo
      $fullURL = request()->fullurl();
      if (App()->environment() === 'production') {
          for ($i = 1; $i < 7; $i++) {
              $contains = Str::contains($fullURL, 'demo-' . $i);
              if ($contains === true) {
                  $data = config('custom.' . 'demo-' . $i);
              }
          }
      } else {
          $data = config('custom.custom');
      }


      // default data value
      $dataDefault = [
        'mainLayoutType' => 'vertical-menu',
        'theme' => 'light',
        'isContentSidebar'=> false,
        'pageHeader' => false,
        'bodyCustomClass' => '',
        'navbarBgColor' => 'bg-white',
        'navbarType' => 'fixed',
        'isMenuCollapsed' => false,
        'footerType' => 'static',
        'templateTitle' => '',
        'isCustomizer' => true,
        'isCardShadow' => true,
        'isScrollTop' => true,
        'defaultLanguage' => 'en',
        'direction' => env('MIX_CONTENT_DIRECTION', 'ltr'),
      ];

      // if any key missing of array from custom.php file it will be merge and set a default value from dataDefault array and store in data variable
      $data = array_merge($dataDefault, $data);

      // all available option of materialize template
      $allOptions = [
        'mainLayoutType' => array('vertical-menu','horizontal-menu','vertical-menu-boxicons'),
        'theme' => array('light'=>'light','dark'=>'dark','semi-dark'=>'semi-dark'),
        'isContentSidebar'=> array(false,true),
        'pageHeader' => array(false,true),
        'bodyCustomClass' => '',
        'navbarBgColor' => array('bg-white','bg-primary', 'bg-success','bg-danger','bg-info','bg-warning','bg-dark'),
        'navbarType' => array('fixed'=>'fixed','static'=>'static','hidden'=>'hidden'),
        'isMenuCollapsed' => array(false,true),
        'footerType' => array('fixed'=>'fixed','static'=>'static','hidden'=>'hidden'),
        'templateTitle' => '',
        'isCustomizer' => array(true,false),
        'isCardShadow' => array(true,false),
        'isScrollTop' => array(true,false),
        'defaultLanguage'=>array('en' => 'en','pt' => 'pt','fr' => 'fr','de' => 'de'),
        'direction' => array('ltr' => 'ltr','rtl' => 'rtl'),
      ];
      // navbar body class array
      $navbarBodyClass = [
        'fixed'=>'navbar-sticky',
        'static'=>'navbar-static',
        'hidden'=>'navbar-hidden',
      ];
      $navbarClass  = [
        'fixed'=>'fixed-top',
        'static'=>'navbar-static-top',
        'hidden'=>'d-none',
      ];
      // footer class
      $footerBodyClass = [
        'fixed'=>'fixed-footer',
        'static'=>'footer-static',
        'hidden'=>'footer-hidden',
      ];
      $footerClass = [
        'fixed'=>'footer-sticky',
        'static'=>'footer-static',
        'hidden'=>'d-none',
      ];

      //if any options value empty or wrong in custom.php config file then set a default value
      foreach ($allOptions as $key => $value) {
        if (gettype($data[$key]) === gettype($dataDefault[$key])) {
          if (is_string($data[$key])) {
            if(is_array($value)){

              $result = array_search($data[$key], $value);
              if (empty($result)) {
                $data[$key] = $dataDefault[$key];
              }
            }
          }
        } else {
          if (is_string($dataDefault[$key])) {
            $data[$key] = $dataDefault[$key];
          } elseif (is_bool($dataDefault[$key])) {
            $data[$key] = $dataDefault[$key];
          } elseif (is_null($dataDefault[$key])) {
            is_string($data[$key]) ? $data[$key] = $dataDefault[$key] : '';
          }
        }
      }

      //  above arrary override through dynamic data
      $layoutClasses = [
        'mainLayoutType' => $data['mainLayoutType'],
        'theme' => $data['theme'],
        'isContentSidebar'=> $data['isContentSidebar'],
        'pageHeader' => $data['pageHeader'],
        'bodyCustomClass' => $data['bodyCustomClass'],
        'navbarBgColor' => $data['navbarBgColor'],
        'navbarType' => $navbarBodyClass[$data['navbarType']],
        'navbarClass' => $navbarClass[$data['navbarType']],
        'isMenuCollapsed' => $data['isMenuCollapsed'],
        'footerType' => $footerBodyClass[$data['footerType']],
        'footerClass' => $footerClass[$data['footerType']],
        'templateTitle' => $data['templateTitle'],
        'isCustomizer' => $data['isCustomizer'],
        'isCardShadow' => $data['isCardShadow'],
        'isScrollTop' => $data['isScrollTop'],
        'defaultLanguage' => $data['defaultLanguage'],
        'direction' => $data['direction'],
      ];

        // set default language if session hasn't locale value the set default language
        if(!session()->has('locale')){
          app()->setLocale($layoutClasses['defaultLanguage']);
        }

      return $layoutClasses;
    }
    // updatesPageConfig function override all configuration of custom.php file as page requirements.
    public static function updatePageConfig($pageConfigs)
    {
        $demo = 'custom';
        $custom = 'custom';
        $fullURL = request()->fullurl();
        if(App()->environment() === 'production'){
            for ($i=1; $i < 7; $i++) {
                $contains = Str::contains($fullURL, 'demo-'.$i);
                if($contains === true){
                    $demo = 'demo-'.$i;
                }
            }
        }
        if (isset($pageConfigs)) {
            if (count($pageConfigs) > 0) {
                foreach ($pageConfigs as $config => $val) {
                    Config::set('custom.' . $demo . '.' . $config, $val);
                }
            }
        }
    }

    public static function defaultImage()
    {
      return url('/') . "/no_image.jpg";
    }

      // get auth user

    public static function get_auth_user()
    {
      $auth_user = auth()->user();
      $auth_user_id = $auth_user->id;

      return $auth_user_id;
    }

      // Display date

  public static function display_date_time_in_format($Datetime, $format = 'd M, Y h:i A')
  {
    return date($format, strtotime($Datetime));
  }

  public static function display_date($Datetime, $format = 'd-m-Y')
  {
    return date($format, strtotime($Datetime));
  }

  public static function date_picker_format($Datetime, $format = 'Y-m-d')
  {
    return date($format, strtotime($Datetime));
  }

    // display status

    public static function statusBadge($type){

      if ($type == 'pending') {
        echo "<span class='badge badge-warning mr-2'>Pending</span>";
      }
      if ($type == 'in progress') {
        echo "<span class='badge badge-info mr-2'>In Progress</span>";
      }
      if ($type == 'confirmed') {
        echo "<span class='badge badge-primary mr-2'>Confirmed</span>";
      }
      if ($type == 'completed') {
        echo "<span class='badge badge-success mr-2'>Completed</span>";
      }
      if ($type == 'cancelled') {
        echo "<span class='badge badge-danger mr-2'>Cancelled</span>";
      }
      if ($type == 'accept') {
        echo "<span class='badge badge-success mr-2'>ACT</span>";
      }
      if ($type == 'reject') {
        echo "<span class='badge badge-danger mr-2'>REJ</span>";
      }

    }


  // Show country, state, state code, city display in dropdown

  public static function get_all_country_data()
  {
    $country_data = Country::all();

    if(!empty($country_data))
      return $country_data;
  }

  public static function get_all_gst_state_code_data()
  {
    $gst_state_code_data = State::select('id','gst_state_code')
                                ->whereNotNull('gst_state_code')
                                ->get();

    if(!empty($gst_state_code_data))
      return $gst_state_code_data;
  }

  public static function get_city_list_by_name(Request $request)
  {
    $cities = City::select('*')
                    ->where('city_name', 'like', '%'.$request->city.'%')
                    ->get();

    // return response()->json(['data' => $cities], 200);
    return $cities;
  }

  public static function get_state_list_of_city($city_id)
  {

    $states = State::select('id', 'name', 'country_id','gst_state_code')
                    ->where('country_id', function($query) use ($city_id) {
                      $query->select('in_state.country_id')
                            ->from('all_cities as in_city')
                            ->leftJoin('states as in_state', 'in_state.id', '=', 'in_city.state_code')
                            ->where('in_city.id', $city_id);
                      })
                    ->get();


    // return response()->json(['data' => $states], 200);
    return $states;
  }

  public static function upload_document($input_file, $directory, $name = '', $is_pdf = false){

    $result = '';

    // try{

      if($is_pdf == false && isset($input_file) && !empty($input_file) && base64_decode($input_file) == true ){

        $base64_image_tmp = $input_file;

        $image_parts = explode(";base64,", $base64_image_tmp);

        $content_array = explode(':', $image_parts[0]);

        $extension_explode = explode('/', $content_array[1]);

        $extension = $extension_explode[1];

        $excel_mimetypes = array(
          'vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        );

        $csv_mimetypes = array(
          'csv',
        );

        $doc_mimetypes = array(
          'vnd.openxmlformats-officedocument.wordprocessingml.document',
        );

        if(in_array($extension, $excel_mimetypes)){

          $extension = 'xlsx';

        }else if (in_array($extension, $csv_mimetypes)) {

          $extension = 'csv';

        }else if (in_array($extension, $doc_mimetypes)) {

          $extension = 'docx';

        }else{

          $extension = explode('/', mime_content_type($base64_image_tmp))[1];

        }

        $filename = time();

        $filename =  (!empty($name) ? $name : $filename).".".$extension;

        $default_storage = config('filesystems.default');

        $default_storage_driver = config('filesystems.disks.'.$default_storage.'.driver');

        if($default_storage == 'public'){

          if(!File::isDirectory($directory)){

            File::makeDirectory($directory, 0777, true, true);

          }
        }

        $base64_content = base64_decode($image_parts[1]);

        // $base64_image = $input_file; // your base64 encoded

        // @list($type, $file_data) = explode(';', $base64_image);
        // @list(, $file_data) = explode(',', $file_data);

        $cloudResponse =  Storage::disk($default_storage_driver)->put($directory . '/' . $filename, $base64_content);

        $storage_folder_path = $directory . '/' . $filename;

        if($cloudResponse){

          $result = $storage_folder_path;

          if($default_storage != 'public'){

            $fileUrl = Storage::url($directory . '/' . $filename);

            $result = $fileUrl;

          }

        }

      }else if($is_pdf){

        $filename = time();

        $filename =  (!empty($name) ? $name : $filename).".pdf";

        $default_storage = config('filesystems.default');

        $default_storage_driver = config('filesystems.disks.'.$default_storage.'.driver');

        if($default_storage == 'public'){

          if(!File::isDirectory($directory)){

            File::makeDirectory($directory, 0777, true, true);

          }
        }

        $cloudResponse =  Storage::disk($default_storage_driver)->put($directory . '/' . $filename, $input_file);

        $storage_folder_path = $directory . '/' . $filename;

        if($cloudResponse){

          $result = $storage_folder_path;

          if($default_storage != 'public'){

            $fileUrl = Storage::url($directory . '/' . $filename);

            $result = $fileUrl;

          }

        }

      }

      return $result;

    // }catch(Exception $e) {

    //   Log::info("upload_document error ". $e->getMessage());
    //   return $result;

    // }
  }

  public static function upload_file($file="", $file_name="", $file_name_to_store ="", $file_uploaded_path="", $is_base64_file = false)
  {

      $default_storage = config('filesystems.default');

      $default_storage_driver = config('filesystems.disks.'.$default_storage.'.driver');

      if($is_base64_file == false){

          $file_name = $file->getClientOriginalName();

      }

      if($is_base64_file == true){

          $file_parts = explode(";base64,", $file);
          $base64_file_content = base64_decode($file_parts[1]);
      }

      $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);

      $base_name = basename($file_name, "." . $file_extension);
      $file_name_to_store  = Str::slug($base_name) . '.' . $file_extension;

      if($default_storage == 'public' || $default_storage == 'local'){

          if(!File::isDirectory($file_uploaded_path)){
              File::makeDirectory($file_uploaded_path, 0777, true, true);
          }
      }

      if($default_storage == 's3'){

          if($is_base64_file == false){
              Storage::disk($default_storage_driver)->put(env('AWS_BUCKET_FOLDER') . $file_uploaded_path . '/' . $file_name_to_store , file_get_contents($file->getRealPath()),'public');
          }
          else{
              Storage::disk($default_storage_driver)->put(env('AWS_BUCKET_FOLDER') . $file_uploaded_path . '/' . $file_name_to_store , $base64_file_content,'public');
          }
      }
      else{

          if($is_base64_file == false){

             Storage::disk($default_storage_driver)->put($file_uploaded_path . '/' . $file_name_to_store , file_get_contents($file->getRealPath()),'public');

          }
          else{

              Storage::disk($default_storage_driver)->put($file_uploaded_path . '/' . $file_name_to_store , $base64_file_content,'public');
          }
      }

      $file_path = $file_uploaded_path . '/' . $file_name_to_store ;
      return $file_path;
  }

  public static function deleteFile($img){

    if (!empty($img) && File::exists($img)){
    File::delete($img);
    }
  }

 public static function UniqueUserName($first_name,$last_name)
  {
    $firstname = strtolower($first_name);
    $lastname = strtolower(substr($last_name, 0, 4));
    $nrRand = rand(0, 100);
    return $firstname . $lastname . $nrRand;
  }

  public static function unlink_document($doc_path){

    try{

        File::delete(public_path($doc_path));

    }catch(\Exception $e) {
        Log::info("unlink_document error ". $e->getMessage());
    }

}

    // Generate job order no

    public static function generate_order_no($type = '', $count = 1)
    {
      $string = "";
      $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
      for ($i = 0; $i < 4; $i++)
          $string .= substr($chars, rand(0, strlen($chars)), 1);
      $number = $count;
      $number = $number + 1;
      $generate_no = str_pad($number, 4, "0", STR_PAD_LEFT);
      $seq_no = $type . $string . $generate_no;
      return $seq_no;
    }


}
