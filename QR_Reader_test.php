<!-- TODO spelling and gramer check -->
<!-- TODO remove header as elaments html tag and doc type as required after completion -->
<!-- TODO implment with mobile phone cammra -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <!--icon Change me-->
    <link rel="icon" href="img/mdb-favicon.ico" type="image/x-icon">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <!--Scripts-->
    <!-- JQuery -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.10.1/js/mdb.min.js"></script>
    <!--Scripts-->
    <script src="https://rawgit.com/sitepoint-editors/jsqrcode/master/src/qr_packed.js">
    </script>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css"/>
    <!-- Material Design Bootstrap -->
    <link rel="stylesheet" href="css/mdb.min.css" type="text/css"/>
    <!-- Your custom styles (optional) -->
    <link rel="stylesheet" href="css/style.css" type="text/css"/>
    <title>testing</title>
</head>
<input type=text size=16 placeholder="Tracking Code" class=qrcode-text><label class=qrcode-text-btn><input type=file
                                                                                                           accept="image/*"
                                                                                                           capture=environment
                                                                                                           onchange="openQRCamera(this);"
                                                                                                           tabindex=-1></label>
<input type=button value="Go" disabled>
<?php
?>


<script type="text/javascript">
    function openQRCamera(node) {
        var reader = new FileReader();
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
        reader.readAsDataURL(node.files[0]);
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