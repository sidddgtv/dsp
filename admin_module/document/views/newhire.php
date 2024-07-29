<div class="row">
<div class="col"><h5>New Hire Package</h5></div>
<div class="col-auto"><a class="btn btn-danger" href="COF_newhire.pdf"><i class="las la-file-pdf"></i> Download</a></div>
<div class="col-auto">

<?php 
if($is_read == 1){
    //read
    echo '<div class="text-success p-2"><i class="las la-check-double"></i> Read and Agreed</div>';
}else{
    echo '
    <form action="" method="POST">

    <button type="submit" id="btn_read" name="btn_read" value="1" class="btn btn-primary" onclick="return confirm(\'have you read the document?\') ? true : false;"><i class="las la-check-circle"></i> Click to Agree</button>

    </form>
    ';
}
?>



</div>
</div>

