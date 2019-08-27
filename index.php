<?php require_once 'includes/core.inc.php';?>


<?php require_once 'includes/header.inc.php';?>

<div class = "container-fluid">
	<div class = "row">
	<div id="myCarousel" class="carousel slide" data-ride="carousel">

    <!-- Carousel indicators -->

    <ol class="carousel-indicators">

        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>

        <li data-target="#myCarousel" data-slide-to="1"></li>

        <li data-target="#myCarousel" data-slide-to="2"></li>
		<li data-target="#myCarousel" data-slide-to="3"></li>
		<li data-target="#myCarousel" data-slide-to="4"></li>

    </ol>   

    <!-- Carousel items -->

    <div class="carousel-inner"style="margin:auto;height:500px">

        <div class="item active">

           <img src="images/dan.jpg"style="height:500px;width:1300px">

            <div class="carousel-caption">
			<h2>ELEARNING;Enroll for a Course NOW! </h2>
			<P>Find the Degree;Diploma;Certificate to Help You Get The Career You Want. Apply Now!</P>

             

            </div>

        </div>

        <div class="item">
            <img src="images/dan1.jpg"style="height:500px;width:1300px"">

            <div class="carousel-caption">

              

            </div>

        </div>

        <div class="item">

           <img src="images/imagez.jpg"style="height:500px;width:1300px"">

            <div class="carousel-caption">
			<h2>LEARNING ONLINE</h2>
			<P>Get connected to the Outside World;Once inside of Elearning, learn more by accessing the tutorial course.</P>

             
                </div>
            </div>
			<div class="item">

           <img src="images/elearning.jpg"style="height:500px;width:1300px"">

            <div class="carousel-caption">

             

            </div>

        </div>

    </div>

    <!-- Carousel nav -->

    <a class="carousel-control left" href="#myCarousel" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>

  </a>

    <a class="carousel-control right" href="#myCarousel" data-slide="next">

        <span class="glyphicon glyphicon-chevron-right"></span>

   </a>

</div>
	
</div>

<?php require_once 'includes/default_footer.inc.php';?>