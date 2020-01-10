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

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css"/>
    <!-- Material Design Bootstrap -->
    <link rel="stylesheet" href="css/mdb.min.css" type="text/css"/>
    <!-- Your custom styles (optional) -->
    <link rel="stylesheet" href="css/style.css" type="text/css"/>
</head>

<body class="black-skin">


<!--navbar-->
<nav class="navbar  navbar-expand-lg navbar-dark elegant-color-dark">
    <!-- Collapse button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler"
            aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Collapsible content -->
    <div class="collapse navbar-collapse " id="navbarToggler">
        <!-- Links -->
        <a class="navbar-brand" href="index.php"><i class="fas fa-comment"></i></a>
        <ul class="navbar-nav mr-auto mt-lg-0">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Account</a>
            </li>


        </ul>
        <ul class="navbar-nav ml-auto nav-flex-icons">
            <li class="nav-item">
                <?php
                //do if to togall between login and logout
                require 'loginModal.php';
                ?>
            </li>


        </ul>
    </div>
</nav>
<!--sub nav-->

<!-- Nav tabs -->
<ul class="nav nav-tabs md-tabs nav-justified  elegant-color sticky-top" id="myTabAttr" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="home-tab-attr" data-toggle="tab" href="#home-attr" role="tab"
           aria-controls="home-attr"
           aria-selected="true">Home</a>
    </li>
    <li class="nav-item">
        <a class="nav-link " id="profile-tab-attr" data-toggle="tab" href="#profile-attr" role="tab"
           aria-controls="profile-attr"
           aria-selected="false">Room</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="messages-tab-attr" data-toggle="tab" href="#messages-attr" role="tab"
           aria-controls="messages-attr"
           aria-selected="false">Device</a>
    </li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <div class="tab-pane active" id="home-attr" role="tabpanel" aria-labelledby="home-tab-attr">
        <?php
        require 'homeTab.php';
        ?>
    </div>
    <div class="tab-pane" id="profile-attr" role="tabpanel" aria-labelledby="profile-tab-attr">
        <?php
        require 'roomsTab.php';
        ?>
    </div>

    <div class="tab-pane" id="messages-attr" role="tabpanel" aria-labelledby="messages-tab-attr">
        <?php
        require 'deviceTab.php';
        ?>

    </div>


    <!--sub nav-->


    <!--navbar-->
</body>
<script>
    $('.nav').carousel({
        touch: true // default
    })
</script>