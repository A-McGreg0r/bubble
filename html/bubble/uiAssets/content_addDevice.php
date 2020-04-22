<?php
include_once dirname(__DIR__).'/required/config.php';

function generateQRReader($autoOpen = FALSE){
    $html = '';

    if($autoOpen){
        $html .= <<<html
            <script>
                $(document).ready(function(){
                    openModalHome('addDeviceModal');
                    $('#addDeviceModal').attr("auto-reload", true);

                    openCamera();
                });
            </script>
html;
    }
    $html .= <<<pageHTML

    
    <div class="modal modalStatsWrap" id="addDeviceModal">
        <div class="modalContent modalStats" id="">
            <div class="x-adjust"><i class="stats_icon_x " id="" style="display:flex" onclick="openModalHome('addDeviceModal')"><i class="fas fa-times"></i></i>
            </div>
            <div class="modalHeader"><strong>Add a new device</strong></div>
            <div class="modalBody">
                <div class="container">
                    <div class="col-lg-12">
                        <div class="row justify-content-center">
                            <div class="text-center align-middle">
                                <h3>Add a new hub or device by scanning the QR code on the device</h3>
                                <h5>Hub already setup on a different account? No worries, scan the qr code below and we will send a request to your hub's owner to allow you to connect</h5>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         </div>
    </div>

pageHTML;

    return $html;

    
    
    // <div class="modal fade" id="addDeviceModal" tabindex="-1" role="dialog" aria-labelledby="addDeviceModalLabel" aria-hidden="true">
    //     <div class="modal-dialog modal-dialog-centered" role="document">
    //         <div class="modal-content">
    //             <div class="modal-header">
    //                 <h5 class="modal-title" id="addDeviceModalLabel">Add a new device</h5>
    //                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    //                 <span aria-hidden="true">&times;</span>
    //                 </button>
    //             </div>
    //             <div class="modal-body">
    //                 <div class="container">
    //                     <div class="col-lg-12">
    //                         <div class="row justify-content-center">
    //                             <div class="text-center align-middle">
    //                                 <h3>Add a new hub or device by scanning the QR code on the device</h3>
    //                                 <h5>Hub already setup on a different account? No worries, scan the qr code below and we will send a request to your hub's owner to allow you to connect</h5>
    //                                 <div id="devicetext" style="width:100%"></div>
    //                             </div>
    //                             <div class="align-middle">
    //                                 <div style="position:absolute; left: 50%; top:50%; transform: translate(-50%, -50%);">
    //                                     <div style="visibility: hidden" id="loading" class="spinner-border text-primary" role="status">
    //                                         <span class="sr-only">Loading...</span>
    //                                     </div>
    //                                 </div>
    //                                 <div style="position:absolute; left: 50%; top:90%; transform: translate(-50%, -50%);">
    //                                     <button type="button" onclick="submitImage();" id="submitImage">
    //                                         <i class="fas fa-dot-circle fa-5x"></i>
    //                                     </button>
    //                                 </div>
    //                                 <video autoplay="true" id="videoElement" style="width:100%"></video>
    //                             </div>
    //                         </div>
    //                     </div>
    //                 </div>                
    //             </div>
    //         </div>
    //     </div>
    // </div>
   
}