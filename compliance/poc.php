<?php

try {
  $pdo = new PDO("mysql:host=10.0.0.3;dbname=privacy_consent;port=3306","systeman_user","Eas7PP6dUEuqCOEY");
}
catch (PDOException $e) {
  echo 'Connection failed: '.$e->getMessage();
  echo "<br>";
}
echo "consent test<br>";
echo "getting cookie<br>";
if (isset($_COOKIE["consent_serial"])) {
  echo "cookie get<br>";
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
  
  $row = $query->fetch(PDO::FETCH_ASSOC);

  echo "cookie serial: ".$_COOKIE["consent_serial"]."<br>";
  echo "region: ".$row['region']."<br>";
  echo "adobe consent: ".$row['adobe_consent']."<br>";
  echo "google consent: ".$row['google_consent']."<br>";
}
else {
  echo "no cookie, setting<br>";
  $cookie_serial = uniqid();
  setcookie("consent_serial", $cookie_serial, time()+2592000);
  try {
    $statement = $pdo->prepare("INSERT INTO consent(cookie_serial, region) VALUES(:cookie_serial, :region)");
    $statement->execute(['cookie_serial' => $cookie_serial,
                         'region'        => 'US']);
  }
  catch (PDOException $e) {
    echo 'Could not perform query: '.$e->getMessage();
  }
}

$pdo = NULL;
