<?php
$id = '';
if(isset($_POST['id'])) $id = $_POST['id'];

$_SESSION['changeHub'] = $id;
?>