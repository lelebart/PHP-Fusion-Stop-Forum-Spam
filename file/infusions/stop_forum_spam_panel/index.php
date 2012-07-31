<?php
header('HTTP/1.1 403 Forbidden');
header('X-Powered-By: PHP-Fusion/0.SFS.0');
header('Last-Modified: '.gmdate('D, d M Y H:i:s', time()-60).' GMT');
?>
<h1>FORBIDDEN: Spam activity detected</h1>
<p>Your IP ADDRESS seems to be a spammer one and it was blacklisted.</p>
<p>If you think we are wrong, mail us: <?php echo $_SERVER['SERVER_ADMIN']; ?></p>
<?php echo $_SERVER['SERVER_SIGNATURE']; ?>