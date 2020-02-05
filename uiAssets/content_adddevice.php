<?php
include_once dirname(__DIR__).'/required/config.php';

function generateQRReader(){
    $html = '';
    $op = '';

    $html .= <<<pageHTML
    <div class="container">
        <div class="col-lg-12">
            <div class="row justify-content-center">
                <div class="text-center align-middle">
                    <h3>Add new devices by scanning the QR code on the device</h3>
                    <div id="devicetext" style="width:100%"></div>
                </div>
                <div class="align-middle">
                    <div style="position:absolute; left: 50%; top:50%; transform: translate(-50%, -50%);">
                        <div style="visibility: hidden" id="loading" class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <div style="position:absolute; left: 50%; top:90%; transform: translate(-50%, -50%);">
                        <button type="button" onclick="submitImage();" id="submitImage">
                            <i class="fas fa-dot-circle fa-5x"></i>
                        </button>
                    </div>
                    <video autoplay="true" id="videoElement" style="width:100%"></video>
                    <div id="capturedimage" style="width:100%; height:100%; display:none;"></div>

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

    return $html;
}