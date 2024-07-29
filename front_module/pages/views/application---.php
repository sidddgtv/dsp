<img src="storage/uploads/images/bird2.png" alt="" class="img-fluid position-absolute d-md-inline-block d-none pe-4 pt-4 end-0">

<div class="container py-md-5 p-4 my-md-5">
	<div class="text-center">
		<h2 class="text-center mb-4">Family Application</h2>
		<i class="las la-clock la-3x"></i>
		<h3 class="mt-3 mb-4">Make sure you have 5 or so minutes before you begin</h3>
		<button type="button" id="nextBtn" class="startbtn d-none" onclick="nextPrev2(1)">Next</button>
		<button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">Start </button>
	</div>
</div>





 
<form id="regForm" name="regForm" class="labelfrom">
	<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg modal-fullscreen-md-down">
			<div class="modal-content">
 				<button type="button" class="btn-close position-absolute top-0 end-0 p-4" data-bs-dismiss="modal" aria-label="Close" style="z-index:1"></button>
 					<div class="modal-body px-md-5 px-4 pt-md-5 pt-4">
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
                <!--<div class="tab">
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
						<label>Which option best describes what you're looking for?</label>
					</p>
					<select name="best" class="form-control">
						<option value="Nanny">Nanny</option>
						<option value="Newborn care specialist">Newborn care specialist</option>
						<option value="Sitter">Sitter</option>
					</select>
                </div>
				<div class="tab">      
					<p>
						<label>Nanny What type of schedule are you searching for?</label>
					</p>
					<select name="schedule" class="form-control">
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
                </div>-->
                <div class="thanks-message text-center" id="text-message"> <img src="https://i.imgur.com/O18mJ1K.png" width="100" class="mb-4">
                    <h3>Thanks for your Donation!</h3> <span>Your donation has been entered! We will contact you shortly!</span>
                </div>
            </div>
            <div class="modal-footer border-0 px-md-5 px-4 pb-md-5 pb-4" id="nextprevious2">
        <button type="button" class="btn btn-secondary btn-sm me-auto" id="prevBtn" onclick="nextPrev2(-1)"><i class="las la-long-arrow-alt-left"></i>Previous</button>
			                    			<button type="button" class="btn btn-warning btn-sm" id="nextBtn" onclick="nextPrev2(1)">Next<i class="las la-long-arrow-alt-right"></i></button>
      </div>
                <!--<div  id="nextprevious">
			        <div class="d-flex justify-content-between mt-4"> 
			            <button type="button" class="btn btn-secondary btn-sm" id="prevBtn" onclick="nextPrev2(-1)"><i class="las la-long-arrow-alt-left"></i>Previous</button>
			            <button type="button" class="btn btn-warning btn-sm" id="nextBtn" onclick="nextPrev2(1)">Next<i class="las la-long-arrow-alt-right"></i></button> 
			        </div>
			    </div>-->
             </div>

    </div>
          
  </div>

</div>
</form>

	
		

