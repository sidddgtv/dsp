<div class="d-flex align-items-center justify-content-between">
    <h6 class="mb-0"><strong><?php echo $heading_title; ?> : <?php echo $fleet[0]->vehicle_name; ?></strong></h6>
    <div class="100w- text-end">
        
        <a href="<?php echo admin_url('fleet'); ?>" data-toggle="tooltip" title="Cancel" class="btn btn-danger btn-sm"><i class="fa fa-reply"></i></a>
    </div>
</div>
<hr>

<div class="table-responsive">
    <table id="datatable" class="table" width="100%">
        <thead>
            <tr class="fw-bold">
                <td>#</td>
                <td>Driver Name</td>
                <td>Issued On</td>
                <td>Returned On</td>
                <td width="40%">Notes</td>
            </tr>
        </thead>
        <tbody>
           <?php 
           if(!empty($history)){
                foreach ($history as $key => $value): ?>
                <tr class="">
                    <td><?= $key +1 ?></td>
                    <td><?= $value->driver ?></td>
                    <td><?php if(!empty($value->issued_at)){ echo date('D M j, Y G:i:s ', strtotime($value->issued_at)); }?></td>
                    <td><?php if(!empty($value->issued_at)){ echo date('D M j, Y G:i:s ', strtotime($value->retured_at)); }?></td>
                    <td><?= $value->notes ?></td>
                </tr>
            <?php endforeach;
            } ?>
           
        </tbody>
    </table>
</div>
 
<?php js_start(); ?>
<script type="text/javascript"><!--
$(function(){
    $('#datatable').DataTable();
});

//--></script>
<?php js_end(); ?>