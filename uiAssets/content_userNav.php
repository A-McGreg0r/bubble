<?php

function generateUserNav(){
    $html = <<<htmlPage
        <!--navbar-->
        <nav class="navbar  navbar-expand-lg navbar-dark elegant-color-dark">
            <!-- Collapse button -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
                <img src="img/3BubblesBlue.png"></img>
            </button>
            <span class="nav-item">
                Bubble Icon
            </span>
            <!-- Collapsible content -->
            <div class="collapse navbar-collapse " id="navbarToggler">
                <!-- Links -->
                <ul class="navbar-nav mr-auto mt-lg-0">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Home<span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=account">Account</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto nav-flex-icons">

                </ul>
                <ul class="navbar-nav ml-auto nav-flex-icons">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=logout">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
htmlPage;
    return $html;
}

?>

