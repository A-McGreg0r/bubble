<?php
include_once dirname(__DIR__).'/required/config.php';

function generateQRReader(){

    $op = '';
    if(isset($_GET['op'])) $op = $_GET['op'];

    switch($op){
        case "upload":
            $html = "bypass";
            $_SESSION['hub_id'] = 1;
        break;
        default:
        $html = <<<pageHTML

        <label>
            <!--TODo put in flx box  -->
            <input type=text size=16 placeholder="Tracking Code" class=qrcode-text>
        </label>
        <label class=qrcode-text-btn><input type=file accept="image/*" capture=environment tabindex=-1>
        </label>
    
    
        <script type="text/javascript">
            //TODO output varabuls to php for posting to DB.
            function openQRCamera(node) {
                const reader = new FileReader();
                reader.onload = function () {
                    node.value = "";
                    qrcode.callback = function (res) {
                        if (res instanceof Error) {
                            alert("No QR code found. Please make sure the QR code is within the camera's frame and try again.");
                        } else {
                            node.parentNode.previousElementSibling.value = res;
                        }
                    };
                    qrcode.decode(reader.result);
                };
                reader.readAsText(node.files[0]);
            }
        </script>
    
        <div id="target">You can drag an image file here</div>
        <script>
            const target = document.getElementById('target');
    
            target.addEventListener('drop', (e) => {
                e.stopPropagation();
                e.preventDefault();
    
                doSomethingWithFiles(e.dataTransfer.files);
            });
    
            target.addEventListener('dragover', (e) => {
                e.stopPropagation();
                e.preventDefault();
                e.dataTransfer.dropEffect = 'copy';
            });
    
    
            target.addEventListener('paste', (e) => {
                e.preventDefault();
                doSomethingWithFiles(e.clipboardData.files);
            });
        </script>
    pageHTML;
        
    }

    return $html;
}
