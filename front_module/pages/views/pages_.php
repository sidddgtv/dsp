<?php  if($page_id != 88 && $page_id != 92) { ?>
	<div class="innerbanner position-relative text-center">
	<img src="<?php echo 'storage/uploads/'.$image;?>" alt="" class="img-fluid w-100">
  		<div class="container position-absolute top-50 start-50 translate-middle" style="z-index:9;">
   			 <?php echo $banner_description; ?>
  		</div>
</div>
 <? } ?>
<?php echo $section_data; ?>

<?php if($page_id == 82) { ?>
<img src="storage/uploads/images/bird2.png" alt="" class="img-fluid position-absolute d-md-inline-block d-none pe-4 pt-4 end-0">
<div class="container py-md-5 p-4 my-md-5">
	<div class="row align-items-center">
		<div class="col-md-10 col-12 mx-auto">
			<h2 class="fw-bold mb-4">Family Application</h2>
			<form name="applicationform" id="applicationform" action="" method="post" class="mt-md-0 mt-4 labelfrom">
				<div class="row g-3">
					<div class="col-md-6">
						<label>First Name</label>
						<input type="text" name="fname" class="form-control">
					</div>
					<div class="col-md-6">
						<label>Last Name</label>
						<input type="text" name="lname" class="form-control">
					</div>
				</div>
				<div class="row g-3">
					<div class="col-md-6">
						<label>Email</label>
						<input type="text" name="email" class="form-control">
					</div>
					<div class="col-md-6">
						<label>Cell number</label>
						<input type="text" name="cellnumber" class="form-control">
					</div>
				</div>
				<div class="row g-3">
					<div class="col-md-12">
						<label>Where are you currently located?</label>
						<textarea name="location" class="form-control"></textarea>
					</div>
				</div>
				<div class="row g-3">
					<div class="col-md-4">
						<label>Address</label>
						<input type="text" name="address" class="form-control">
					</div>
					<div class="col-md-4">
						<label>Neighborhood</label>
						<input type="text" name="neighborhood" class="form-control">
					</div>
					<div class="col-md-4">
						<label>Zip code</label>
						<input type="text" name="zipcode" class="form-control">
					</div>
				</div>
				<div class="row g-3">
					<div class="col-md-12">
						<label>If you are moving, please tell us where you plan to settle!</label>
						<textarea name="settle" class="form-control"></textarea>
					</div>
				</div>
				<div class="row g-3">
					<div class="col-md-6">
						<label>Which option best describes what you're looking for?</label>
							<select class="form-select" aria-label="Default select example" name="best">
								<option selected="" value="Nanny">Nanny</option>
								<option value="newborn care specialist">Newborn care specialist</option>
								<option value="Sitter">Sitter</option>
							</select>
					</div>

					<div class="col-md-6">
						<label>What type of schedule are you searching for?</label>
							<select class="form-select" aria-label="Default select example" name="schedule">
								<option selected="" value="full-time">Full-Time (40+ Hours Per Week)</option>
								<option value="part-time">Part-Time (20-40 Hours Per Week)</option>
							</select>
					</div>
				</div>
				<div class="row g-3 mt-2">
					<div class="col-md-6">
						<label>Preferred start date?</label>
						<input type="date" name="preferred" class="form-control">
					</div>
					<div class="col-md-6">
						<label>Number of children?</label>
						<input type="text" name="children" class="form-control">
					</div>
				</div>
				<div class="row g-3">
					<div class="col-md-12">
						<label>Special Needs- allergies, medical, behavioral?</label>
						<textarea name="allergies" class="form-control"></textarea>
					</div>
				</div>
				<div class="row g-3">
					<div class="col-md-12">
						<label>Have you previously employed a nanny?</label>
						<div class="form-check form-check-inline">
  						<input class="form-check-input" type="radio" name="employed" id="employed1">
  						<label class="form-check-label" for="employed1" value="yes">Yes</label>
						</div>
						<div class="form-check form-check-inline">
  						<input class="form-check-input" type="radio" name="employed" id="employed2">
  						<label class="form-check-label" for="employed2" value="no">No</label>
						</div>
					</div>
				</div>
				<div class="row g-3">
					<div class="col-md-12">
						<label>If yes- what did you like most about the experience/nanny? Least or most challenging??</label>
						<textarea name="experience" class="form-control"></textarea>
					</div>
				</div>
				<div class="row g-3 mt-2">
					<div class="col-md-6">
						<label>Preferred start date?</label>
						<input type="date" name="preferred1" class="form-control">
					</div>
				</div>
				<div class="row g-3">
					<div class="col-md-6">
						<label>What is your child/children's normal routine?</label>
						<textarea name="routine" class="form-control"></textarea>
					</div>
					<div class="col-md-6">
						<label>How do you like to spend time with your child?</label>
						<textarea name="spend" class="form-control"></textarea>
					</div>
				</div>
				<div class="row g-3">
					<div class="col-md-12">
						<label>What's your method of authority/discipline like with your child?</label>
						<textarea name="authority" class="form-control"></textarea>
					</div>
				</div>
				<div class="row g-3">
					<div class="col-md-12">
						<label>Is there anything else that you would like to tell us about your children, family, or the position?</label>
						<textarea name="position" class="form-control"></textarea>
					</div>
				</div>
				<div class="row g-3">
					<div class="col-md-12">
						<label>Current rates range from $30-$40+/hr. Is that a rate range you’re comfortable with?</label>
						<div class="form-check form-check-inline">
  						<input class="form-check-input" type="radio" name="comfortable" id="comfortable1">
  						<label class="form-check-label" for="comfortable1" value="yes">Yes</label>
						</div>
						<div class="form-check form-check-inline">
  						<input class="form-check-input" type="radio" name="comfortable" id="comfortable2">
  						<label class="form-check-label" for="comfortable2" value="no">No</label>
						</div>
					</div>
				</div>
				<p>Rate considerations include: experience, qualifications, number of children, schedule, and
expected duties. To obtain a top of the line nanny you have to pay them deservingly.</p>
					<div class="col-12 text-center mt-4">
						<button type="submit" name="button" id="button" value="" class="btn btn-warning mt-2"><span>Submit</span></button>
						<input type="hidden" name="script_type"  value="applicationform"/>
						<span id="applicationform_error" class="error"></span>
						<span id="applicationform_success" class="error"></span>
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
			<h2 class="fw-bold mb-4">Baby products</h2>
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
				<h2 class="my-5">Articles</h2>
				<ul class="list list-arrow">
					<li><a href="https://www.pregnancybirthbaby.org.au/newborn-baby-essentials" target="_blank" style="color:#a27564"><h3><u>Newborn baby essentials</u></h3></a></li>
					<li><a href="https://www.pregnancybirthbaby.org.au/your-childs-health" target="_blank" style="color:#a27564"><h3><u>Your child&#39;s health</u></h3></a></li>
					<li><a href="https://www.pregnancybirthbaby.org.au/baby-feeding" target="_blank" style="color:#a27564"><h3><u>Feeding your baby</u></h3></a></li>
					<li><a href="https://www.pregnancybirthbaby.org.au/language-and-speech" target="_blank" style="color:#a27564"><h3><u>Language and speech development</u></h3></a></li>
					<li><a href="https://www.pregnancybirthbaby.org.au/childrens-milestones" target="_blank" style="color:#a27564"><h3><u>Children&#39;s milestones</u></h3></a></li>
				</ul>
			</div>
				<div class="col-md-4">
					<h3 class="fw-bold mt-4">Our Focus</h3>
					<p>While other agencies have a wider area of support through private security, house cleaners , and organizers, we focus on just one, Nanny&rsquo;s. Finding the best care for your children is where our values lie, we keep that as our priority.</p>
					<hr class="my-4" /><img alt="" class="img-fluid w-100" src="storage/uploads/images/baby-product5.jpg" />
					<h3 class="mt-4">We have built a team of highly trained, experienced Nanny&rsquo;s. The best of the best as your children deserve.</h3>
				</div>
			</div>
		</div>
<? } ?>
<?php if($page_id == 88) { ?>
	<div class="container py-md-5 p-4 my-md-5"><img alt="" class="img-fluid position-absolute d-md-inline-block d-none ps-4 pt-4" src="storage/uploads/images/bird.png" />
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

	
<div class="col-auto"><a class="btn btn-warning" href="<?php echo base_Url('pages/index/92/'.$job['id']);?>">Apply Now</a></div>

<div class="col-12">
<hr /></div>
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
		<!--<h2 class="text-center mb-5">
		<?php echo $job['jobname'];?></h2>-->
<h2 class="text-center mb-5">Nanny questionnaire</h2>

	<div class="row align-items-center">
		<div class="col-md-10 col-12 mx-auto">
			<!--<h2 class="text-center mb-5">Nanny questionnaire</h2>-->
			<form name="jobform" id="jobform" action="" method="post" class="mt-md-0 mt-4 labelfrom">
				<?php echo '<input type="hidden" id="job_id" name="job_id" value="'.$this->uri->segment(4).'" />'; ?>
				<div class="row g-3">
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
					<!--<a href="#"><i class="lab la-instagram fs-2 bg-light p-1 rounded-2"></i></a>-->
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
				</div>
		</div>
	</form>

	</div>
	</div>
</div>

<? } ?>	
