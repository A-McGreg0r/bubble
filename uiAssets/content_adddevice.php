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
                    <div class="row justify-content-center">
                        <div class="text-center align-middle">
                            <h3>Add new devices by scanning the QR code on the device</h3>
                        </div>
                        <div class="align-middle">
                            <input type="button" onclick="submitImage();" id="submitImage">
                                <div style="position:absolute; left: 50%; top:90%; transform: translate(-50%, -50%);">
                                    <i class="fas fa-dot-circle fa-5x"></i>
                                </div>
                            </input>
                            <video autoplay="true" id="videoElement" style="width:100%">
                            </video>
                            <div id="capturedimage"></div>
                        </div>
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