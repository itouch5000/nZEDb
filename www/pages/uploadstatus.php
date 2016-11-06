<?php

use nzedb\Category;
use nzedb\Groups;
use nzedb\ReleaseSearch;
use nzedb\Releases;
use nzedb\db\Settings;


if (!$page->users->isLoggedIn()) {
  $page->show403();
}

$db = new Settings();

if (isset($_GET["id"])) {
  $uid = $_GET["id"];
  $res = $page->users->getById($uid);
  if ($res) {
    $uid = $res["id"];
    $username = $res["username"];
  }
} elseif (isset($_GET["name"])) {
  $res = $page->users->getByUsername($_GET["name"]);
  if ($res) {
    $uid = $res["id"];
    $username = $res["username"];
  }
} else {
  $uid = $page->userdata["id"];
  $username = $page->userdata["username"];
}

$page->title = sprintf("%s's Upload Status", $username);
$releases = $db->query("SELECT * FROM uploads WHERE uid = " . $uid . " ORDER BY adddate DESC LIMIT 100");

$page->smarty->assign('releaselist', $releases);
$page->content = $page->smarty->fetch('uploadstatus.tpl');
$page->render();
