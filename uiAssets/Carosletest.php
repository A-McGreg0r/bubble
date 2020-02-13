

<div class="container my-4">

    <p class="font-weight-bold">Bootstrap carousel swipte</p>

    <p><strong>Detailed documentation and more examples you can find in our <a href=""
                                                                               target="_blank">Bootstrap Carousel Docs</a> </p>

    <hr>

    <p class="font-weight-bold">Basic example</p>

    <p>The Bootstrap allows to use touch support. It is setting to <code>true</code> by default.</p>

    <p>More about gestures you can read in our <a href="https://mdbootstrap.com/docs/jquery/javascript/mobile/">mobile gestures documentation</a>.</p>

    <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="w-100 d-block" src="https://mdbootstrap.com/img/Photos/Slides/img%20(35).jpg">
            </div>
            <div class="carousel-item">
                <img class="w-100 d-block" src="https://mdbootstrap.com/img/Photos/Slides/img%20(33).jpg">
            </div>
            <div class="carousel-item">
                <img class="w-100 d-block" src="https://mdbootstrap.com/img/Photos/Slides/img%20(31).jpg">
            </div>
        </div>
    </div>

</div>


<script>

    $('.carousel').carousel({
        touch: true // default
    })

</script>
