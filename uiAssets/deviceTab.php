<!-- Card deck -->
<!-- ToDO: intagrated to data base -->
<!-- ToDO: add sql qurry  -->
<?php
$x = 1;

while ($x <= 10) {
    echo '
  <!-- Card -->
  <div class="card mb-4">

    <!--Card image-->
    <div class="view overlay">
        <div class="mask rgba-white-slight"></div>
    </div>

    <!--Card content-->
    <div class="card-body">
      <!--Title-->
      <!-- ToDO: change to get device name form database -->
      <h4 class="card-title">Device ' . $x . '</h4>
      <!-- Default switch -->
        <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="deviceSwitche' . $x . '">
            <label class="custom-control-label" for="deviceSwitche' . $x . '">on/off</label>
        </div>
      <!--Text-->
      <!-- ToDO add any contnt-->
      <p class="card-text">
      </p>
      <!-- Provides extra visual weight and identifies the primary action in a set of buttons -->
    </div>
  </div>
  <!-- Card -->
      ';
    $x++;
}
?>