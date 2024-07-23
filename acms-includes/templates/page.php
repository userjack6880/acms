<?php
/* ----------------------------------------------------------------------------

Anomaly CMS
Copyright (C) 2023 - John Bradley (userjack6880)

index.php
  simple markdown blog/cms platform

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

$parsedContent = new Parsedown();

?>

<!DOCTYPE html>
<html prefix="og: https://ogp.me/ns#">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width; initial-scale=1.0">

    <meta property="og:site_name" content="Pi HPC" />
    <meta property="og:title" content="<?php echo $GLOBALS['title']; ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" />
    <meta property="og:image" content="<?php echo $GLOBALS['postImage']; ?>" />
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:description" content="<?php echo $GLOBALS['summary']; ?>" />

    <link rel="icon" href="https://j3b.in/pihpc/images/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="https://j3b.in/pihpc/images/favicon.ico" type="image/x-icon" />
<?php if ($GLOBALS['adobe_consent'] == 1) { ?>
    <link rel="stylesheet" type="text/css" href="https://use.typekit.net/knv3xjk.css">
<?php } ?>
    <link rel="stylesheet" type="text/css" href="https://j3b.in/pihpc/acms-includes/templates/style.css" />
    <style type="text/css">
      @media print {
      }
      @media (max-width:946px) {
      }
      @media (max-width:660px) {
      }
      @media (max-width:590px) {
      }
      @media (max-width:550px) {
      }
    </style>
    <title>Pi HPC - <?php echo $GLOBALS['title']; ?></title>
  </head>
  <body>
    <div id="body">
      <div id="header">
        <div>
          <a href="https://j3b.in/pihpc">
            <div id="header-logo">
              <img src="https://j3b.in/pihpc/images/pi_logo.png" alt="Pi HPC" class="logo" />
            </div>
          </a>
          <a href="https://j3b.in/pihpc">
            <div class="header-nav">
              <h1 class="logo">Pi HPC</h1>
            </div>
          </a>
        </div>
      </div>

      <div class="full-box">
        <div>

        <?php echo $parsedContent->text($GLOBALS['content']); ?>

        <br>
        </div>
      </div>

      <div id="footer">
        <div>
          <p>
            <a href="https://j3b.in/pihpc" class="foot">home</a> |
            <a href="https://j3b.in/pihpc/about" class="foot">about</a> |
            <a href="https://j3b.in/pihpc/instructors" class="foot">instructors</a>
          </p>
          <p xmlns:cc="http://creativecommons.org/ns#" xmlns:dct="http://purl.org/dc/terms/"><a property="dct:title" rel="cc:attributionURL" href="https://j3b.in/pihpc">Pi HPC</a> by <a rel="cc:attributionURL dct:creator" property="cc:attributionName" href="https://systemanomaly.com">John Bradley</a> is licensed under <a href="http://creativecommons.org/licenses/by-nc-sa/4.0/?ref=chooser-v1" target="_blank" rel="license noopener noreferrer" style="display:inline-block;">CC BY-NC-SA 4.0<img style="height:22px!important;margin-left:3px;vertical-align:text-bottom;" src="https://mirrors.creativecommons.org/presskit/icons/cc.svg?ref=chooser-v1"><img style="height:22px!important;margin-left:3px;vertical-align:text-bottom;" src="https://mirrors.creativecommons.org/presskit/icons/by.svg?ref=chooser-v1"><img style="height:22px!important;margin-left:3px;vertical-align:text-bottom;" src="https://mirrors.creativecommons.org/presskit/icons/nc.svg?ref=chooser-v1"><img style="height:22px!important;margin-left:3px;vertical-align:text-bottom;" src="https://mirrors.creativecommons.org/presskit/icons/sa.svg?ref=chooser-v1"></a></p>
        </div>
      </div>
    </div>
  </body>
</html>