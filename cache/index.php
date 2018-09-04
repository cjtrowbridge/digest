<?php

//This script receives urls and returns the contents if the url is found in the whitelist file.

function sha256($Input){
  return hash('sha256',$Input);
}

//Make sure there is a whitelist file
if(!(file_exists('whitelist.php'))){
  $Key = sha256(uniqid('',true));
  file_put_contents('whitelist.php','<?php $Key = "'.$Key.'";'.PHP_EOL.'$Whitelist=array();'.PHP_EOL.PHP_EOL);
}

include('whitelist.php');

if(
  isset($_REQUEST['key']) &&
  $_REQUEST['key'] == $Key
){
  if(isset($_REQUEST['add'])){
    file_put_contents('whitelist.php','$Whitelist[]="'.$_REQUEST['add'].'";'.PHP_EOL,FILE_APPEND);
  }
}
