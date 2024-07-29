<div class="d-flex align-items-center justify-content-between">
    <h6 class="mb-0"><strong><?php echo $heading_title; ?> : <?php echo $user[0]->name; ?></strong></h6>
    <div class="100w- text-end">
        
        <a href="" data-toggle="tooltip" title="Add" class="btn btn-success btn-sm" id="add_details" data-id="<?php echo $user[0]->id; ?>"><i class="las la-plus-circle"></i> Add </a>
        <a href="" data-toggle="tooltip" title="Upload" class="btn btn-primary btn-sm" id="upload_details"><i class="las la-plus-circle"></i> Upload </a>
        <a href="<?php echo admin_url('users'); ?>" data-toggle="tooltip" title="Cancel" class="btn btn-danger btn-sm"><i class="fa fa-reply"></i> Back</a>
    </div>
</div>
<hr>

<div class="table-responsive">
    <table id="datatable" class="table" width="100%">
        <thead>
            <tr class="fw-bold">
                <td>#</td>
                <td>Date</td>
                <td>Wave</td>
                <td>Route</td>
                <td>Staging Zone</td>
                <td>Van</td>
                <td>Route Type</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Nov 11, 2023</td>
                <td>Res</td>
                <td>Res</td>
                <td>-</td>
                <td>4</td>
                <td>CDV</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Nov 10, 2023</td>
                <td>2</td>
                <td>CX215</td>
                <td>STG.J.12</td>
                <td>39</td>
                <td>XL</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Nov 09, 2023</td>
                <td>5</td>
                <td>CX221</td>
                <td>STG.K.14</td>
                <td>231722</td>
                <td>Step</td>
            </tr>
            <tr>
                <td>4</td>
                <td>Nov 08, 2023</td>
                <td>2</td>
                <td>CX173</td>
                <td>STG.J.1</td>
                <td>30</td>
                <td>Large</td>
            </tr>
        </tbody>
    </table>
</div>


<!-- Modal -->
<div class="modal" tabindex="-1" id="adddetailsform">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add</h5>
        <button type="button" class="btn btn-none" data-bs-dismiss="modal" aria-label="Close"><i class="las la-times-circle"></i></button>
      </div>
      <div class="modal-body" id="adddetailsbody">
      </div>
    </div>
  </div>
</div>  

<!-- Modal -->
<div class="modal" tabindex="-1" id="uploaddetailsform">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Browse File</h5>
        <button type="button" class="btn btn-none" data-bs-dismiss="modal" aria-label="Close"><i class="las la-times-circle"></i></button>
      </div>
      <div class="modal-body" id="uploaddetailsbody">
      </div>
    </div>
  </div>
</div>  
<?php js_start(); ?>
<script type="text/javascript"><!--
$(function(){
    $('#datatable').DataTable();
});

$('body').on('click',"#add_details" ,function(event) {
        var id = $(this).data("id");
        console.log("id");
        $.ajax({
                type: 'POST',
                url: "<?php echo admin_url() . 'users/updatedetails/'.$user[0]->id; ?>",
                data: {'id': id},
                dataType:'html',
                error: function() {
                },
                success: function(data) {
                    $('#adddetailsbody').html(data);
                    $("#adddetailsform").modal('show');
                    $("#adddetailsform").appendTo("body");
                }
        });
        return false;
    });

$('body').on('click',"#upload_details" ,function(event) {
        var id = $(this).data("id");
        console.log("id");
        $.ajax({
                type: 'POST',
                url: "<?php echo admin_url() . 'users/uploaddetails/'; ?>",
                data: {'id': id},
                dataType:'html',
                error: function() {
                },
                success: function(data) {
                    $('#uploaddetailsbody').html(data);
                    $("#uploaddetailsform").modal('show');
                    $("#uploaddetailsform").appendTo("body");
                }
        });
        return false;
    });
//--></script>
<?php js_end(); ?>