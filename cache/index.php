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
  if(
    isset($_REQUEST['AddURL'])&&
    $_REQUEST['AddURL'] != ''
  ){
    file_put_contents('whitelist.php','$Whitelist[]="'.$_REQUEST['AddURL'].'";'.PHP_EOL,FILE_APPEND);
    header('Location: ./?key='.$_REQUEST['key']);
    exit;
  }
}

?><!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Digest Manager</title>
    <link href="https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>

  <body>
    

    <main role="main" class="container">

      <div class="starter-template">
        <h1>Digest Manager</h1>
        
        <form action="index.php" method="GET">
          
          <div class="form-group">
            <label for="key">Key</label>
            <input type="text" class="form-control" id="key" name="key" <?php if(isset($_REQUEST['key'])){ echo ' value="'.$_REQUEST['key'].'"';} ?> >
          </div>
          
          <div class="form-group">
            <label for="AddURL">Add URL</label>
            <input type="text" class="form-control" id="AddURL" name="AddURL">
          </div>
          
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        
        <?php
        
        if(
          isset($_REQUEST['key']) &&
          $_REQUEST['key'] == $Key
        ){
          echo '<h2>Whitelist:</h2>';
          echo '<ul>';
          foreach($Whitelist as $Key=> $Value){
            echo '<li>(<a href="./?key='.$_REQUEST['key'].'&refresh='.urlencode($Value).'">Refresh</a>) (<a href="./?key='.$_REQUEST['key'].'&refresh='.urlencode($Value).'">Remove</a>) <a href="'.$Value.'">'.$Value.'</a></li>';
          }
          echo '</ul>';
        }
        
        ?>
        
      </div>

    </main><!-- /.container -->

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://getbootstrap.com/docs/4.0/assets/js/vendor/popper.min.js"></script>
    <script src="https://getbootstrap.com/docs/4.0/dist../../dist/js/bootstrap.min.js"></script>
  </body>
</html>
