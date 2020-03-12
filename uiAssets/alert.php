<?php
alert("Hello World");

function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}

$command = escapeshellcmd('python /home/pi/tmpsftp.py "1110123456" "1"');
$output = shell_exec($command);
echo $output;
?>
