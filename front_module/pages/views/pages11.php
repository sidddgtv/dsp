<?php  if($page_id != 88 && $page_id != 92 ) { ?>
	<div class="innerbanner position-relative text-center">
		<img src="<?php echo 'storage/uploads/'.$image;?>" alt="" class="img-fluid w-100">
  		<div class="container position-absolute top-50 start-50 translate-middle" style="z-index:9;">
   			 <!--<?php echo $banner_description; ?>-->
  		</div>
	</div>
 <? } ?>
<?php echo $section_data; ?>

<?php if($page_id == 82) { ?>
<img src="storage/uploads/images/bird2.png" alt="" class="img-fluid position-absolute d-md-inline-block d-none pe-4 pt-4 end-0">

<div class="container mt-5">
    <div class="row d-flex justify-content-center align-items-center">
        <div class="col-md-6" id="family_form_1">
        	<h1 id="register">Family Application</h1>
            <form id="regForm" method="POST" class="border border-2 p-md-5 p-4 mt-4 labelfrom">
                
                <div class="all-steps d-none" id="all-steps"> 
                	<span class="step"></span> 
                	<span class="step"></span> 
                	<span class="step"></span> 
                	<span class="step"></span> 
                	<span class="step"></span> 
                	<span class="step"></span> 
                	<span class="step"></span> 
                	<span class="step"></span> 
                	<span class="step"></span> 
                	<span class="step"></span> 
                	<span class="step"></span> 
                	<span class="step"></span> 
                	<span class="step"></span> 
                	<span class="step"></span> 
                	<span class="step"></span> 
                	<span class="step"></span> 
                	<span class="step"></span> 
                	<span class="step"></span> 
                	<span class="step"></span> 
                	<span class="step"></span> 
                	<span class="step"></span> 
                	<span class="step"></span> 
                </div>
                <!--<div class="tab">
                    <h3>Make sure you have 5 or so minutes before you begin</h3>
                    <button type="button" id="nextBtn" class="startbtn" onclick="nextPrev(1)">Next</button> 
                </div>-->
                <div class="tab text-center">
			        <i class="las la-clock la-2x"></i>
			        <p>Make sure you have 5 or so minutes before you begin</p>
				</div>
				<div class="tab">
                    <p>
                    	<label>First Name</label>
                    	<input type="text" id="fname" name="fname" class="form-control" placeholder="First Name" oninput="this.className = ''" >
                    </p>
                </div>
                <div class="tab">
                    <p>
                    	<label>Last Name</label>
                    	<input placeholder="Last Name" oninput="this.className = ''" id="lname" name="lname" class="form-control">
                    </p>
                </div>
                <div class="tab">
                    <p>
                    	<label>Email</label>
                    	<input placeholder="Email" oninput="this.className = ''" name="email" class="form-control">
                    </p>
                </div>
                <div class="tab">
                    <p>
                    	<label>Cell number</label>
                    	<input placeholder="Phone" oninput="this.className = ''" name="cellnumber" class="form-control">
                    </p>
                </div>
                <div class="tab">
                    <p>
                    	<label>Where are you currently located?</label>
                    	<input placeholder="Location" oninput="this.className = ''" name="location" class="form-control">
                    </p>
                </div>
                <div class="tab">
                    <p>
                    	<label>Address</label>
                    	<input placeholder="Address" oninput="this.className = ''" name="address" class="form-control">
                    </p>
                </div>
                <div class="tab">
                    <p>
                    	<label>Neighborhood</label>
                    	<input placeholder="neighborhood" oninput="this.className = ''" name="neighborhood" class="form-control">
                    </p>
                </div>
                <div class="tab">
                    <p>
                    	<label>Zip code</label>
                    	<input placeholder="zipcode" oninput="this.className = ''" name="zipcode" class="form-control">
                    </p>
                </div>
                <div class="tab">
                    <p>
                    	<label>If you are moving, please tell us where you plan to settle!</label>
                    	<input oninput="this.className = ''" name="settle" class="form-control">
                    </p>
                </div>
                <div class="tab">      
					<p>
						<label>Which option best describes what you're looking for?</label></p>

						
						 <select oninput="this.className = ''" name="best" class="form-control">
						    <option value="Nanny">Nanny</option>
						    <option value="Newborn care specialist">Newborn care specialist</option>
						    <option value="Sitter">Sitter</option>
						</select>
						
					</p>
                </div>
				<div class="tab">      
					<p>
						<label>Nanny What type of schedule are you searching for?</label></p>
						<select oninput="this.className = ''" name="schedule" class="form-control">
						    <option value="Full-Time (40+ Hours Per Week)">Full-Time (40+ Hours Per Week)</option>
						    <option value="Part-Time (20-40 Hours Per Week)">Part-Time (20-40 Hours Per Week)</option>
						</select>
                </div>
                <div class="tab">      
					<p>
						<label>Preferred start date?</label>
						<input type="date" oninput="this.className = ''" name="preferred" class="form-control">
					</p>
                </div>
                <div class="tab">      
					<p>
						<label>Number of children?</label>
						<input oninput="this.className = ''" name="children" class="form-control">
					</p>
                </div>
                <div class="tab">      
					<p>
						<label>Special Needs- allergies, medical, behavioral?</label>
						<input oninput="this.className = ''" name="allergies" class="form-control">
					</p>
                </div>
                <div class="tab">      
					<p>
						<label>Have you previously employed a nanny?</label>
						<label class="container form-check form-check-inline">Yes
                            <input type="radio" name="employed" value="yes">
                            <span class="checkmark"></span>
                    </label>
                    <label class="container form-check form-check-inline">No
                            <input type="radio" name="employed" value="no">
                            <span class="checkmark"></span>
                    </label>
					</p>
     
				<div class="experience_sec">
					<p>
						<label>If yes- what did you like most about the experience/nanny? Least or most challenging??</label>
						<input oninput="this.className = ''" name="experience" class="form-control">
					</p>
				</div>
			</div>
				<div class="tab">
					<p>
						<label>Preferred start date?</label>
						<input type="date" oninput="this.className = ''" name="preferred1" class="form-control">
					</p>
				</div>
				<div class="tab">
					<p>
						<label>What is your child/children's normal routine?</label>
						<input oninput="this.className = ''" name="routine" class="form-control">
					</p>
				</div>
				<div class="tab">
					<p>
						<label>How do you like to spend time with your child?</label>
						<input oninput="this.className = ''" name="spend" class="form-control">
					</p>
				</div>
				<div class="tab">
					<p>
						<label>What's your method of authority/discipline like with your child?</label>
						<input oninput="this.className = ''" name="authority" class="form-control">
					</p>
				</div>
				<div class="tab">
					<p>
						<label>Is there anything else that you would like to tell us about your children, family, or the position?</label>
						<input oninput="this.className = ''" name="position" class="form-control">
					</p>
				</div>
				<div class="tab">      
					<p>
						<label>Current rates range from $30-$40+/hr. Is that a rate range you’re comfortable with?</label>
						<label class="container form-check form-check-inline">Yes
                            <input type="radio" name="comfortable" value="yes">
                            <span class="checkmark"></span>
                    </label>
                    <label class="container form-check form-check-inline">No
                            <input type="radio" name="comfortable" value="no">
                            <span class="checkmark"></span>
                    </label>
					</p>
                </div>
                <div class="thanks-message text-center" id="text-message"> <img src="https://i.imgur.com/O18mJ1K.png" width="100" class="mb-4">
                    <h3>Thanks for your Donation!</h3> <span>Your donation has been entered! We will contact you shortly!</span>
                </div>
                <!--<div style="overflow:auto;" id="nextprevious">
                    <div style="float:right;"> 
                    	<button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button> <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button> 
                    </div>
                </div>-->
                <div  id="nextprevious">
			        <div class="d-flex justify-content-between mt-4"> 
			            <button type="button" class="btn btn-secondary btn-sm" id="prevBtn" onclick="nextPrev(-1)"><i class="las la-long-arrow-alt-left"></i>Previous</button>
			            <button type="button" class="btn btn-warning btn-sm" id="nextBtn" onclick="nextPrev(1)">Next<i class="las la-long-arrow-alt-right"></i></button> 
			        </div>
			    </div>
            </form>
        </div>
    </div>
</div>
<? } ?>

<?php if($page_id == 83) { ?>
<img alt="" class="img-fluid position-absolute d-md-inline-block d-none ps-4 pt-4" src="storage/uploads/images/bird.png" />
<div class="container py-md-5 py-4 my-md-5">
	<div class="row g-5">
		<div class="col-md-8">
			<h2 class="fw-bold mb-4">Favorite Baby Products</h2>
				<div class="row row-cols-md-4 row-cols-sm-3 row-cols-2 g-4">
					<?php foreach($buildings as $building){ ?>
						<div class="col">
							<div class="border">
								<a href="<?php echo $building['description'];?>" target="_blank">
								<img alt="" class="img-fluid w-100" src="<?php echo 'storage/uploads/'.$building['image'];?>" /></a>
							</div>
						</div>
					<?php } ?>
				</div>
				<h2 class="fw-bold my-5">Favorite Articles</h2>
				<ul class="list list-arrow">
					<li><a href="https://www.pregnancybirthbaby.org.au/newborn-baby-essentials" target="_blank" style="color:#a27564"><h3><u>Newborn baby essentials</u></h3></a></li>
					<li><a href="https://www.pregnancybirthbaby.org.au/your-childs-health" target="_blank" style="color:#a27564"><h3><u>Your child&#39;s health</u></h3></a></li>
					<li><a href="https://www.pregnancybirthbaby.org.au/baby-feeding" target="_blank" style="color:#a27564"><h3><u>Feeding your baby</u></h3></a></li>
					<li><a href="https://www.pregnancybirthbaby.org.au/language-and-speech" target="_blank" style="color:#a27564"><h3><u>Language and speech development</u></h3></a></li>
					<li><a href="https://www.pregnancybirthbaby.org.au/childrens-milestones" target="_blank" style="color:#a27564"><h3><u>Children&#39;s milestones</u></h3></a></li>
				</ul>
		</div>
		<div class="col-md-4">
			<!--<h3 class="fw-bold mt-4">Our Focus</h3>
			<p>Truly Priceless Nanny’s mission is to align a family’s caregiver needs with a nanny’s employment desires. Our priority is to facilitate a seamless process for the family and the nanny. We value both parties and know success happens when all needs are heard and matched.</p>
			<hr class="my-4" />--><img alt="" class="img-fluid w-100" src="storage/uploads/images/baby-product5.jpg" />
			<!--<h3 class="mt-4">We have built a team of highly trained, experienced nanny’s. After our extensive background checks, interview process, getting to know the nanny from references and past families, we confidently find you the very best care.</h3>-->
		</div>
	</div>
</div>
<? } ?>

<?php if($page_id == 88) { ?>
<div class="container py-md-5 p-4 my-md-5">
	<img alt="" class="img-fluid position-absolute d-md-inline-block d-none ps-4 pt-4" src="storage/uploads/images/bird.png" />
	<h2 class="text-center mb-5">Available Jobs</h2>
	<div class="container py-md-5 py-4 my-md-5">
		<div class="row">
			<div class="col-md-9 mx-auto">
				<div class="row align-items-center justify-content-center">
					<?php foreach($jobs as $job){ ?>	
						<div class="col pe-md-5">
							<h2 class="fw-bold mb-4"><?php echo $job['jobname'];?></h2>
							<p><?php echo $job['jobarea'];?></p>
							<p class="lead">$<?php echo $job['jobpay'];?></p>
							<?php echo $job['jobdescription'];?>
						</div>
						<div class="col-auto">
							<a class="btn btn-warning" href="<?php echo base_Url('pages/index/92/'.$job['id']);?>">Apply Now</a>
						</div>
						<div class="col-12">
							<hr />
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>
<? } ?>

<?php if($page_id == 77) { ?>
<div class="container py-lg-5 py-4 my-lg-5">
	<div class="row">
		<div class="col-lg-8 col-12 mx-auto">
			<div class="p-md-5 p-4 shadow bg-white rounded-5 position-relative">
				<h5>Please get in touch and our expert support team will answer all your Questions.</h5>
					<form name="contactform" id="contactform" action="" method="post" class="mt-4 position-relative">
						<div class="row g-3">
							<div class="col-lg-4">
								<input type="text" name="name" class="form-control" placeholder="Name">
							</div>
							<div class="col-lg-4">
								<input type="text" name="email" class="form-control" placeholder="Email">
							</div>
							<div class="col-lg-4">
								<input type="text" name="phone" class="form-control" placeholder="Phone">
							</div>
							<div class="col-12">
								<textarea name="comment" class="form-control" rows="3" placeholder="Message"></textarea>
							</div>
							<div class="col-12 text-left mt-0">
								<button type="submit" name="button" id="button" value="" class="btn btn-warning mt-4"><span>Submit</span></button>
								<input type="hidden" name="script_type"  value="contactform"/>
								<span id="contactform_error" class="error"></span>
								<span id="contactform_success" class="error"></span>
							</div>
						</div>
					</form>
			</div>
			<div class="row text-center locationbox mt-lg-5 mt-2 g-4">
				<div class="col-md col-12">
					<div class="bg-light rounded-4 p-4">
						<a href="tel:1234567890"><i class="las la-phone"></i> 123-456-7890</a>
					</div>
				</div>
				<div class="col-md col-12">
					<div class="bg-light rounded-4 p-4">
						<a href="mailto:trulypricelessnannies@gmail.com"><i class="las la-envelope"></i> trulypricelessnannies@gmail.com</a>
					</div>
				</div>
				<div class="col-md col-12">
					<div class="bg-light rounded-4 p-4">
						<i class="las la-map-marker"></i>Address Here
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d423283.44332460477!2d-118.69260155863145!3d34.020728938896085!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80c2c75ddc27da13%3A0xe22fdf6f254608f4!2sLos%20Angeles%2C%20CA%2C%20USA!5e0!3m2!1sen!2sin!4v1673418364500!5m2!1sen!2sin" width="100%" height="650" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
<? } ?>

<?php if($page_id == 92) { ?>
<div class="container py-md-5 p-4">
<?php 
	$jid = $this->uri->segment(4);
	$singlejob = $this->pages_model->getSingleJob($jid);
?>
<h2 class="fw-bold mb-2 text-center"><?php echo $singlejob['jobname']; ?></h2>
<p class="text-center"><strong><?php echo $singlejob['jobarea']; ?></strong></p>
<h3 class="text-center">Nanny questionnaire</h3>
	<div class="row align-items-center">
		<div class="col-md-8 col-12 mx-auto">
			<!--<h2 class="text-center mb-5">Nanny questionnaire</h2>-->
			<form name="jobform" id="jobform" action="" method="post" class="border border-2 p-md-5 p-4 mt-4 labelfrom">
				<?php echo '<input type="hidden" id="job_id" name="job_id" value="'.$this->uri->segment(4).'" />'; ?>

           					<div class="all-steps d-none" id="all-steps"> 
			                	<span class="step"></span> 
			                	<span class="step"></span> 
			                	<span class="step"></span> 
			                	<span class="step"></span> 
			                	<span class="step"></span> 
			                	<span class="step"></span> 
			                	<span class="step"></span> 
			                	<span class="step"></span> 
			                	<span class="step"></span> 
			                	<span class="step"></span> 
			                	<span class="step"></span> 
			                	<span class="step"></span> 
			                	<span class="step"></span> 
			                	<span class="step"></span> 
			                	<span class="step"></span> 
			                	<span class="step"></span> 
			                	<span class="step"></span> 
			                	<span class="step"></span> 
			                	<span class="step"></span> 
			                	<span class="step"></span> 
			                	<span class="step"></span> 
			                	<span class="step"></span> 
			                	<span class="step"></span>
			                	<span class="step"></span>
			                	<span class="step"></span>
			                	<span class="step"></span>
			                	<span class="step"></span>
			                	<span class="step"></span>
			                	<span class="step"></span>
			                	<span class="step"></span>
			                	<span class="step"></span>
			                	<span class="step"></span>
			                	<span class="step"></span>
                			</div>
			                <div class="tab text-center">
			                	<i class="las la-clock la-2x"></i>
			                    <p>Make sure you have 5 or so minutes before you begin</p>
			                    <button type="button" id="nextBtn" class="startbtn d-none" onclick="nextPrev(1)">Next</button> 
			                </div>
							<div class="tab">
			                    <p>
			                    	<label>Name</label>
			                    	<input type="text" name="name" class="form-control" placeholder="Name" oninput="this.className = ''" >
			                    </p>
			                </div>
			                <div class="tab">
			                    <p>
			                    	<label>Last Name</label>
			                    	<input placeholder="Last Name" oninput="this.className = ''" name="lname" class="form-control">
			                    </p>
			                </div>
			                <div class="tab">
			                    <p>
			                    	<label>Preferred Pronouns</label>
			                    	<input placeholder="Preferred Pronouns" oninput="this.className = ''" name="preferred" class="form-control">
			                    </p>
			                </div>
			                <div class="tab">
			                    <p>
			                    	<label>Email</label>
			                    	<input placeholder="Email" oninput="this.className = ''" name="email" class="form-control">
			                    </p>
			                </div>
			                <div class="tab">
			                    <p>
			                    	<label>Cell phone</label>
			                    	<input placeholder="Cell phone" oninput="this.className = ''" name="cellphone" class="form-control">
			                    </p>
			                </div>
			                <div class="tab">      
								<p>
									<label>Are you authorized to work in the US?</label>
									<label class="container form-check form-check-inline">Yes
			                            <input type="radio" name="authorized" value="yes">
			                            <span class="checkmark"></span>
			                    </label>
			                    <label class="container form-check form-check-inline">No
			                            <input type="radio" name="authorized" value="no">
			                            <span class="checkmark"></span>
			                    </label>

								</p>
			                </div>
			                <div class="tab">
			                    <p>
			                    	<label>How many professional years of nanny experience do you have?</label>
			                    	<input placeholder=" " oninput="this.className = ''" name="professional" class="form-control">
			                    </p>
			                </div>
			                <div class="tab">
			                <p>
			                	<label>Please tell us what area you are located in</label>
			                </p>
			                        <select name="area" class="form-control">
									    <option value="San Francisco">San Francisco</option>
									    <option value="Los Angeles">Los Angeles</option>
									    <option value="Santa Barbara">Santa Barbara</option>
									    <option value="New York">New York</option>
									</select>
							</div>
			                <div class="tab">
			                    <p>
			                    	<label>Current address</label>
			                    	<input oninput="this.className = ''" name="current_address" class="form-control">
			                    </p>
			                </div>
			                <div class="tab">
			                    <p>
									<label>Do you have a valid driver's license?</label>
									<label class="container form-check form-check-inline">Yes
			                            <input type="radio" name="license" value="yes">
			                            <span class="checkmark"></span>
			                    </label>
			                    <label class="container form-check form-check-inline">No
			                            <input type="radio" name="license" value="no">
			                            <span class="checkmark"></span>
			                    </label>
								</p>
			                </div>
			                <div class="tab">
			                    <p>
									<label>Do you have a reliable and insured vehicle?</label>
									<label class="container form-check form-check-inline">Yes
			                            <input type="radio" name="vehicle" value="yes">
			                            <span class="checkmark"></span>
			                    </label>
			                    <label class="container form-check form-check-inline">No
			                            <input type="radio" name="vehicle" value="no">
			                            <span class="checkmark"></span>
			                    </label>
								</p>
			                </div>
			                <div class="tab">      
								<p>
									<label>What makes you interested in working with children?</label>
									<input oninput="this.className = ''" name="interested" class="form-control">
								</p>
			                </div>
			                <div class="tab">      
								<p>
									<label>Please tell us more- we want to get to know you! What makes you stand out? What have your past families loved about you, or the things that set you aside as a caregiver?</label>
									<input oninput="this.className = ''" name="caregiver" class="form-control">
								</p>
			                </div>
			                <div class="tab">      
								<p>
									<label>What do you find most challenging or difficult about being a caregiver?</label>
									<input oninput="this.className = ''" name="challenge" class="form-control">
								</p>
			                </div>
			                <div class="tab">      
								<p>
									<label>Highest form of education</label>
									<input oninput="this.className = ''" name="education" class="form-control">
								</p>
			                </div>
			                 <div class="tab">      
								<p>
									 <label>What is your first language? Do you speak any other languages?</label>
									<input oninput="this.className = ''" name="language" class="form-control">
								</p>
			                </div>
							<div class="tab">      
								<p>
									<label>Looking for</label>
									<label class="container form-check form-check-inline">live in
			                            <input type="radio" name="looking" value="live in">
			                            <span class="checkmark"></span>
			                    </label>
			                    <label class="container form-check form-check-inline">live out
			                            <input type="radio" name="looking" value="live out">
			                            <span class="checkmark"></span>
			                    </label>
			                    <label class="container form-check form-check-inline">either
			                            <input type="radio" name="looking" value="either">
			                            <span class="checkmark"></span>
			                    </label>
								</p>
			                </div>
							<div class="tab">      
								<p>
									<label>Can you commit to one year?</label>
									<label class="container form-check form-check-inline">Yes
			                            <input type="radio" name="commit" value="yes">
			                            <span class="checkmark"></span>
			                    </label>
			                    <label class="container form-check form-check-inline">No
			                            <input type="radio" name="commit" value="no">
			                            <span class="checkmark"></span>
			                    </label>
								</p>
			                </div>
			                <div class="tab">      
								<p>
									<label>Open to relocate for a new job?</label>
									<label class="container form-check form-check-inline">Yes
			                            <input type="radio" name="relocate" value="yes">
			                            <span class="checkmark"></span>
			                    </label>
			                    <label class="container form-check form-check-inline">No
			                            <input type="radio" name="relocate" value="no">
			                            <span class="checkmark"></span>
			                    </label>
								</p>
			                </div>
			                <div class="tab">      
								<p>
									<label>Experience with twins, triplets?</label>
									<label class="container form-check form-check-inline">Yes
			                            <input type="radio" name="twins" value="yes">
			                            <span class="checkmark"></span>
			                    </label>
			                    <label class="container form-check form-check-inline">No
			                            <input type="radio" name="twins" value="no">
			                            <span class="checkmark"></span>
			                    </label>
								</p>
			                </div>
			                <div class="tab">      
								<p>
									<label>Special needs experience?</label>
									<label class="container form-check form-check-inline">Yes
			                            <input type="radio" name="experience" value="yes">
			                            <span class="checkmark"></span>
			                    </label>
			                    <label class="container form-check form-check-inline">No
			                            <input type="radio" name="experience" value="no">
			                            <span class="checkmark"></span>
			                    </label>
								</p>
			                </div>
			                <div class="tab">
			                <p>
			                	<label>Describe tasks you'd feel comfortable providing out of childcare:</label>
			                </p>
			                        <select name="childcare" class="form-control">
									    <option value="Cooking just for children">Cooking just for children</option>
									    <option value="cooking for family and children">cooking for family and children</option>
									    <option value="light housework">light housework</option>
									    <option value="Errands, organization">Errands, organization</option>
									</select>
							</div>
							<div class="tab">      
								<p>
									<label>Comfortable with traveling with the family?</label>
									<label class="container form-check form-check-inline">Yes
			                            <input type="radio" name="comfortable" value="yes">
			                            <span class="checkmark"></span>
			                    </label>
			                    <label class="container form-check form-check-inline">No
			                            <input type="radio" name="comfortable" value="no">
			                            <span class="checkmark"></span>
			                    </label>
								</p>
			                </div>
			                <div class="tab">      
								<p>
									<label>Valid passport?</label>
									<label class="container form-check form-check-inline">Yes
			                            <input type="radio" name="passport" value="yes">
			                            <span class="checkmark"></span>
			                    </label>
			                    <label class="container form-check form-check-inline">No
			                            <input type="radio" name="passport" value="no">
			                            <span class="checkmark"></span>
			                    </label>
								</p>
			                </div>
			                <div class="tab">      
								<p>
									<label>Are you currently cpr and/or first aid certified?</label>
									<label class="container form-check form-check-inline">Yes
			                            <input type="radio" name="certified" value="yes">
			                            <span class="checkmark"></span>
			                    </label>
			                    <label class="container form-check form-check-inline">No
			                            <input type="radio" name="certified" value="no">
			                            <span class="checkmark"></span>
			                    </label>
								</p>
			                </div>
							<div class="tab">
								<p>
									<label>Now to the fun stuff, what do you like to do out of work? Hobbies? Interests? Self care routines?</label>
									<input oninput="this.className = ''" name="hobbies" class="form-control">
								</p>
							</div>
							<div class="tab">
								<p>
									<label>Instagram</label>
									<i class="lab la-instagram"></i>
									<input oninput="this.className = ''" class="form-control" placeholder="Instagram" id="autoSizingInputGroup">
									
								</p>
							</div>
							<div class="tab">
								<p>
									<label>File Upload</label>
									<input oninput="this.className = ''" type="file" class="form-control" name="fileToUpload" placeholder="Instagram" id="fileToUpload">
								</p>
							</div>
							<div class="tab">
								<p>
									<label>Past Employment Name</label>
									<input oninput="this.className = ''" name="pastname" class="form-control">
								</p>
							</div>
							<div class="tab">
								<p>
									<label>Past Employment Email</label>
									<input oninput="this.className = ''" name="pastemail" class="form-control">
								</p>
							</div>
							<div class="tab">
								<p>
									<label>Past Employment Phone Number</label>
									<input oninput="this.className = ''" name="pastphone" class="form-control">
								</p>
							</div>
							<div class="tab">
								<p>
									<label>work relationship</label>
									<input oninput="this.className = ''" name="pastwork" class="form-control">
								</p>
							</div>
							<div class="thanks-message text-center" id="text-message"> <img src="https://i.imgur.com/O18mJ1K.png" width="100" class="mb-4">
			                    <h3>Thanks for your Donation!</h3> <span>Your donation has been entered! We will contact you shortly!</span>
			                </div>
			                <div  id="nextprevious">
			                    <div class="d-flex justify-content-between mt-4"> 
			                    	<button type="button" class="btn btn-secondary btn-sm" id="prevBtn" onclick="nextPrev(-1)"><i class="las la-long-arrow-alt-left"></i>Previous</button>
			                    	<button type="button" class="btn btn-warning btn-sm" id="nextBtn" onclick="nextPrev(1)">Next<i class="las la-long-arrow-alt-right"></i></button> 
			                    </div>
			                </div>

   			</form>
		</div>
	</div>
</div>
<? } ?>	




