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

function load_file( $page = 'DEFAULT' ) {
  global $content;
  global $template;
  global $title;
  global $summary;
  global $postImage;
  global $postDate;

  // if no page specified on load, then get it from html methods
  if ($page == "DEFAULT") {
    // load either specified md file or index if not defined
    $page = filter_input(INPUT_GET, 'p', FILTER_SANITIZE_STRING);

    // if not set, set to a default value
    if (empty($page)) {
      $page = 'index';
    }
  }

  // truncate any trailing slashes for the next section
  $page = rtrim($page, '/');

  // get the content
  if (file_exists($_SERVER['DOCUMENT_ROOT'].$GLOBALS['base_dir']."/content/$page.md")) {
    $content = file_get_contents($_SERVER['DOCUMENT_ROOT'].$GLOBALS['base_dir']."/content/$page.md");
  }
  // elseif (!file_exists($_SERVER['DOCUMENT_ROOT'].$GLOBALS['base_dir']."/content/index.md")) {
  //   // something is wrong and the file isn't being loaded
  //   header("Refresh:0");
  // }
  else {
    $content = file_get_contents($_SERVER['DOCUMENT_ROOT'].$GLOBALS['base_dir']."/content/index.md");
  }
  
  // first 4 lines are dedicated to metadata (and a divider)
  $lines = explode("\n", $content);
  $metadata = array_slice($lines, 0, 6);
  $content  = implode("\n", array_slice($lines, 6));

  // parse the metadata
  $template  = $metadata[0];
  $summary   = $metadata[2];
  $postDate  = $metadata[4];

  if ($metadata[3] == '') {
    $postImage = "https://systemanomaly.com/images/landing_bg/bg03.png";
  }
  else {
    $postImage = $metadata[3];
  }

  if ($metadata[1] == "index") {
    $title = "Home";
  }
  else {
    $title = $metadata[1];
  }

  return $metadata;
}

function load_page() {
  include 'templates/'.$GLOBALS['template'].".php";
}

function load_blog() {
  global $blogEntries;
  $blogMeta = array();
  $offset = filter_input(INPUT_GET, 'offset', FILTER_SANITIZE_STRING);

  // if not set, set to a default value
  if (empty($offset)) {
    $offset = 0;
  }

  // expand the content into an array so we can iterate each item
  $blogEntries = explode("\n", $GLOBALS['content']);

  $count = 0;
  foreach ($blogEntries as $entry) {
    // if it's blank or just whitespace, skip
    if (preg_match('/^\s*$/', $entry)) {
      unset($blogEntries[$count]);
      $count++;
      continue;
    }
    else {
      $count++;
    }
  }

  $blogMeta["count"] = count($blogEntries);

  // remove any entries before the offset
  $blogEntries = array_slice($blogEntries, $offset, 10);

  $count = 0;
  foreach ($blogEntries as $entry) {
    // load each entry, get the title, summary, and postImage
    $metadata = load_file("blog/$entry");
    $blogMeta[$entry]["title"]      = $metadata[1];
    $blogMeta[$entry]["date"]       = $metadata[4];
    $blogMeta[$entry]["summary"]    = $metadata[2];
    $blogMeta[$entry]["postImage"]  = $metadata[3];
  }

  return $blogMeta;
}

function blog_pagination( $blogMeta ) {
  $offset = filter_input(INPUT_GET, 'offset', FILTER_SANITIZE_STRING);

  // if not set, set to a default value
  if (empty($offset)) {
    $offset = 0;
  }

  $prevOffset = $offset - 10;
  $nextOffset = $offset + 10;

  // if the offset is 0, we don't print the previous
  if ($offset != 0) {
    echo '<a href=https://systemanomaly.com/blog?offset='.$prevOffset.'>Previous</a>';
  }

  // if the offset is not 0, and the next offset is less than the total count, print separator
  if ($offset != 0 && $nextOffset < $blogMeta["count"]) {
    echo ' | ';
  }

  // if the next offset is less than total count, print next offset
  if ($nextOffset < $blogMeta["count"]) {
    echo '<a href=https://systemanomaly.com/blog?offset='.$nextOffset.'>Next</a>';
  }
}

?>