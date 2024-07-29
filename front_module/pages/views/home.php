<div class="container-fluid">
    <div class="d-flex justify-content-center mt-4">
        <img src="<?php echo base_url('/storage/uploads/images/logo.svg');?> " style="max-width:150px;">
    </div>
    <h1 align="center" class="text-white">Login</h1>
        <?php  
            if(!empty($success_msg)){ 
                //echo '<p class="status-msg success">'.$success_msg.'</p>';
                echo '<div class="alert alert-info alert-dismissible fade show" role="alert">' . $success_msg . ' <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              
              </button>
            </div>'; 
            }elseif(!empty($error_msg)){ 
                //echo '<p class="status-msg error">'.$error_msg.'</p>'; 
                 echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">' . $error_msg . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              
              </button>
            </div>'; 
            } 
        ?>
        <div class="row mt-5">
            <div class="col-sm-10 col-md-6 mx-auto text-center">     
                <form action="" method="post">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text p-3" id="basic-addon1"><i class="fa fa-user"></i></span>
                        </div>
                        <input class="form-control form-control-lg" type="email" name="email" placeholder="EMAIL" required="">
                        <?php echo form_error('email','<p class="help-block">','</p>'); ?>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text p-3" id="basic-addon1"><i class="fa fa-lock"></i></span>
                        </div>
                        <input class="form-control form-control-lg" type="password" name="password" placeholder="PASSWORD" required="">
                        <?php echo form_error('password','<p class="help-block">','</p>'); ?>
                    </div>
                    <div class="send-button">
                        <input type="submit" class="btn  btn-lg mb-2 bg-white"  name="loginSubmit" value="LOGIN">
                    </div>
                </form>
                <p class="text-white">Don't have an account? <br/>
                <a href="<?php echo base_url('flogin/registration'); ?>" class="text-white">Register</a> |
                <a href="<?php echo base_url('flogin/forgotPassword'); ?>" class="ms-2 text-white">Forgot Password?</a></p>
            </div>
        </div>
</div>




