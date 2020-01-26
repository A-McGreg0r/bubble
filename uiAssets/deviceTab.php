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
    <div class="card-body d-flex flex-wrap-reverse mb-4 mt-xl-5">

      <!--Title-->
      
        <div class="col-md">
            <h4 class="card-title">
                Devive ' . $y . '
            </h4>
        </div>
        
        <div class="col-md">
        
             <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="roomSwitche' . $y . '">
            <label class="custom-control-label" for="roomSwitche' . $y . '">on/off</label>
            </div>  
              
        </div>
      
      <!--Text-->
      <p class="card-text"></p>
      <!-- Default switch -->

    </div>

  </div>
  <!-- Card -->
      ';
    $y++;
}
?>