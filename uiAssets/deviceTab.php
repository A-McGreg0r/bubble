<!-- Card deck -->
<?php
$x = 1;

while ($x <= 10) {
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
      <h4 class="card-title">Device ' . $x . '</h4>
      <!--Text-->
      <p class="card-text"></p>
      <!-- Provides extra visual weight and identifies the primary action in a set of buttons -->

      <!-- Default switch -->
        <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="deviceSwitche' . $x . '">
            <label class="custom-control-label" for="deviceSwitche' . $x . '">on/off</label>
        </div>
    </div>

  </div>
  <!-- Card -->
      ';
    $x++;
}
?>