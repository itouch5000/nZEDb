<?php

use nzedb\Category;
use nzedb\Groups;
use nzedb\ReleaseSearch;
use nzedb\Releases;
use nzedb\db\Settings;


if ($page->users->isLoggedIn()) {
    $uid = $page->userdata["id"];
    $apikey = $page->userdata["rsstoken"];
    $catexclusions = $page->userdata["categoryexclusions"];
    $maxrequests= $page->userdata['apirequests'];
} else {
    $apikey= isset($_POST["apikey"]) ? $_POST["apikey"] : false;
    if (!$apikey) {
      $page->show403();
    }
    $res = $page->users->getByRssToken($apikey);
    if (!$res) {
			$page->show403();
		}
    $uid = $res["id"];
}

if ($_POST) {
	if (isset($uid) && isset($_FILES['Filedata'])) {

      //clean the name from extension and pass
	    $fname = preg_replace('/\.nzb(\.gz)?$/i', '', $_FILES['Filedata']['name']);
	    $fname = preg_replace('/{{.*}}/i', '', $fname);

	    if (move_uploaded_file($_FILES['Filedata']['tmp_name'], "nzbupload/upload/".$_FILES['Filedata']['name'])) {
		      chmod("nzbupload/upload/".$_FILES['Filedata']['name'],0777);
	        echo "Das File wurde Erfolgreich nach uploads/".$_FILES['Filedata']['name']." hochgeladen";
	    } else {
	        echo "Fehler beim upload von ".$_FILES['Filedata']['name'];
	    }

      $db = new Settings();
      $fname = $db->escapeString($fname);

	    $nzb = false;
	    $nzb = $db->queryOneRow("SELECT * from uploads WHERE releasename = $fname AND status = 'pending'");
	    echo $nzb[0];
	    if (!$nzb) {
	        $db->queryExec("INSERT INTO uploads (uid, releasename) VALUES ('$uid', $fname)");
	    }
	} else {
	    print "No File Data or userid was given";
	}
} else {

  $page->title = "NZB Upload";
  $timestamp = time();
  $page->smarty->assign('timestamp', $timestamp);
  $page->smarty->assign('token', md5('unique_salt' . $timestamp));
  $page->smarty->assign('apikey', $apikey);

  $page->content = $page->smarty->fetch('upload.tpl');
  $page->render();
}
?>
