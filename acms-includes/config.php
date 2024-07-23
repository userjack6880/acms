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

if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) {
  die("cannot be run directly");
}

global $base_url;
global $base_dir;

$base_url = "https://systemanomaly.com";
$base_dir = "/pihpc";

?>