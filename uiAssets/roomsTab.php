<!-- Card deck -->
<?php
$y = 1;
//TODO FIND OUT WHAT ELCE SHOULD BE IMPLMENTED
while ($y <= 10) {
    echo '
  <!-- Card -->
  <div class="card mb-4">

    <!--Card image-->
    <div class="view overlay">

        <div class="mask rgba-white-slight"></div>
      </a>
    </div>

    <!--Card content-->
    <div class="card-body">

      <!--Title-->
      <h4 class="card-title">Room ' . $y . '</h4>
      <!--Text-->
      <p class="card-text"></p>
      <!-- Provides extra visual weight and identifies the primary action in a set of buttons -->

      <!-- Default switch -->
        <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="roomSwitche' . $y . '">
            <label class="custom-control-label" for="roomSwitche' . $y . '">on/off</label>
        </div>
    </div>

  </div>
  <!-- Card -->
      ';
    $y++;
}
?>