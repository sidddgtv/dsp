<div class="d-flex align-items-center justify-content-between">
<h6 class="mb-0"><strong>eSign with Docusign</strong></h6>
<div class="pull-right">
    <a href="<?php echo admin_url('document'); ?>" data-toggle="tooltip" title="cancel" class="btn btn-danger btn-sm"><i class="fa fa-reply"></i></a>
</div>
</div>
<hr>

<?php 
//check whether login with docusign exists or not
if(!array_key_exists('authData',$_SESSION) || (array_key_exists('authData',$_SESSION) && property_exists($_SESSION['authData'],'error'))){
    //connect
    echo '
    <div class="text-center">
    <form action="" method="POST">
    <button type="submit" class="btn btn-primary" id="docusign_connect" name="docusign_connect" value="1">Connect to Docusign</button>
    <small class="text-danger d-block mt-3">Please click "Allow" for DocuSign in your browser before logging in</small>
    </form>
    <div>
    ';
}else{
    //sign document
    //print_r($_SESSION);
    echo '
    <div class="text-center">
    <form action="" method="POST">
    <button type="submit" class="btn btn-primary" id="docusign_sign" name="docusign_sign" value="1">Click to Sign Document</button>
    </form>
    <div>
    ';
}

?>