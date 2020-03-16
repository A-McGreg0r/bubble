<?php
$out = exec('/var/www/.local/bin/python2.7 /var/www/.local/www-data/pysftp.py 1357 1', $out);
var_dump($out);
?>
