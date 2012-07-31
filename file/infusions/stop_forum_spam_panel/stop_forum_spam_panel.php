<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Type: Panel
| Name: Stop Forum Spam Panel
| Version: 1.00
| Author: Valerio Vendrame (lelebart)
+--------------------------------------------------------+
| Filename: stop_forum_spam_panel.php
| Author: Valerio Vendrame (lelebart)
+--------------------------------------------------------+
| Using the API of www.stopforumspam.com
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
if (!defined("IN_FUSION")) { die("Access Denied"); }

function check_with_sfs($input,$location=false) {
	global $settings; $return = false;
	/* exit */ if (!is_array($input) || empty($input)) { return false; }
	$input = (str_replace(".", "", $settings['version']) < "70106") ? stripinput_fix($input) : stripinput($input);
	$sfs['location'] = $location ? " on ".stripinput($location) : "";
	$sfs['username'] = isset($input['username']) && !empty($input['username']) ? $input['username'] : false;
	$sfs['mail']     = isset($input['mail']) && !empty($input['mail']) ? $input['mail'] : false;
	$sfs['ip']       = isset($input['ip']) && !empty($input['ip']) ? $input['ip'] : false;
	/* exit */ if (!$sfs['username'] && !$sfs['mail'] && !$sfs['ip']) { return false; }
	$sfs['url']      = "http://www.stopforumspam.com/api?";
	$sfs['url']     .= $sfs['username'] ? "username=".$sfs['username']."&" : "";
	$sfs['url']     .= $sfs['mail'] ? "email=".$sfs['mail']."&" : "";
	$sfs['url']     .= $sfs['ip'] ? "ip=".$sfs['ip']."&" : "";
	$sfs['url']     .= "f=serial";
	$sfs['data']     = file_get_contents($sfs['url']);
	$sfs['data']     = unserialize($sfs['data']);
	if ( ( isset($sfs['data']['username']['appears']) && $sfs['data']['username']['appears']) ||
			( isset($sfs['data']['email']['appears']) && $sfs['data']['email']['appears']) || 
				(isset($sfs['data']['ip']['appears']) && $sfs['data']['ip']['appears']) ) {
		$return = true;
		$sfs['reason']   = "spam detected".$sfs['location']." with stopforumspam.com: ".$sfs['username']." ".$sfs['ip']." ".$sfs['mail']; // FIXME: localization
		$sfs['dbquery']  = dbquery("INSERT INTO ".DB_BLACKLIST." (blacklist_ip, blacklist_user_id, blacklist_email, blacklist_reason, blacklist_datestamp) VALUES ('".$sfs['ip']."', '0', '".$sfs['mail']."', '".$sfs['reason']."', '".time()."')");
	} /* clean */ unset($sfs);
	return $return;
}

function kicked_away() {
	global $settings; 
	$siteurl  = preg_match('#(http|https)://#sie',$settings['siteurl']) ? "" : "http://";
	$siteurl .= $settings['siteurl'];
	header('Location: '.$siteurl.'infusions/stop_forum_spam_panel/index.php');
}

// Strip Input Function, prevents HTML in unwanted places, lelebart fix
function stripinput_fix($text) {
	if (!is_array($text)) {
		$text    = stripslash(trim($text));
		$search  = array("&", "\"", "'", "\\", '\"', "\'", "<", ">", "&nbsp;");
		$replace = array("&amp;", "&quot;", "&#39;", "&#92;", "&quot;", "&#39;", "&lt;", "&gt;", " ");
		$text    = preg_replace("/(&amp;)+(?=\#([0-9]{2,3});)/i", "&", str_replace($search, $replace, $text));
	} else {
		foreach ($text as $key => $value) {
			$text[$key] = stripinput_fix($value);
		}
	}
	return $text;
}

if (!function_exists("trim_this")) {
	// Clean whitespaces from a given string or array, by lelebart
	function trim_this($text,$strip=false) {
		if (!is_array($text)) {
			$text = $strip ? stripinput_fix($text) : $text;
			$text = trim(preg_replace("/ +/i", " ", $text));
		} else {
			foreach ($text as $key => $value) {
				$text[$key] = trim_this($value,$strip);
			}
		}
		return $text;
	}
}

$input['ip'] = USER_IP; // $input['ip'] = "212.117.164.168";
if (!iMEMBER) { // guests only
	if (isset($_POST['register'])) { // register.php
		$input['username'] = isset($_POST['username']) ? trim_this($_POST['username'],true) : false;
		$input['mail']     = isset($_POST['email']) ? trim_this($_POST['email'],true) : false;
		if (check_with_sfs($input,"register")) {
			$_POST['username'] = ""; // unset($_POST['username']);
			$_POST['email']    = ""; // unset($_POST['email']);
		}
	} else if (isset($_POST['post_comment'])) { // comment system
		$input['username'] = isset($_POST['comment_name']) ? trim_this($_POST['comment_name'],true) : false;
		if (check_with_sfs($input,"comments")) {
			$_POST['comment_name'] = ""; // unset($_POST['comment_name']);
		}
	} else if (isset($_POST['post_shout'])) { // shoutbox_panel.php
		$input['username'] = isset($_POST['shout_name']) ? trim_this($_POST['shout_name'],true) : false;
		if (check_with_sfs($input,"shoutbox")) {
			$_POST['shout_name'] = ""; // unset($_POST['shout_name']);
		}
	} else if (isset($_POST['post_archive_shout'])) { // shoutbox_archive.php
		$input['username'] = isset($_POST['archive_shout_name']) ? trim_this($_POST['archive_shout_name'],true) : false;
		if (check_with_sfs($input,"shoutbox archive")) {
			$_POST['archive_shout_name'] = ""; // unset($_POST['archive_shout_name']);
		}
	} else if (isset($_POST['guest_submit'])) { // guest_book.php
		$input['username'] = isset($_POST['guest_name']) ? trim_this($_POST['guest_name'],true) : false;
		$input['mail']     = isset($_POST['guest_email']) ? trim_this($_POST['guest_email'],true) : false;
		if (check_with_sfs($input,"guestbook")) {
			$_POST['guest_name']  = ""; // unset($_POST['guest_name']);
			$_POST['guest_email'] = ""; // unset($_POST['guest_email']);
		}
	} else { // every part of site
		if (check_with_sfs($input)) { 
			// opentable("Spam activity detected"); echo "Your IP ADDRESS seems to be a spammer one and it was blacklisted."; closetable();
			kicked_away();
		}
	}
} // var_dump($input);
unset($input);
?>