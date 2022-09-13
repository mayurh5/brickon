<?php

function pre($data)
{
  echo "<pre>";
  print_r($data);
  echo "</pre>";
  exit;
}
function defaultImage()
{
  return url('/') . "/no_image.jpg";
}

function defaultUserImage()
{
  return url('/') . "/profile.svg";
}
function UniqueUserName($first_name,$last_name)
{
  $firstname = strtolower($first_name);
  $lastname = strtolower(substr($last_name, 0, 4));
  $nrRand = rand(0, 100);
  return $firstname . $lastname . $nrRand;
}

function randomPassword()
{
  $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
  $pass = array(); //remember to declare $pass as an array
  $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
  for ($i = 0; $i < 8; $i++) {
    $n = rand(0, $alphaLength);
    $pass[] = $alphabet[$n];
  }
  return implode($pass); //turn the array into a string
}
function parseDisplayTime($time)
{
  return \Carbon\Carbon::createFromFormat('H:i:s',$time)->format('h:i A');
}

function parseDisplayDate($date)
{
  return date('d M, Y', strtotime($date));
}

function parseDisplayDateTime($date)
{
  return date('d M, Y h:i A', strtotime($date));
}

function DisplayDatesMDY($date,$format = 'm/d/Y')
{
  return date($format, strtotime($date));
}
function displayDates($start, $end, $format = 'd-m-Y' )
{
  $period = new DatePeriod(new DateTime(date('Y-m-d', strtotime($start))), new DateInterval('P1D'), new DateTime(date('Y-m-d', strtotime($end)).' +1 day'));
  foreach ($period as $date) {
      $dates[] = $date->format("Y-m-d");
  }
  // Log::info("test ". print_r($dates, true));
  return $dates;
}
function getAge($dob)
{
  if ($dob) {
    $bday = new DateTime($dob); // Your date of birth
    $today = new Datetime(date('Y-m-d'));
    $diff = $today->diff($bday);
    return $diff->y;
  }
  return "";
}
