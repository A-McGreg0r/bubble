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
                        <video autoplay="true" id="videoElement">
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
    }

    return $html;
}
?>