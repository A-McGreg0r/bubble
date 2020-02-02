<?php

function generateHomeTab(){
    require "charts/lineChart_Year.php";
    require "charts/lineChart_Month.php";
    require "charts/lineChart_Day.php";
    $html = '<div class="accordion md-accordion z-depth-1-half" id="accordionEx194" role="tablist" aria-multiselectable="true">
        <hr class="mb-0">';
    $x = 1;
    //for building more than one chart
    $chartId = "chartId" . $x . "";

    while ($x <= 1) {
        //TODO fix drop dowp fucntion
        $html .= '
        <!-- Accordion card -->
            <div class="card">
            <!-- Card header -->
                <div class="card-header" role="tab" id="heading' . $x . '">
                    <a data-toggle="collapse" data-parent="#accordionEx194" href="#collapse' . $x . '" aria-expanded="true"
                    aria-controls="collapse4">
                    <h3 class="mb-0 mt-3 red-text">
                        My Home <i class="fas fa-angle-down rotate-icon fa-2x"></i>
                    </h3>
                    </a>
                </div>
            <!-- Card body -->
            <div id="collapse' . $x . '" class="collapse show" role="tabpanel" aria-labelledby="heading' . $x . '"
                data-parent="#accordionEx194">
                    <div class="card-body pt-0">
                    
                    
                    <div class="flex-sm-row justify-content-center">     
                        <!--Grid column-->
                        <!--Date select
                        <p class="lead align-content-center">
                            <span class="badge info-color-dark p-2">Date range</span>
                        </p>-->
                            <select class="browser-default custom-select">
                            <option selected>Choose time period</option>
                            <option value="1">Week</option>
                            <option value="2">Month</option>
                            <option value="3">Year</option>
                        </select>
                    </div>
                    <!--TODO intagrate database qurry -->
                    
                    <canvas id="lineChart_Month"></canvas>
                    </div>
                    
            </div>
        </div>
        <!-- Accordion card -->
        ';//echo end
        $x++;//+1 to x for steting
    }

    return $html;
}

?>
