<?php
include_once 'config.php';

function generateOnOff_device() {
    global $db;

    $status = $_SESSION['status'];
    $hub_id = $_SESSION['hub_id'];
    $device_id = $_SESSION['device_id'];
    $device_name = $_SESSION['device_name'];

    $set_device = 0;
    $on_or_off = 'off';

    if ($status == 0){
        $set_device = 1;
        $on_or_off = 'on';
    }

    $html = <<<html
    <div class="container">
        <div class="text-center">
            <div class="text-center confirmation">
                <img class="confirmation-logo" src="img/favicon.png" onload="load()">
                <p class="text-center">You have turned $on_or_off $device_name</p>
            </div>
        </div>

        <script>
    
        window.onload = function(){setTimeout(function(){ window.location = "index.php"; }, 1000)};

        </script>
    </div>   
html;

    $stmt = $db->prepare("UPDATE device_info SET device_status = ? WHERE device_id = ?");
    $stmt->bind_param("ii", $set_device, $device_id);
    $stmt->execute();

    return $html;
}

?>