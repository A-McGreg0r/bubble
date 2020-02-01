<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
    <meta content="ie=edge" http-equiv="x-ua-compatible">
    <title>Material Design Bootstrap - WYSIWYG</title>
    <!-- Font Awesome -->
    <link href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" rel="stylesheet">
    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="../css/mdb.min.css" rel="stylesheet">
    <!-- Your custom styles (optional) -->
    <link href="../css/style.css" rel="stylesheet">

    <link href="../css/wysiwyg.css" rel="stylesheet">

    <style>
        body {
            background: #f9f9f9;
        }
    </style>
</head>

<body>

<div class="container my-5">
    <div class="col-md-8 mx-md-auto">
        <div>

        <textarea id="example">
          <h1 style="text-align: center;">MDBootstrap</h1>
          <p style="text-align: center;">WYSIWYG Editor</p>
          <p style="text-align: center;"><img class="img-fluid"
                                              src="https://mdbootstrap.com/img/Marketing/free/main/jquery/mdb-jquery-free.jpg"
                                              target="_blank"></p>
          <p style="text-align: center;"><a href="https://mdbootstrap.com" style="font-size: 1rem; text-align: left;"
                                            target="_blank">MDBootstrap.com</a>&nbsp;© 2018</p>
          <p style="text-align: left;"><b>Features:</b></p>
          <p style="text-align: left;">
              <ul>
                  <li>Changing block type</li>
                  <li>Text formatting (bold, italic, strikethrough, underline)</li>
                  <li>Setting text color</li>
                  <li>Text aligning</li>
                  <li>Inserting links</li>
                  <li>Inserting pictures</li>
                  <li>Creating a list (bulled or numbered)</li>
              </ul>
              <p><b>Options:</b></p>
              <ul>
                  <li>Translations</li>
                  <li>Using your own color palette</li>
                  <li>Disabling/enabling tooltips</li>
              </ul>
            </p>
        </textarea>

        </div>
    </div>
</div>


<!-- SCRIPTS -->
<!-- JQuery -->
<script src="../js/jquery-3.4.1.min.js" type="text/javascript"></script>
<!-- Bootstrap tooltips -->
<script src="../js/popper.min.js" type="text/javascript"></script>
<!-- Bootstrap core JavaScript -->
<script src="../js/bootstrap.min.js" type="text/javascript"></script>
<!-- MDB core JavaScript -->
<script src="../js/mdb.min.js" type="text/javascript"></script>

<script src="../js/wysiwyg.min.js" type="text/javascript"></script>

<script>
    $('#example').mdbWYSIWYG();
</script>

</body>
</html>
