<?php  if($page_id != 88 && $page_id != 92 ) { ?>
	<div class="innerbanner position-relative text-center">
		<img src="<?php echo 'storage/uploads/'.$image;?>" alt="" class="img-fluid w-100">
  		<div class="container position-absolute top-50 start-50 translate-middle" style="z-index:9;">
   			 <!--<?php echo $banner_description; ?>-->
  		</div>
	</div>
 <? } ?>
<?php echo $section_data; ?>



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

<div class="container py-md-5 p-4 my-md-5">
	<?php 
		$jid = $this->uri->segment(4);
		$singlejob = $this->pages_model->getSingleJob($jid);
	?>
	<h2 class="fw-bold mb-2 text-center"><?php echo $singlejob['jobname']; ?></h2>
	<p class="text-center"><strong><?php echo $singlejob['jobarea']; ?></strong></p>
	 <div class="text-center">
					                	<i class="las la-clock la-3x"></i>
					                    <h3 class="mt-3 mb-4">Make sure you have 5 or so minutes before you begin</h3>
					                    <!--<button type="button" id="nextBtn" class="startbtn" onclick="nextPrev(1)">Next</button>-->
					                    <button type="button" id="nextBtn" class="startbtn d-none" onclick="nextPrev(1)">Next</button>
					                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">Start Nanny Questionnaire</button>
					                </div>
	
</div>


<!-- Modal -->
	      <form name="jobform" id="jobform" action="" method="post" class="labelfrom">
					<?php echo '<input type="hidden" id="job_id" name="job_id" value="'.$this->uri->segment(4).'" />'; ?>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered modal-lg modal-fullscreen-md-down">
  	     

    <div class="modal-content">
 <button type="button" class="btn-close position-absolute top-0 end-0 p-4" data-bs-dismiss="modal" aria-label="Close" style="z-index:1"></button>
      <div class="modal-body px-md-5 px-4 pt-md-5 pt-4">
					<h2 class="text-center mb-4">Nanny questionnaire</h2>

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
					                
									<div class="tab">
					                 
					                    	<label>Name</label>
					                    	<input type="text" name="name" class="form-control" placeholder="Name" oninput="this.className = ''" >
					          
					                </div>
					                <!--<div class="tab">
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
									</div>-->
									<div class="tab">
									
											<label>Instagram</label>
    										<div class="input-group">
												<div class="input-group-text"><i class="lab la-instagram"></i></div>
												<input type="text" oninput="this.className = ''" class="form-control" placeholder="Instagram">

											</div>
										
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
									<div class="thanks-message text-center" id="text-message2"> <i class="las la-check-circle la-5x mb-3 text-success"></i>
					                    <h3>Thanks for your Donation!</h3> <span>Your donation has been entered! We will contact you shortly!</span>
					                </div>
                					<!--<div  id="nextprevious2">
			                    		<div class="d-flex justify-content-between mt-4"> 
			                    			<button type="button" class="btn btn-secondary btn-sm" id="prevBtn" onclick="nextPrev(-1)"><i class="las la-long-arrow-alt-left"></i>Previous</button>
			                    			<button type="button" class="btn btn-warning btn-sm" id="nextBtn" onclick="nextPrev(1)">Next<i class="las la-long-arrow-alt-right"></i></button> 
			                    		</div>
			                		</div>
                <div style="overflow:auto;" id="nextprevious2">
                    <div style="float:right;"> 
                    	<button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button> <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button> 
                    </div>
                </div>-->
            

					
		</div>
		<div class="modal-footer border-0 px-md-5 px-4 pb-md-5 pb-4" id="nextprevious2">
        <button type="button" class="btn btn-secondary btn-sm me-auto" id="prevBtn" onclick="nextPrev(-1)"><i class="las la-long-arrow-alt-left"></i>Previous</button>
			                    			<button type="button" class="btn btn-warning btn-sm" id="nextBtn" onclick="nextPrev(1)">Next<i class="las la-long-arrow-alt-right"></i></button>
      </div>

    </div>
          
  </div>

</div>
</form>











<? } ?>	












				<!--<div class="row g-3">
					<div class="col-md-4">
						<label>Name</label>
						<input type="text" name="name" class="form-control">
					</div>
					<div class="col-md-4">
						<label>Last Name</label>
						<input type="text" name="lname" class="form-control">
					</div>
					<div class="col-md-4">
						<label>Preferred Pronouns</label>
						<input type="text" name="preferred" class="form-control">
					</div>
				</div>
				<div class="row g-3">
					<div class="col-md-6">
						<label>Email</label>
						<input type="text" name="email" class="form-control">
					</div>
					<div class="col-md-6">
						<label>Cell phone</label>
						<input type="text" name="cellphone" class="form-control">
					</div>
				</div>
				<div class="row g-3">
					<div class="col-md-6">
						<div>	  
		        			<label class="form-check-inline" for="exampleCheck1">Are you authorized to work in the US?</label>
		        			<div class="form-check form-check-inline" required>
		          				<input class="form-check-input" type="radio" name="authorized" id="inlineRadio1" value="yes">
		          				<label class="form-check-label" for="inlineRadio1">Yes</label>
		        			</div>
		        			<div class="form-check form-check-inline">
		          				<input class="form-check-input" type="radio" name="authorized" id="inlineRadio2" value="no">
		          				<label class="form-check-label" for="inlineRadio2">No</label>
		        			</div>
						</div>
					</div>
					<div class="col-md-6">
						<label>How many professional years of nanny experience do you have?</label>
						<input type="text" name="professional" class="form-control">
					</div>
				</div>
				<div class="row g-3">
					<div class="col-md-12">
						<label>Please tell us what area you are located in</label>
							<select class="form-select" aria-label="Default select example" name="area">
								<option selected="" value="San Francisco">San Francisco</option>
								<option value="Los Angeles">Los Angeles</option>
								<option value="Santa Barbara">Santa Barbara</option>
								<option value="New York">New York</option>
							</select>
					</div>
				</div>
				<div class="row g-3 mt-2">
					<div class="col-md-12">
						<label>Current address</label>
						<textarea name="current_address" class="form-control"></textarea>
					</div>
				</div>
				<div class="row g-3">
					<div class="col-md-6">
						<div>	  
			    			<label class="form-check-inline" for="exampleCheck1">Do you have a valid driver's license?</label>
			    			<div class="form-check form-check-inline" required>
			      				<input class="form-check-input" type="radio" name="license" id="inlineRadio3" value="yes">
			      				<label class="form-check-label" for="inlineRadio3">Yes</label>
			    			</div>
			    			<div class="form-check form-check-inline">
			      				<input class="form-check-input" type="radio" name="license" id="inlineRadio4" value="no">
			      				<label class="form-check-label" for="inlineRadio4">No</label>
			    			</div>
						</div>
					</div>
					<div class="col-md-6">
						<div>	  
		        			<label class="form-check-inline" for="exampleCheck1">Do you have a reliable and insured vehicle?</label>
		        			<div class="form-check form-check-inline" required>
		          				<input class="form-check-input" type="radio" name="vehicle" id="inlineRadio5" value="yes">
		          				<label class="form-check-label" for="inlineRadio5">Yes</label>
		        			</div>
		        			<div class="form-check form-check-inline">
		          				<input class="form-check-input" type="radio" name="vehicle" id="inlineRadio6" value="no">
		          				<label class="form-check-label" for="inlineRadio6">No</label>
		        			</div>
						</div>
					</div>
				</div>
				<div class="row g-3">
					<div class="col-md-12">
						<label>What makes you interested in working with children?</label>
						<input type="text" name="interested" class="form-control">
					</div>
				</div>
				<div class="row g-3">
					<div class="col-md-12">
						<label>Please tell us more- we want to get to know you! What makes you stand out? What have your
						past families loved about you, or the things that set you aside as a caregiver?</label>
						<textarea name="caregiver" class="form-control"></textarea>
					</div>
				</div>
				<div class="row g-3">
					<div class="col-md-12">
						<label>What do you find most challenging or difficult about being a caregiver?</label>
						<input type="text" name="challenge" class="form-control">
					</div>
				</div>
				<div class="row g-3">
					<div class="col-md-12">
						<label>Highest form of education</label>
						<input type="text" name="education" class="form-control">
					</div>
				</div>
				<div class="row g-3">
					<div class="col-md-12">
						<label>What is your first language? Do you speak any other languages?</label>
						<input type="text" name="language" class="form-control">
					</div>
				</div>
				<div class="row g-3">
					<div class="col-md-6">
						<div>	  
							<label class="form-check-inline" for="exampleCheck1">Looking for</label>
								<div class="form-check form-check-inline" required>
									<input class="form-check-input" type="radio" name="looking" id="inlineRadio7" value="live in">
									<label class="form-check-label" for="inlineRadio7">live in</label>
								</div>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="looking" id="inlineRadio8" value="live out">
									<label class="form-check-label" for="inlineRadio8">live out</label>
								</div>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="looking" id="inlineRadio9" value="either">
									<label class="form-check-label" for="inlineRadio9">either</label>
								</div>
						</div>
					</div>
					<div class="col-md-6">
						<div>	  
			    			<label class="form-check-inline" for="exampleCheck1">Can you commit to one year?</label>
			    			<div class="form-check form-check-inline" required>
			      				<input class="form-check-input" type="radio" name="commit" id="inlineRadio10" value="yes">
			      				<label class="form-check-label" for="inlineRadio10">Yes</label>
			    			</div>
			    			<div class="form-check form-check-inline">
			      				<input class="form-check-input" type="radio" name="commit" id="inlineRadio11" value="no">
			      				<label class="form-check-label" for="inlineRadio11">No</label>
			    			</div>
						</div>
					</div>
				</div>
				<div class="row g-3">
					<div class="col-md-6">
						<div>	  
			    			<label class="form-check-inline" for="exampleCheck1">Open to relocate for a new job?</label>
			    			<div class="form-check form-check-inline" required>
			      				<input class="form-check-input" type="radio" name="relocate" id="inlineRadio12" value="yes">
			      				<label class="form-check-label" for="inlineRadio12">Yes</label>
			    			</div>
			    			<div class="form-check form-check-inline">
			      				<input class="form-check-input" type="radio" name="relocate" id="inlineRadio13" value="no">
			      				<label class="form-check-label" for="inlineRadio13">No</label>
			    			</div>
						</div>
					</div>
					<div class="col-md-6">
						<div>	  
			    			<label class="form-check-inline" for="exampleCheck1">Experience with twins, triplets?</label>
			    			<div class="form-check form-check-inline" required>
			      				<input class="form-check-input" type="radio" name="twins" id="inlineRadio14" value="yes">
			      				<label class="form-check-label" for="inlineRadio14">Yes</label>
			    			</div>
			    			<div class="form-check form-check-inline">
			      				<input class="form-check-input" type="radio" name="twins" id="inlineRadio15" value="no">
			      				<label class="form-check-label" for="inlineRadio15">No</label>
			    			</div>
						</div>
					</div>
				</div>
				<div class="row g-3">
					<div class="col-md-6">
						<div>	  
			    			<label class="form-check-inline" for="exampleCheck1">Special needs experience?</label>
			    			<div class="form-check form-check-inline" required>
			      				<input class="form-check-input" type="radio" name="experience" id="inlineRadio16" value="yes">
			      				<label class="form-check-label" for="inlineRadio16">Yes</label>
			    			</div>
			    			<div class="form-check form-check-inline">
			      				<input class="form-check-input" type="radio" name="experience" id="inlineRadio17" value="no">
			      				<label class="form-check-label" for="inlineRadio17">No</label>
			    			</div>
						</div>
					</div>
					<div class="col-md-6">
						<label>Describe tasks you'd feel comfortable providing out of childcare:</label>
							<select class="form-select" aria-label="Default select example" name="childcare">
								<option selected="" value="cooking just for children">Cooking just for children</option>
								<option value="cooking for family and children">cooking for family and children</option>
								<option value="light housework">light housework</option>
								<option value="Errands, organization">Errands, organization</option>
							</select>
					</div>
				</div>
				<div class="row g-3">
					<div class="col-md-6">
						<div>	  
			    			<label class="form-check-inline" for="exampleCheck1">Comfortable with traveling with the family?</label>
			    			<div class="form-check form-check-inline" required>
			      				<input class="form-check-input" type="radio" name="comfortable" id="inlineRadio18" value="yes">
			      				<label class="form-check-label" for="inlineRadio18">Yes</label>
			    			</div>
			    			<div class="form-check form-check-inline">
			      				<input class="form-check-input" type="radio" name="comfortable" id="inlineRadio19" value="no">
			      				<label class="form-check-label" for="inlineRadio19">No</label>
			    			</div>
						</div>
					</div>
					<div class="col-md-6">
						<div>	  
			    			<label class="form-check-inline" for="exampleCheck1">Valid passport?</label>
			    			<div class="form-check form-check-inline" required>
			      				<input class="form-check-input" type="radio" name="passport" id="inlineRadio20" value="yes">
			      				<label class="form-check-label" for="inlineRadio20">Yes</label>
			    			</div>
			    			<div class="form-check form-check-inline">
			      				<input class="form-check-input" type="radio" name="passport" id="inlineRadio21" value="no">
			      				<label class="form-check-label" for="inlineRadio21">No</label>
			    			</div>
						</div>
					</div>
				</div>
				<div class="row g-3">
					<div class="col-md-12">
						<div>	  
        					<label class="form-check-inline" for="exampleCheck1">Are you currently cpr and/or first aid certified?</label>
        					<div class="form-check form-check-inline" required>
          						<input class="form-check-input" type="radio" name="certified" id="inlineRadio22" value="yes">
          						<label class="form-check-label" for="inlineRadio22">Yes</label>
        					</div>
        					<div class="form-check form-check-inline">
          						<input class="form-check-input" type="radio" name="certified" id="inlineRadio23" value="no">
          						<label class="form-check-label" for="inlineRadio23">No</label>
        					</div>
						</div>
					</div>
				</div>
				
				<div class="row g-3 mt-2">
					<div class="col-md-12">
						<label>Now to the fun stuff, what do you like to do out of work? Hobbies? Interests? Self care routines?</label>
						<textarea name="hobbies" class="form-control"></textarea>
					</div>
				</div>
				<div class="row g-3 mt-2">
					<div class="col-md-6">
					<a href="#"><i class="lab la-instagram fs-2 bg-light p-1 rounded-2"></i></a>
    					<div class="input-group">
      					<div class="input-group-text"><i class="lab la-instagram"></i></div>
      						<input type="text" class="form-control mb-0" id="autoSizingInputGroup" placeholder="Instagram">
    					</div>
					</div>
					<div class="col-md-6">
  						<input class="form-control" type="file" id="fileToUpload" name="fileToUpload">
					</div>
				</div>
			
				<h2 class="text-center mt-5 mb-3">Past employment personal references</h2>
				<div class="row g-3">
					<div class="col-md-6">
						<label>Name</label>
						<input type="text" name="pastname" class="form-control">
					</div>
					<div class="col-md-6">
						<label>Phone Number</label>
						<input type="text" name="pastphone" class="form-control">
					</div>
				</div>
				<div class="row g-3">
					<div class="col-md-6">
						<label>Email</label>
						<input type="email" name="pastemail" class="form-control">
					</div>
					<div class="col-md-6">
						<label>work relationship</label>
						<input type="text" name="pastwork" class="form-control">
					</div>
				</div>
				<div class="col-12 text-center mt-4">
					<button type="submit" name="button" id="button" value="" class="btn btn-warning mt-2"><span>Submit</span></button>
					<input type="hidden" name="script_type"  value="jobform"/>
					<span id="jobform_error" class="error"></span>
					<span id="jobform_success" class="error"></span>
				</div>-->
		<!--</div>
	</form>-->


