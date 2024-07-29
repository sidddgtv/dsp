<img src="storage/uploads/images/bird2.png" alt="" class="img-fluid position-absolute d-md-inline-block d-none pe-4 pt-4 end-0">

<div class="container py-md-5 p-4 my-md-5">
	<div class="text-center">
		<h1 id="register">Family Application</h1>
		<i class="las la-clock la-3x"></i>
	    <h3 class="mt-3 mb-4">Make sure you have 5 or so minutes before you begin</h3>
	    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">Start</button>
	</div>
</div>

<form id="regForm" name="regForm" class="labelfrom">
	<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg modal-fullscreen-md-down">
			<div class="modal-content">
 				<button type="button" class="btn-close position-absolute top-0 end-0 p-4" data-bs-dismiss="modal" aria-label="Close" style="z-index:1"></button>
 				<div class="modal-body px-md-5 px-4 pt-md-5 pt-4">
					<h2 class="text-center mb-4">Family Application</h2>
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
	                    <label>First Name</label>
						<input type="text" id="fname" name="fname" class="form-control" placeholder="First Name" oninput="this.className = ''" >
	                </div>
	                <div class="tab">
	                    
	                    	<label>Last Name</label>
	                    	<input placeholder="Last Name" oninput="this.className = ''" id="lname" name="lname" class="form-control">
	                    
	                </div>
	                <div class="tab">
	                    <p>
	                    	<label>Email</label>
	                    	<input type="email" placeholder="Email" oninput="this.className = ''" name="email" class="form-control">
	                    </p>
	                </div>
	                <div class="tab">
	                    
	                    	<label>Cell number</label>
	                    	<input type="text" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;" placeholder="Phone" oninput="this.className = ''" name="cellnumber" class="form-control">
	                    
	                </div>
	                <div class="tab">
	                    
	                    	<label>Where are you currently located?</label>
	                    	<input placeholder="Location" oninput="this.className = ''" name="location" class="form-control">
	                    
	                </div>
	                <div class="tab">
	                   
	                    	<label>Address</label>
	                    	<input placeholder="Address" oninput="this.className = ''" name="address" class="form-control">
	                    
	                </div>
	                <div class="tab">
	                   
	                    	<label>Neighborhood</label>
	                    	<input placeholder="neighborhood" oninput="this.className = ''" name="neighborhood" class="form-control">
	                    
	                </div>
	                <div class="tab">
	                    
	                    	<label>Zip code</label>
	                    	<input type="text" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;" placeholder="zipcode" oninput="this.className = ''" name="zipcode" class="form-control">
	                    
	                </div>
	                <div class="tab">
	                    
	                    	<label>If you are moving, please tell us where you plan to settle!</label>
	                    	<input oninput="this.className = ''" name="settle" class="form-control">
	                    
	                </div>
	                <div class="tab">      
						<p>
							<label>Which option best describes what you're looking for?</label>
						</p>
						<select name="best" class="form-select">
							<option value="Nanny">Nanny</option>
							<option value="Newborn care specialist">Newborn care specialist</option>
							<option value="Sitter">Sitter</option>
						</select>
	                </div>
					<div class="tab">      
						<p>
							<label>Nanny What type of schedule are you searching for?</label>
						</p>
						<select name="schedule" class="form-select">
							<option value="Full-Time (40+ Hours Per Week)">Full-Time (40+ Hours Per Week)</option>
							<option value="Part-Time (20-40 Hours Per Week)">Part-Time (20-40 Hours Per Week)</option>
						</select>
	                </div>
	                <div class="tab">      
						
							<label>Preferred start date?</label>
							<input type="date" oninput="this.className = ''" name="preferred" class="form-control">
						
	                </div>
	                <div class="tab">      
						
							<label>Number of children?</label>
							<input type="text" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;" oninput="this.className = ''" name="children" class="form-control">
						
	                </div>
	                <div class="tab">      
						
							<label>Special Needs- allergies, medical, behavioral?</label>
							<input oninput="this.className = ''" name="allergies" class="form-control">
						
	                </div>
	                <div class="tab">      
						<p>
							<label>Have you previously employed a nanny?</label>
							<label class="container form-check form-check-inline">Yes
	                            <input type="radio" name="employed" value="yes" onclick="$('#experience').val('')">
	                            <span class="checkmark"></span>
	                    </label>
	                    <label class="container form-check form-check-inline">No
	                            <input type="radio" name="employed" value="no" onclick="$('#experience').val(' ')">
	                            <span class="checkmark"></span>
	                    </label>
						</p>
	               		<div class="experience_sec">
							
								<label>If yes- what did you like most about the experience/nanny? Least or most challenging??</label>
								<input oninput="this.className = ''" name="experience" id="experience" class="form-control">
							
						</div>
					</div>
					<div class="tab">
						
							<label>Preferred start date?</label>
							<input type="date" oninput="this.className = ''" name="preferred1" class="form-control">
						
					</div>
					<div class="tab">
						
							<label>What is your child/children's normal routine?</label>
							<input oninput="this.className = ''" name="routine" class="form-control">
						
					</div>
					<div class="tab">
						
							<label>How do you like to spend time with your child?</label>
							<input oninput="this.className = ''" name="spend" class="form-control">
						
					</div>
					<div class="tab">
						
							<label>What's your method of authority/discipline like with your child?</label>
							<input oninput="this.className = ''" name="authority" class="form-control">
						
					</div>
					<div class="tab">
						
							<label>Is there anything else that you would like to tell us about your children, family, or the position?</label>
							<input oninput="this.className = ''" name="position" class="form-control">
						
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
	                <div class="thanks-message text-center" id="text-message"> <i class="las la-check-circle la-5x mb-3 text-success"></i>
	                    <h3>Thank you for submitting your requirements.</h3> <span>Your nanny shall contact soon!</span>
	                </div>
				    <div class="modal-footer border-0 px-md-5 px-4 pb-md-5 pb-4" id="nextprevious">
	        			<button type="button" class="btn btn-secondary btn-sm me-auto" id="prevBtn" onclick="nextPrev2(-1)"><i class="las la-long-arrow-alt-left"></i>Previous</button>
				        <button type="button" class="btn btn-warning btn-sm" id="nextBtn2" onclick="nextPrev2(1)">Next<i class="las la-long-arrow-alt-right"></i></button>
	      			</div>
          		</div>
    		</div>
		</div>
	</div>
</form>

	
		

