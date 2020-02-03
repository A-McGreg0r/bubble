<?php
include_once dirname(__DIR__).'/required/config.php';

function generateQRReader(){
    $html = '';
    $op = '';
    if(isset($_GET['op'])) $op = $_GET['op'];

    switch($op){
        case "upload":
            $html = "bypass";
            $_SESSION['hub_id'] = 1;
        break;
        default:
            $html .= <<<pageHTML
            <div class="container">
                <div class="col-lg-12">
                    <div class="row">
                        <h3 class="text-center">Add new devices by scanning the QR code on the device</h3>
                        <video autoplay="true" id="videoElement" style="width:100%">
                            <i class="far fa-circle text-center"></i>
                        </video>
                    </div>
                </div>
            </div>

            <script type="text/javascript">

                var video = document.querySelector("#videoElement");

                if (navigator.mediaDevices.getUserMedia) {
                    navigator.mediaDevices.getUserMedia(
                        { video: true }
                    ).then(function (stream) {
                        video.srcObject = stream;
                    })
                    .catch(function (err0r) {
                    console.log("Something went wrong!");
                    });
                }
            </script>
pageHTML;
            break;
    }

    return $html;
}