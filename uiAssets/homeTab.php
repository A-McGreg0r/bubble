<!--Accordion wrapper-->
<div class="accordion md-accordion z-depth-1-half" id="accordionEx194" role="tablist"
     aria-multiselectable="true">

    <hr class="mb-0">

    <!-- Accordion card -->
    <div class="card">
        <!-- Card header -->
        <div class="card-header" role="tab" id="heading">
            <a data-toggle="collapse" data-parent="#accordionEx194" href="#collapse" aria-expanded="true"
               aria-controls="collapse4">
                <h3 class="mb-0 mt-3 red-text">
                    Home ' . $x . ' <i class="fas fa-angle-down rotate-icon fa-2x"></i>
                </h3>
            </a>
        </div>
        <!-- Card body -->
        <div id="collapse" class="collapse show" role="tabpanel" aria-labelledby="heading"
             data-parent="#accordionEx194">
            <div class="card-body pt-0">
                <!-- TODO  get test grapth working before implmenting it useing a database-->
                <?php
                require "../testLineChart_Year.php"
                ?>

            </div>
        </div>

        //TODO FIND OUT WHAT ELCE SHOULD BE IMPLMENTED
        //TODO implment lineChart.php after completing it

    </div>
    <!--/.Accordion wrapper-->

</div>
<!-- Accordion card -->