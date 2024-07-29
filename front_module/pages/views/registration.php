
<div class="container py-lg-5 py-4">
    <h2 class="text-center text-white">Create a New Account</h2>
	<hr/>
    <!-- Status message -->
    <?php  
        if(!empty($success_msg)){ 
            echo '<p class="status-msg success">'.$success_msg.'</p>'; 
        }elseif(!empty($error_msg)){ 
            echo '<p class="status-msg error" style="color:red;">'.$error_msg.'</p>'; 
        } 
    ?>
	
    <!-- Registration form -->
    <div class="regisFrm">
        <form action="" method="post">
            <div class="row">
                <div class="form-group col  mb-3">
                    <input class="form-control form-control-lg" id="fname" type="text" name="first_name" placeholder="Full Name" value="<?php echo !empty($user['first_name'])?$user['first_name']:''; ?>" required>
                    <?php echo form_error('first_name','<p class="help-block">','</p>'); ?>
                </div>
              <!--  <div class="form-group col  mb-3">
                    <input type="text" class="form-control form-control-lg" name="last_name" id="lname" placeholder="Last Name" value="<?php echo !empty($user['last_name'])?$user['last_name']:''; ?>" required>
                    <?php echo form_error('last_name','<p class="help-block">','</p>'); ?>
                </div>-->
               <div class="form-group col  mb-3">
                    <input type="email" class="form-control form-control-lg" name="email" id="email" placeholder="Email" value="<?php echo !empty($user['email'])?$user['email']:''; ?>" required>
                    <?php echo form_error('email','<p class="help-block">','</p>'); ?>
                </div>
            </div>
            <div class="row">
               
                <div class="form-group col  mb-3">
                    <input type="text" class="form-control form-control-lg" name="phone" id="phone" placeholder="Phone Number" value="<?php echo !empty($user['phone'])?$user['phone']:''; ?>" required>
                    <?php echo form_error('phone','<p class="help-block">','</p>'); ?>
                </div>
                 <div class="form-group col  mb-3">
                    <input type="text" class="form-control form-control-lg" name="address" id="address" placeholder="Address" value="<?php echo !empty($user['address'])?$user['address']:''; ?>" required>
                </div>
            </div>
          
            <div class="row">
                <div class="form-group col  mb-3">
                    <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Password" required>
                    <?php echo form_error('password','<p class="help-block">','</p>'); ?>
                </div>
                <div class="form-group col  mb-3">
                    <input type="password" class="form-control form-control-lg" id="cpassword" name="conf_password" placeholder="Confirm Password" required>
                    <?php echo form_error('conf_password','<p class="help-block">','</p>'); ?>
                </div>
            </div>
            <div class="send-button d-flex justify-content-center">
                <input type="submit" name="signupSubmit" class="btn me-3 bg-white" value="CREATE ACCOUNT">
                <input type="button" class="float-right btn bg-white" onclick="this.form.reset();" value="Cancel">
            </div>
        </form>
        <div class="row">
            <div class="col text-center mt-3 text-white">
                <p>Already have an account? <a href="<?php echo base_url('flogin/login'); ?>">Login here</a></p>
            </div>
        </div>
    </div>
</div>

