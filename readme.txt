+--------------------------------------------------------+
| Type: ...... Panel
| Name: ...... Stop Forum Spam Panel
| Version: ... 1.00
| Author: .... Valerio Vendrame (lelebart)
| Released: .. Mar, 9th 2011
| Download: .. http://www.php-fusion.it
+--------------------------------------------------------+
| Using the API of www.stopforumspam.com
+--------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------+

	/************************************************\
	
		Table of Contents
		- Description
		- Installation
		- Usage
		- Feature
		- Authors
		- Changelog
		- Future Releases
		- Notes for Developers
		
	\************************************************/

+-------------+
| DESCRIPTION |
+-------------+

With this panel you can relax, while:
- detecting silently spam with stopforumspam api,
- blacklisting and avoiding current actions.
- by default it prevent register.php, the comment system, shoubox and his archive, guestbook infusion.
- set this panel as upper center, just before the central content is loaded.


+--------------+
| INSTALLATION |
+--------------+

1. Upload the 'stop_forum_spam_panel' folder to your Infusions folder on your webserver;
2. Go to System Admin -> Panels;
3. Click "Add new panel": 
 3.1. give a significative title,
 3.2. select from the drop-down menu 'stop_forum_spam_panel',
 3.3. set the position as 'Upper Center',
 3.4. choose the visibilty (Public),
 3.5. tick 'Display panel on all pages',
 3.6. type your administration password and
 3.7. click "Save";
4. Set the order and the side of the panel created right away.


+-------+
| USAGE |
+-------+

Take a tea break, check how the blacklist is being filled.
If you want to enable ipv6 bloking, you simply need to past the following code into a custom page and preview it once only
<?php
dbquery("ALTER TABLE ".DB_BLACKLIST." CHANGE blacklist_ip blacklist_ip VARCHAR(45) NOT NULL default ''");
dbquery("ALTER TABLE ".DB_CAPTCHA." CHANGE captcha_ip captcha_ip VARCHAR(45) NOT NULL default ''");
dbquery("ALTER TABLE ".DB_COMMENTS." CHANGE comment_ip comment_ip VARCHAR(45) NOT NULL default ''");
dbquery("ALTER TABLE ".DB_FLOOD_CONTROL." CHANGE flood_ip flood_ip VARCHAR(45) NOT NULL default ''");
dbquery("ALTER TABLE ".DB_FORUM_POLL_VOTERS." CHANGE forum_vote_user_ip forum_vote_user_ip VARCHAR(45) NOT NULL default ''");
dbquery("ALTER TABLE ".DB_RATINGS." CHANGE rating_ip rating_ip VARCHAR(45) NOT NULL default ''");
dbquery("ALTER TABLE ".DB_ONLINE." CHANGE online_ip online_ip VARCHAR(45) NOT NULL default ''");
dbquery("ALTER TABLE ".DB_POSTS." CHANGE post_ip post_ip VARCHAR(45) NOT NULL default ''");
dbquery("ALTER TABLE ".DB_SESSIONS." CHANGE session_ip session_ip VARCHAR(45) NOT NULL default ''");
dbquery("ALTER TABLE ".DB_SHOUTBOX." CHANGE shout_ip shout_ip VARCHAR(45) NOT NULL default ''");
dbquery("ALTER TABLE ".DB_SUSPENDS." CHANGE suspend_ip suspend_ip VARCHAR(45) NOT NULL default ''");
dbquery("ALTER TABLE ".DB_SUSPENDS." CHANGE reinstate_ip reinstate_ip VARCHAR(45) NOT NULL default ''");
dbquery("ALTER TABLE ".DB_USERS." CHANGE user_ip user_ip VARCHAR(45) NOT NULL default ''");
?>

	
+----------+
| FEATURES |
+----------+

- check spam activites on php-fusion and blacklist ip and e-mail addesses
+ Compatible with:
  - PHP-Fusion 7.01.xx

  
+---------+
| AUTHORS |
+---------+

 name - website ............................................ |  0.00 |  1.00 |
-------------------------------------------------------------+-------+-------+
 Valerio Vendrame (lelebart) - http://www.valeriovendrame.it |   *   |   *   |

 
+-----------+
| CHANGELOG |
+-----------+

+ 1.00 (Mar, 9th 2011)
  - First public Release

+ 0.00 (Mar, 1st 2011)
  - Concept, main stuffs


+-----------------+
| FUTURE RELEASES |
+-----------------+

+ 1.01 - n/a
  - Administrative settings page (infusion)
  - Statistics (infusion)
 
 
+----------------------+
| NOTES for DEVELOPERS |
+----------------------+

1. Have Fun ;)
2. For Micorsoft Windows users only: Notepad++ rocks! - http://notepad-plus.sourceforge.net/