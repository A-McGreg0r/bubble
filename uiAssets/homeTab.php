<!--Accordion wrapper-->
<div class="accordion md-accordion z-depth-1-half" id="accordionEx194" role="tablist"
     aria-multiselectable="true">

    <hr class="mb-0">

    <?php
    $x = 1;
    //for building more than one chart
    $chartId = "chartId" . $x . "";
    while ($x <= 5) {
        echo '
        <!-- Accordion card -->
          <div class="card">
          <!-- Card header -->
                <div class="card-header" role="tab" id="heading' . $x . '">
                  <a data-toggle="collapse" data-parent="#accordionEx194" href="#collapse' . $x . '" aria-expanded="true"
                    aria-controls="collapse4">
                    <h3 class="mb-0 mt-3 red-text">
                      Home ' . $x . ' <i class="fas fa-angle-down rotate-icon fa-2x"></i>
                    </h3>
                  </a>
                </div>
          <!-- Card body -->
            <div id="collapse' . $x . '" class="collapse show" role="tabpanel" aria-labelledby="heading' . $x . '"
              data-parent="#accordionEx194">
                  <div class="card-body pt-0">
                  <h2>testcontent</h2><!-- TODO  get test grapth working before implmenting it useing a database-->
                  </div>
            </div>
        </div>
      <!-- Accordion card -->
      ';//echo end
        $x++;//+1 to x for steting
    }
    ?>
</div>
<!--/.Accordion wrapper-->