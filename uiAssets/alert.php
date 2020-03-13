<?php
alert("Hello World");

function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}
$out = shell_exec('/home/pi/testEnv/bin/python /home/pi/tmpsftp.py "1110123456" "1"');
echo $out;
?>
