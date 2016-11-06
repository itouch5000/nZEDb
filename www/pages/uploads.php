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
    $userurl = WWW_TOP . "/uploads?id=".$_GET["id"]."&offset=";
  }
} elseif (isset($_GET["name"])) {
  $res = $page->users->getByUsername($_GET["name"]);
  if ($res) {
    $uid = $res["id"];
    $username = $res["username"];
    $userurl = WWW_TOP . "/uploads?name=".$_GET["name"]."&offset=";
  }
} else {
  $uid = $page->userdata["id"];
  $username = $page->userdata["username"];
  $userurl = WWW_TOP . "/uploads?offset=";
}

$page->title = sprintf("%s's Uploads", $username);

$offset   = (isset($_REQUEST["offset"]) && ctype_digit($_REQUEST['offset'])) ? $_REQUEST["offset"] : 0;

$query = sprintf("SELECT * FROM releases WHERE upload_user = %d ORDER BY adddate DESC LIMIT %d OFFSET %d",  $uid, ITEMS_PER_PAGE, $offset);
$releases = $db->query($query, true, nZEDb_CACHE_EXPIRY_MEDIUM);

$count = $db->query(sprintf(  'SELECT COUNT(z.id) AS count FROM (%s LIMIT %s) z',  preg_replace('/SELECT.+?FROM\s+releases/is', 'SELECT id FROM releases', $query),  nZEDb_MAX_PAGER_RESULTS));
$grabs = $db->query(sprintf(  'SELECT SUM(z.grabs) AS count FROM (%s LIMIT %s) z',  preg_replace('/SELECT.+?FROM\s+releases/is', 'SELECT grabs FROM releases', $query),  nZEDb_MAX_PAGER_RESULTS));

$page->smarty->assign(
  [
    'pagertotalitems' => (isset($count[0]['count']) ? $count[0]['count'] : 0),
    'pageroffset' => $offset,
    'pageritemsperpage' => ITEMS_PER_PAGE,
    'pagerquerysuffix' => "#results",
    'pagerquerybase' => $userurl,
    'grabs' => $grabs[0]['count'],
    'releaselist' => $releases,
    'pager' => $page->smarty->fetch("pager.tpl")
  ]
);

$page->content = $page->smarty->fetch('uploads.tpl');
$page->render();
