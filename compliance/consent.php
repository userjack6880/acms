<?php

if (isset($_POST['consent_submit'])) {
  # if the adobe_consent post is set, save the value
  if (isset($_POST['adobe_consent'])) {
    $adobe_consent = $_POST['adobe_consent'];
  }
  else {
    $adobe_consent = 0;
  }

  # should always be set
  $uri = $_POST['uri'];

  # generate the unique ID for the cookie
  $cookie_serial = uniqid();

  # get the region
  $country_code = $_SERVER['COUNTRY_CODE'];

  # now put it in the DB and create a cookie
  try {
    $pdo = new PDO("mysql:host=10.0.0.3;dbname=privacy_consent;port=3306","systeman_user","Eas7PP6dUEuqCOEY");
  }
  catch (PDOException $e) {
    echo 'Connection failed: '.$e->getMessage();
    echo "<br>";
  }

  setcookie("consent_serial", $cookie_serial, time()+2592000, '/', 'j3b.in');

  try {
    $statement = $pdo->prepare("INSERT INTO consent(cookie_serial, region, adobe_consent) VALUES(:cookie_serial, :region, :adobe_consent)");
    $statement->execute(['cookie_serial'  => $cookie_serial,
                         'region'         => $country_code,
                         'adobe_consent'  => $adobe_consent]);
  }
  catch (PDOException $e) {
    echo 'Could not perform query: '.$e->getMessage();
  }
  
  $pdo = NULL;

  header("Location: ".$uri);
  die;
}
# present information and get consent from the user
else {
?>
<html prefix="og: https://ogp.me/ns#">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width; initial-scale=1.0">

		<link rel="icon" href="favicon.ico" type="image/x-icon" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
		<style type="text/css">
			body {
				font-family: serif;
				-webkit-font-smoothing: antialiased;
				color: #fff;
				background-color: #333;
				text-align: justify;
			}
			#body {
				width: 948px;
				margin: 0 auto;
			}
			a:link {
				text-decoration: none;
				color: #CCC;
			}
			a:visited {
				text-decoration: none;
				color: #CCC;
			}
			a:active {
				text-decoration: none;
				color: #FFF;
			}
			a:hover {
				text-decoration: none;
				color: #FFF;
			}
			input[type=checkbox] {
				width: 15px; 
				height: 15px;
				-webkit-border-radius: 5px; 
				-moz-border-radius: 5px; 
				border-radius: 5px;
				border: 1px solid #bbb;
				margin: 10px;
			}
			p {
				-webkit-column-break-inside: avoid;
				page-break-inside: avoid;
				break-inside: avoid;
			}
      p.small {
        font-size: 12px;
      }
      input[type=submit] {
					-webkit-appearance: none; 
					-moz-appearance: none;
					display: block;
					margin: 5px auto 5px auto;
					font-size: 18px; 
					line-height: 30px;
					color: #333;
					font-weight: bold;
					height: 40px; 
					width: 90%;
					background: #fdfdfd; 
					background: -moz-linear-gradient(top, #fdfdfd 0%, #bebebe 100%); 
					background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#fdfdfd), color-stop(100%,#bebebe)); 
					background: -webkit-linear-gradient(top, #fdfdfd 0%,#bebebe 100%); 
					background: -o-linear-gradient(top, #fdfdfd 0%,#bebebe 100%); 
					background: -ms-linear-gradient(top, #fdfdfd 0%,#bebebe 100%); 
					background: linear-gradient(to bottom, #fdfdfd 0%,#bebebe 100%);
					border: 1px solid #bbb;
					-webkit-border-radius: 10px; 
					-moz-border-radius: 10px; 
					border-radius: 10px;
				}	
        h1, h2 {
          font-family: sans-serif;
        }

			@media (max-width:946px) {
				#body {
					width: 100%;
					margin: 0;
					padding: 0;
				}
				.two-col {
					column-count: 1;
					text-align: center;
				}
				#footer {
					width: 100%;
					margin: 0;
					padding: 0;
				}
				.form {
					width: 100%;
					margin-left: auto;
					margin-right: auto;
					font-size: 24pt;
				}
				input[type=checkbox] {
					width: 15px; 
					height: 15px;
					-webkit-border-radius: 22px; 
					-moz-border-radius: 22px; 
					border-radius: 22px;
				}
				input[type=submit] {
					-webkit-appearance: none; 
					-moz-appearance: none;
					display: block;
					margin: 5px auto 5px auto;
					font-size: 24px; 
					line-height: 40px;
					color: #333;
					font-weight: bold;
					height: 80px; 
					width: 90%;
					background: #fdfdfd; 
					background: -moz-linear-gradient(top, #fdfdfd 0%, #bebebe 100%); 
					background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#fdfdfd), color-stop(100%,#bebebe)); 
					background: -webkit-linear-gradient(top, #fdfdfd 0%,#bebebe 100%); 
					background: -o-linear-gradient(top, #fdfdfd 0%,#bebebe 100%); 
					background: -ms-linear-gradient(top, #fdfdfd 0%,#bebebe 100%); 
					background: linear-gradient(to bottom, #fdfdfd 0%,#bebebe 100%);
					border: 1px solid #bbb;
					-webkit-border-radius: 10px; 
					-moz-border-radius: 10px; 
					border-radius: 10px;
				}	
			}
    </style>
    <title>System Anomaly Privacy Consent Form</title>
  </head>
  <body>
    <div id="body">
      <h1>One Moment Please!</h1>

      <p>It looks like you are from the Europeon Economic Area (EEA). Please read the following before continuing.</p>

      <p>Users in the European Economic Area have the right to request access to, rectification of, or erasure of their personal data; to data portability in certain circumstances; to request restriction of processing; to object to processing; and to withdraw consent for processing where they have previously provided consent.</p>

      <h2>Necessary Cookies</h2>

      <p>We make a concsious choice to use the minimum number of cookies to provide you with our Services, and do not use them to track users outside of our Services. They are simply used to ensure continuation of existing sessions, preferences, and settings. You may clear this information as you see fit, and you may disable the use of cookies through your browser settings. Do note that disabling cookies completely may break functionality of this site.</p>

      <h1>Additional Opt-Ins</h1>

      <form action="consent.php" method="post">
        <h2>Adobe Font Service</h2>

        <p>The Adobe Font Service is provided to us as a way to better deliver a consistent branding among Services provided under the System Anomaly Brand and Anomaly Sub-Brands, and are embedded in some portions of our Services.</p>
        
        <p class="small">Adobe collects information such as fonts served, service providing the fonts, the application requesting the fonts, the server serving the fonts, the hostname of the page loading the fonts, the amount of time it takes the web browser to download the font, the amount of time it takes from when the web browser downloads the fonts to when it is applied, if an ad blocker is installed to help identify whether the presense of an ad blocker affects accurate pageview tracking, and os and browser version. Additionally Adobe collects information about our Service. Adobe uses this information collected to provision the Adobe Fonts service and diagnose delivery or download problems. The information is also used to pay or fulfill Adobe's contracts with the font foundries whose fonts are utilized. Information collected about us, but not our users, is shared with the font foundaries to enable font foundaries to verify that we have a valid license to use those fonts. Adobe does not use or set cookies in order to serve fonts.</p>
        
        <p><em>I consent to the use of the Adobe Font Service. </em><input type="checkbox" name="adobe_consent" value="1"></p>

        <input type="hidden" name="uri" value="<?php echo $_GET['uri']; ?>">
        <input type="hidden" name="consent_submit" value="1">

        <hr>

        <p><a href="https://systemanomaly.com/policies/privacy/">Please see our Privacy Policy for additional details.</a></p>

        <p><em>By clicking "Submit", you acknowlege, understand, and accept what you are consenting to.</em></p>
        <p><input type="submit" value="Submit"></p>
      </form>
    </div>
  </body>
</html>

<?php
}
?>
