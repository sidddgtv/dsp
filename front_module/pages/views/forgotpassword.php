<div class="container-fluid h-100">
     <div class="row h-100">
         <div class="d-flex justify-content-center"><img src="<?php echo base_url('/storage/uploads/images/logo.svg');?> " style="max-width:150px;"></div>
    <!-- Status message -->
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
    <div class="panel panel-color panel-default panel-pages col-md-6 m-auto">
        <div class="panel-heading"> 
            <h4 class="text-center m-0 py-2 text-white">Forgot Password</h4>
        </div>
        <div class="panel-body">
            <div class="regisFrm">
                <form action="" method="post">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text p-3" id="basic-addon1"><i class="fa fa-user"></i></span>
                        </div>
                        <input class="form-control" type="email" name="email" placeholder="EMAIL" required="" id="forgot_email">
                        <?php echo form_error('email','<p class="help-block">','</p>'); ?>
                    </div>
                    <div class="send-button d-flex justify-content-center ">
                        <input type="submit" class="btn bg-white" name="forgot" value="Forgot Password" id="forgot_button">
                        
                    </div> 
                     <div class="row">
            <div class="col text-center mt-3 text-white">
                <p>Back to the login page?<a href="<?php echo base_url('flogin/login'); ?>">Login here</a></p>
            </div>
        </div>
                </form>
            </div>
        </div> 
    </div> 
</div>
</div>
<script>
$(document).ready(function(){
    $("#forgot_email").keyup(function(){
        $("#forgot_button").val("Send Password");
    });
});
</script>