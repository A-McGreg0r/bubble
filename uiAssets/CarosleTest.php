<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!--icon Change me-->
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <!--Scripts-->
    <!-- Javascript -->
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

    <!--Bubble Custom Scripts-->
    <script type="text/javascript" src="js/bubble.js"></script>
    <script type="text/javascript" src="js/app.js"></script>
    <link rel="manifest" href="manifest.json"/>
    <!--Scripts-->

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css"/>
    <!-- Material Design Bootstrap -->
    <link rel="stylesheet" href="css/mdb.min.css" type="text/css"/>
    <!-- Your custom styles (optional) -->
    <link rel="stylesheet" href="css/style.css" type="text/css"/>
    <title>Bubble App</title>
</head>
<div class="container my-4">

    <p class="font-weight-bold">Bootstrap carousel swipte</p>

    <p><strong>Detailed documentation and more examples you can find in our <a href=""
                                                                               target="_blank">Bootstrap Carousel
                Docs</a></p>

    <hr>

    <p class="font-weight-bold">Basic example</p>

    <p>The Bootstrap allows to use touch support. It is setting to <code>true</code> by default.</p>

    <p>More about gestures you can read in our <a href="https://mdbootstrap.com/docs/jquery/javascript/mobile/">mobile gestures documentation</a>.</p>

    <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="w-100 d-block" src="https://mdbootstrap.com/img/Photos/Slides/img%20(35).jpg">
            </div>
            <div class="carousel-item">
                <img class="w-100 d-block" src="https://mdbootstrap.com/img/Photos/Slides/img%20(33).jpg">
            </div>
            <div class="carousel-item">
                <img class="w-100 d-block" src="https://mdbootstrap.com/img/Photos/Slides/img%20(31).jpg">
            </div>
        </div>
    </div>

</div>


<script>

    $('.carousel').carousel({
        touch: true // default
    })

</script>
