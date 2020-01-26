<!-- Card deck -->
<?php
$y = 1;
//TODO FIND OUT WHAT ELCE SHOULD BE IMPLMENTED
while ($y <= 10) {
    echo '
  <!-- Card -->
  <div class="card mb-4 container">
    <!--Card image-->
    <div class="view overlay">
        <div class="mask rgba-white-slight"></div>
    </div>

    <!--Card content-->
    <div class="card-body d-flex justify-content-between">

      <!--Title-->      
            <div class="d-flex flex-column">  
                    Room ' . $y . '
            </div>
           
            <div class="d-flex flex-column">
           <!-- Default switch -->
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="roomSwitche' . $y . '">
                    <label class="custom-control-label" for="roomSwitche' . $y . '">on/off</label>
                </div>  
            </div>
    </div>

  </div>
  <!-- Card -->
      ';
    $y++;
}
?>