
<div class="hero-video inner-banner inner-bg1 py-5" id="hero-video">
  <div class="container position-relative mt-5"> <svg height="" width="400" class="wow animate__animated animate__zoomIn" xmlns="http://www.w3.org/2000/svg">
    <rect class="shape" height="100%" width="100%" />
    </svg>
    <div class="caption ps-5 py-5 wow animate__animated animate__fadeIn" data-wow-delay="1s">
      <h2 class="text-white d-inline-block"><?php echo $banner['header_text']; ?></h2>
      <div class="type-wrap d-inline-block h1"> <span id="typed" style="white-space:pre;" class="typed gradianttext"> </span> </div>
      <p class="text-white mt-2"><?php echo $banner['description_text']; ?></p>
      <span class="arrow tail"> <a href="javascript:void(0)" class="arrows" alt="arrows"><img src="<?php echo base_url('storage/uploads/images/arrow.svg'); ?>" class="img-fluid" alt=""/></a> </span> </div>
  </div>
</div>



<div class="container-fluid py-3">
  <div class="row row-cols-2 row-cols-md-4 g-3 gallery-sec">
  <?php 
  //
  foreach($images as $i){
    //[id] => 58 [title] => DollarRez [image] => images/dollarrez.jpg 
    //[link] => http://www.dollarrez.com/ [checkbox] => 0 [sort_order] => 0 ) 
    echo '<div class="col">
      <div class="gallery"><a href="'.$i->link.'" target="_blank"><img src="'.base_url('storage/uploads/'.$i->image).'" alt=""  /><span><i class="las la-mouse-pointer la-2x"></i>'.$i->title.'</span></a></div>
    </div>';
  }
  ?>
  </div>
  <div id="pagination-container"></div>
</div>