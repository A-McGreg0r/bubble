<?php
function generateTabs(){
    require 'content_tab_homes.php';
    require 'content_tab_rooms.php';
    require 'content_tab_devices.php';

    $html = '

    <!-- Nav tabs -->
    <ul class="nav nav-tabs md-tabs nav-justified text-white  elegant-color sticky-top" id="myTabAttr" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="home-tab-attr" data-toggle="tab" href="#home-attr" role="tab"
               aria-controls="home-attr"
               aria-selected="true">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " id="profile-tab-attr" data-toggle="tab" href="#profile-attr" role="tab"
               aria-controls="profile-attr"
               aria-selected="false">Rooms</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="messages-tab-attr" data-toggle="tab" href="#messages-attr" role="tab"
               aria-controls="messages-attr"
               aria-selected="false">Devices</a>
        </li>
    </ul>
    
    
    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane active" id="home-attr" role="tabpanel" aria-labelledby="home-tab-attr">
            '.generateHomeTab().'
        </div>
        <div class="tab-pane" id="profile-attr" role="tabpanel" aria-labelledby="profile-tab-attr">
            '.generateRoomTab().'
        </div>
    
        <div class="tab-pane" id="messages-attr" role="tabpanel" aria-labelledby="messages-tab-attr">
            '.generateDeviceTab().'
        </div>
    
    
        <script>//TODO get swipe navatation working between tabs currently not working
            $(".tab").swipe({
                swipeLeft: function (event, direction, distance, duration, fingerCount) {
                    $(".nav-tabs li.active").next(\'li\').find(\'a\').tab(\'show\');
                },
                swipeRight: function (event, direction, distance, duration, fingerCount) {
                    $(".nav-tabs li.active").prev(\'li\').find(\'a\').tab(\'show\');
                },
            });
        </script>';
    return $html;
}
