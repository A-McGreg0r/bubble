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
    <script>//TODO get swipe navatation working between tabs currently not working
        $(".tab").swipe({
            swipeLeft: function (event, direction, distance, duration, fingerCount) {
                $(".nav-tabs li.active").next('li').find('a').tab('show');
            },
            swipeRight: function (event, direction, distance, duration, fingerCount) {
                $(".nav-tabs li.active").prev('li').find('a').tab('show');
            },
        });

    </script>