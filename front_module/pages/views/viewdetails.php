<div class="bannerslider">
<?php 
foreach($slider as $s){
	echo '<div><img src="'.base_url('storage/uploads/'.$s['image']).'" alt="" class="img-fluid"></div>';	
}
?>
</div>

<div class="container position-absolute top-50 start-50 translate-middle text-white text-center">
	<?php //echo $portfolio_data['description'];?>
<h2><?php echo $portfolio_data['title']; ?></h2>
<h5 class="fw-light  hstack gap-2 justify-content-center"><?php echo $portfolio_data['subtitle']; ?></h5>
</div>

<div class="rightshadow position-relative">
	<div class="container-fluid p-0">
		<div class="row g-0 justify-content-end">
			<div class="col-xl-6"><img src="<?php echo base_url('storage/uploads/'.$portfolio_data['portfolio_image']); ?>" class="img-fluid w-100"></div>
			<div class="col-xl-6">
				<div class="bg-warning text-white homerightbox position-relative h-100">
					<?php echo $portfolio_data['portfolio_description']; ?>
					<!--<a class="btn btn-1 border-0 btn-dark btn-lg my-md-5 my-4 fw-bold" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#"><span>View AVAILABILITIES</span></a>-->
					<div class="socialbox"><a href="#"><i class="lab la-facebook-f"></i></a> <a href="#"><i class="lab la-linkedin-in"></i></a> <a href="#"><i class="lab la-instagram"></i></a> <a href="#"><i class="lab la-pinterest-p"></i></a> <a href="#"><i class="lab la-twitter"></i></a> <a href="#"><i class="lab la-youtube"></i></a></div>
			</div>
		</div>
		</div>
		</div>
</div>

<div class="container py-xl-5">
	<h3 class="text-center mb-0">Before &amp; After</h3>
	<div class="beforeslider mt-lg-5">
		<?php foreach($portfolios_before as $portfolio_before){ ?>
		<div>
			<div id="comparison" class="comparison">
				<figure>
					<div id="handle<?php echo $portfolio_before['id']; ?>" class="handle" style="left: 50%;"></div>
					<div id="divisor<?php echo $portfolio_before['id']; ?>" class="divisor border-end border-white border-4" style="width: 50%;"></div>
				</figure>
				<input type="range" min="0" max="100" value="50" id="slider<?php echo $portfolio_before['id']; ?>" class="slider" oninput="moveDivisor<?php echo $portfolio_before['id']; ?>()">
			</div>
		</div>
		<?php } ?>
		<style>
			figure {
				position: absolute;
				background-image: url(../images/<?php echo $portfolio_before['image']; ?>);
				background-size: cover;
				font-size: 0;
				width: 100%;
				height: 100%;
				margin: 0;
			}
			#handle<?php echo $portfolio_before['id']; ?> {
				position: absolute;
				height: 50px;
				width: 50px;
				top: 50%;
				left: 50%;
				transform: translateY(-50%) translateX(-50%);
				z-index: 1;
				}
			#divisor<?php echo $portfolio_before['id']; ?> {
				background-image: url(../images/<?php echo $portfolio_before['image']; ?>);
				background-size: cover;
				position: absolute;
				width: 50%;
				box-shadow: 0 5px 10px -2px rgb(0 0 0 / 30%);
				bottom: 0;
				height: 100%;
				}
		</style>
	</div>	
</div>




<?php 
if(strlen($portfolio_data['map'])){
	echo '<div  style="-webkit-filter: grayscale(100%); filter: grayscale(100%);">'.$portfolio_data['map'].'</div>';
}


		

	
		

