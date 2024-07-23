<?php
/* ----------------------------------------------------------------------------

Anomaly CMS
Copyright (C) 2023 - John Bradley (userjack6880)

compliance.php
  simple markdown blog/cms platform
  compliance plugin

-------------------------------------------------------------------------------

This file is part of Anomaly CMS.

Anomaly CMS is free software: you can redistribute it and/or modify it under
the terms of the GNU General Public License as published by the Free Software 
Foundation, either version 3 of the License, or (at your option) any later 
version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY 
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with 
this program.  If not, see <https://www.gnu.org/licenses/>.

---------------------------------------------------------------------------- */

function compliance() {
  # check to see if we are inside the EEA
  $eea = '/AT|BE|BG|HR|CY|CZ|DK|EE|FI|FR|DE|EL|HU|IE|IT|LV|LT|LU|MT|NL|PL|PT|RO|SK|SI|ES|SE|UK|IS|LI|NO/';

  # sometimes it throws an error when a country code isn't returned - we'll err on caution
  if (!isset($_SERVER['COUNTRY_CODE'])) {
    $GLOBALS['adobe_consent']  = 0;
    return;
  }
  
  if (preg_match($eea, $_SERVER['COUNTRY_CODE'])) {
    # check if the user has cookies enabled - if they do not, then assume they do not consent to anything
    if (!isset($_COOKIE["cookies_enabled"])) {
      if (isset($_GET['reload'])) {
        $GLOBALS['adobe_consent']  = 0;
        return;
      }
      else {
        setcookie('cookies_enabled', 1, time()+2592000, '/', 'j3b.in');
        header('Location: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'?reload');
        die;
      }
    }

    # connect to DB
    try {
      $pdo = new PDO("mysql:host=10.0.0.3;dbname=privacy_consent;port=3306","systeman_user","Eas7PP6dUEuqCOEY");
    }
    catch (PDOException $e) {
      echo 'Connection failed: '.$e->getMessage();
      echo "<br>";
    }

    # check to see if there's a cookie set
    if (isset($_COOKIE["consent_serial"])) {
      # if there is a cookie, then get the data from it
      try {
        $query = $pdo->prepare("SELECT * FROM consent WHERE cookie_serial=:cookie_serial ORDER BY creation DESC");
        $query->execute(['cookie_serial' => $_COOKIE["consent_serial"]]);
        if ($query->errorCode() != 0) {
          $errors = $query->errorInfo();
          echo " failed: ".$errors[2]."<br>";
          exit();
        }
      }
      catch (PDOException $e) {
        echo 'Could not perform query: '.$e->getMessage();
      }

      # only one row is needed
      $row = $query->fetch(PDO::FETCH_ASSOC);
      
      $GLOBALS['adobe_consent']  = $row['adobe_consent'];
    }
    # if there isn't a cookie, redirect to consent page
    else {
      header("Location: https://j3b.in/pihpc/compliance/consent.php?uri=https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
      die;
    }

    $pdo = NULL;
  }
  else {
    # not in the EEA, consent is not needed
    
    $GLOBALS['adobe_consent']  = 1;
  }
}

?>