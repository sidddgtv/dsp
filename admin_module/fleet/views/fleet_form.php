<div class="d-flex align-items-center justify-content-between mb-4">
    <h6 class="mb-0">
        <strong>Fleet Management</strong>
    </h6>
    <div class="pull-right">
        <a href="
            <?php echo admin_url('fleet'); ?>" data-toggle="tooltip" title="Cancel" class="btn btn-danger btn-sm">
            <i class="fa fa-reply"></i>
        </a>
    </div>
</div>
<hr />
<!-- <form action="" id="form-user" class="form-horizontal" enctype="multipart/form-data" method="post" accept-charset="utf-8"> -->
    <?php echo form_open_multipart(null, 'id="form-fleet" class="form-horizontal"'); ?>
    <div class="row mt-4 ">
        <label class="col-2 control-label" for="vehicle_name">Vehicle ID</label>
        <div class="col-4">
            <input type="text" name="vehicle_name" value="<?php echo $vehicle_name; ?>" class="form-control" id="vehicle_name" placeholder="Vehicle ID">
            <?php echo form_error('vehicle_name', '<div class="text-danger">', '</div>'); ?>
        </div>
   
        <label class="col-2 control-label" for="vin">VIN</label>
        <div class="col-4">
            <input type="text" name="vin" value="<?php echo $vin; ?>" class="form-control" id="vin" placeholder="VIN">
            <?php echo form_error('vin', '<div class="text-danger">', '</div>'); ?>
        </div>
    </div>
    <div class="row mt-4 ">
        <label class="col-2 control-label" for="license_plate_number">License Plate Number</label>
        <div class="col-4">
            <input type="text" name="license_plate_number" value="<?php echo $license_plate_number; ?>" class="form-control" id="license_plate_number" placeholder="License Plate Number">
            <?php echo form_error('license_plate_number', '<div class="text-danger">', '</div>'); ?>
        </div>
   
        <label class="col-2 control-label" for="make">Make</label>
        <div class="col-4">
            <select name="make_id" class=" w-100 form-control select2" id="make_id">
                 <option value="" >-- select --</option>
                 <?php 

                 foreach ($car_makes as $val) { 
                   
                    echo '<option value="'.$val['id'].'"  '.($val['id'] == $make_id ? 'selected' : '').'>'.$val['name'].'</option>';
                   
                }?> 
            </select>
            <?php echo form_error('make_id', '<div class="text-danger">', '</div>'); ?>
        </div>
    </div>
    <div class="row mt-4 ">
        <label class="col-2 control-label" for="name">Model</label>
        <div class="col-4">

            <select name="model_id" class=" w-100 form-control select2" id="model_id">
                <option value="" selected="" hidden="">-- select --</option>
                <?php 

                    if($models){
                        foreach ($models as $val) { 
                       
                            echo '<option value="'.$val['id'].'"  '.($val['id'] == $model_id ? 'selected' : '').'>'.$val['name'].'</option>';
                       
                        }
                    }
                ?>
            </select>

            <?php echo form_error('model_id', '<div class="text-danger">', '</div>'); ?>
        </div>
   
        <label class="col-2 control-label" for="sub_model">Sub-Model</label>
        <div class="col-4">
            <input type="text" name="sub_model" value="<?php echo $sub_model; ?>" class="form-control" id="sub_model" placeholder="Sub-Model">

            <?php echo form_error('sub_model', '<div class="text-danger">', '</div>'); ?>
        </div>
    </div>
    <div class="row mt-4 ">
        <label class="col-2 control-label" for="subcontractor_name">Subcontractor Name</label>
        <div class="col-4">
            <input type="text" name="subcontractor_name" value="<?php echo $subcontractor_name; ?>" class="form-control" id="subcontractor_name" placeholder="Subcontractor Name">

            <?php echo form_error('subcontractor_name', '<div class="text-danger">', '</div>'); ?>
        </div>
   
        <label class="col-2 control-label" for="vehicle_provider">Vehicle Provider</label>
        <div class="col-4">
             <select name="vehicle_provider_id" class=" w-100 form-control select2" id="vehicle_provider_id">
                <option value="">-- select --</option>
                 <?php 
                    foreach ($vehicle_providers as $vehicle_provider) {
                        echo '<option value="'.$vehicle_provider['id'].'"  '.($vehicle_provider['id'] == $vehicle_provider_id ? 'selected' : '').'>'.$vehicle_provider['name'].'</option>';
                    }?> 
            </select>

            <?php echo form_error('vehicle_provider_id', '<div class="text-danger">', '</div>'); ?>
            <!-- <input type="text" name="email" value="" class="form-control" id="email" placeholder="Vehicle Provider"> -->
        </div>
    </div>

    <div class="row mt-4 ">
        <label class="col-2 control-label" for="vehicle_registration_type">Vehicle Registration Type</label>
        <div class="col-4">
             <select name="vehicle_registration_type" class="form-control select2" id="vehicle_registration_type">
                 <option value="" >-- select --</option>
                <option value="PERMANENT"  selected >PERMANENT</option>
            </select>
             <?php echo form_error('vehicle_registration_type', '<div class="text-danger">', '</div>'); ?>
        </div>
   
        <label class="col-2 control-label" for="year">Year</label>
        <div class="col-4 ">
            <select name="year" class=" w-100 form-control select2" id="year">

                <?php for ($i=2023; $i>=1960 ; $i--) { 
                   
               echo '<option value="'.$i.'"  '.($i== $year ? 'selected' : '').'>'.$i.'</option>'; }?> 
            </select>
             <?php echo form_error('year', '<div class="text-danger">', '</div>'); ?>
        </div>
    </div>
    <div class="row mt-4 ">
        
        <label class="col-2 control-label" for="ownership_type_id">Ownership Type</label>
        <div class="col-4">
            <select name="ownership_type_id" class=" w-100 form-control select2" id="ownership_type_id">
                <option value="">-- select --</option>
                <?php 
                    foreach ($ownership_types as $ownership_type) {
                        echo '<option value="'.$ownership_type['id'].'"  '.($ownership_type['id'] == $ownership_type_id ? 'selected' : '').'>'.$ownership_type['name'].'</option>';
                    }?> 

            </select>
              <?php echo form_error('ownership_type_id', '<div class="text-danger">', '</div>'); ?>
        </div>

        <label class="col-2 control-label" for="type">Type</label>
        <div class="col-4">
             <input type="text" name="type" value="<?php echo $type; ?>" class="form-control" id="type" placeholder="Type">
               <?php echo form_error('type', '<div class="text-danger">', '</div>'); ?>
        </div>
    
    </div>
    <div class="row mt-4 ">
        <label class="col-2 control-label" for="ownership_start_date">Ownership Start Date</label>
        <div class="col-4">
            <input type="Date" name="ownership_start_date" value="<?php echo $ownership_start_date; ?>" class="form-control " id="ownership_start_date" placeholder="Ownership Start Date">
              <?php echo form_error('ownership_start_date', '<div class="text-danger">', '</div>'); ?>
        </div>
   
        <label class="col-2 control-label" for="ownership_end_date">Ownership End Date</label>
        <div class="col-4">
            <input type="Date" name="ownership_end_date" value="<?php echo $ownership_end_date; ?>" class="form-control" id="ownership_end_date" placeholder="Ownership End Date">
              <?php echo form_error('ownership_end_date', '<div class="text-danger">', '</div>'); ?>
        </div>
    </div>
     <!--  <div class="row mt-4 ">
        <hr>
        <h5>Status</h5>
      </div> -->
    <div class="row mt-4 ">
        <label class="col-2 control-label" for="status">Status</label>
        <div class="col-4">
            <select name="status" class=" w-100 form-control select2" id="status">
                <option value="1" <?php if($status == 1) echo 'selected';?>>Active</option>
                <option value="" <?php if($status != 1) echo 'selected';?>>Inactive</option>
            </select>

              <?php echo form_error('status', '<div class="text-danger">', '</div>'); ?>
        </div>
        <label class="col-2 control-label" for="status_reason_code">Status Reason Code</label>
        <div class="col-4">
            <select name="status_reason_code" class=" w-100 form-control select2" id="status_reason_code">
                <option value="">-- select --</option>
                 <?php 
                    foreach ($status_reason_codes as $src) {
                        echo '<option value="'.$src['name'].'" '.($src['name'] == $status_reason_code ? 'selected' : '').'>'.$src['name'].'</option>';
                    }?> 
            </select>

              <?php echo form_error('status_reason_code', '<div class="text-danger">', '</div>'); ?>
        </div>
    </div>
     <div class="row mt-4 ">
        <label class="col-2 control-label" for="operational_status">Operational Status</label>
        <div class="col-4">
            <select name="operational_status" class=" w-100 form-control select2" id="operational_status">
                <option value="">-- select --</option>
                <option value="DAMAGED" <?php if($operational_status == 'DAMAGED') echo 'selected';?>>DAMAGED</option>
                <option value="INREPAIR" <?php if($operational_status == 'INREPAIR') echo 'selected';?>>IN REPAIR</option>
                <option value="OPERATIONAL" <?php if($operational_status == 'OPERATIONAL') echo 'selected';?>>OPERATIONAL</option>
            </select>

              <?php echo form_error('operational_status', '<div class="text-danger">', '</div>'); ?>
        </div>
        <label class="col-2 control-label" for="status_reason_message">Status Reason Message</label>
        <div class="col-4">
            <textarea name="status_reason_message" value="" class="form-control" id="status_reason_message" placeholder="Status Reason Message" col="1"><?php echo $status_reason_message; ?></textarea>
            <?php echo form_error('status_reason_message', '<div class="text-danger">', '</div>'); ?>
        </div>
         </div>
    <div class="row mt-4 ">
         <label class="col-2 control-label" for="status_search_value">Status Search Value</label>
        <div class="col-4">
            <select name="status_search_value" class=" w-100 form-control select2" id="status_search_value">
               <option value="1" <?php if($status_search_value == 1) echo 'selected';?>>Active</option>
                <option value="" <?php if($status_search_value != 1) echo 'selected';?>>Inactive</option>
            </select>
              <?php echo form_error('status_search_value', '<div class="text-danger">', '</div>'); ?>
        </div>
   
        <label class="col-2 control-label" for="status_priority">Status Priority</label>
        <div class="col-4">
              <input type="text" name="status_priority" value="<?php echo $status_priority; ?>" class="form-control" id="status_priority" placeholder="status Priority">

              <?php echo form_error('status_priority', '<div class="text-danger">', '</div>'); ?>
        </div>
        </div>
   
     <div class="row mt-4 ">
        
        <label class="col-2 control-label" for="pm_stat">PM Stat</label>
        <div class="col-4">
            <input type="text" name="pm_stat" value="<?php echo $pm_stat; ?>" class="form-control" id="pm_stat" placeholder="PM Stat">

              <?php echo form_error('pm_stat', '<div class="text-danger">', '</div>'); ?>
        </div>
    
   
        <label class="col-2 control-label" for="registration_expiry_date">Registration Expiry Date</label>
        <div class="col-4">
            <input type="Date" name="registration_expiry_date" value="<?php echo $registration_expiry_date; ?>" class="form-control" id="registration_expiry_date" placeholder="Registration Expiry Date">

              <?php echo form_error('registration_expiry_date', '<div class="text-danger">', '</div>'); ?>
        </div>
        </div>
   
     <div class="row mt-4 ">
        
         <label class="col-2 control-label" for="registered_state">registered State</label>
        <div class="col-4">
            <select name="registered_state_id" class=" w-100 form-control select2" id="registered_state_id">
                 <option value="" >-- select --</option>
                 <?php 

                 foreach ($countries['data'] as $val) { 
                   
            
                echo '<optgroup label="'.$val['name'].'">';
   
                    foreach ($val['states'] as $states) {
                        echo '<option value="'.$states['id'].'" '.($states['id'] == $registered_state_id ? 'selected' : '').'>'.$states['state_code'].'-'.$states['name'].'</option>';
                    }
                echo '</optgroup>';
                }?> 
            </select>

              <?php echo form_error('registered_state', '<div class="text-danger">', '</div>'); ?>
        </div>
    
       
    
         <label class="col-2 control-label" for="service_tier_id">Service Tier</label>
        <div class="col-4">
            <select name="service_tier_id" class="form-control select2" id="service_tier_id">
                 <option value="" >-- select --</option>
                <?php 
                    foreach ($service_tier as $service_t) {
                        echo '<option value="'.$service_t['id'].'" '.($service_t['id'] == $service_tier_id ? 'selected' : '').'>'.$service_t['name'].'</option>';
                    }?> 
            </select>

              <?php echo form_error('service_tier_id', '<div class="text-danger">', '</div>'); ?>
        </div>
   
       </div>
    <div class="row mt-4 ">
        <label class="col-2 control-label" for="station_code">Station Code</label>
        <div class="col-4">
               <!-- <input type="text" name="station_code" value="" class="form-control" id="station_code" placeholder="Station Code"> -->
                <select name="station_code" class="form-control select2" id="station_code">
                 <option value="" >-- select --</option>
                <option value="DIB6" selected>DIB6</option>
            </select>

              <?php echo form_error('station_code', '<div class="text-danger">', '</div>'); ?>
        </div>
         <label class="col-2 control-label" for="route_type_id">Route Type</label>
        <div class="col-4">
            <select name="route_type_id" class="form-control select2" id="route_type_id">
                 <option value="" >-- select --</option>
                <?php 
                    foreach ($route_types as $route_type) {
                        echo '<option value="'.$route_type['id'].'" '.($route_type['id'] == $route_type_id ? 'selected' : '').'>'.$route_type['name'].'</option>';
                    }?> 
            </select>

              <?php echo form_error('route_type_id', '<div class="text-danger">', '</div>'); ?>
        </div>
   
        
       
    </div>
    <div class="row mt-4 ">
         <label class="col-2 control-label" for="image">Image(s)</label>
        <div class="col-4">
            <input type="file" name="fleet_file" value="" class="form-control" id="fleet_file" placeholder="image" accept="image/*">

              <?php echo form_error('fleet_file', '<div class="text-danger">', '</div>'); ?>
        </div>
    
        <label class="col-2 control-label" for="notes">Notes</label>
        <div class="col-4">
            <textarea name="notes" value="" class="form-control" id="notes" placeholder="Notes"><?php echo $notes; ?></textarea>
            
              <?php echo form_error('notes', '<div class="text-danger">', '</div>'); ?>
        </div>
    </div>
   
    <div class="row mt-4 submit-btn">
        <label class="col-2 control-label">&nbsp;</label>
        <div class="col-4">
            <button type="submit" form="form-fleet" data-toggle="tooltip" title="Save" class="btn btn-primary btn-sm">
                <i class="las la-save"></i> Save </button>
            <input type="hidden" id="user_edit_form" name="user_edit_form" value="1">
        </div>
    </div>
<?php echo form_close(); ?>
<style type="text/css">
    .select2-container {
  width: 100% !important;
}
.select2-container .select2-selection {
  height: auto!important;
  padding: 5px 0;
}
.select2-container .select2-selection .select2-selection__rendered {
  line-height: normal!important;
}
.select2-container .select2-selection .select2-selection__rendered {
  white-space: normal!important;
}
</style>

<?php js_start(); ?>
<script type="text/javascript">

$(function () {
    var pathname = window.location.pathname;
     console.log(pathname);
    if(pathname.indexOf('view') != -1){
        $("#form-fleet :input").attr("disabled", true);
        $('.submit-btn').css('display', 'none');
    }
    $('.datetimepicker').datetimepicker();
    $(".select2").select2({
        width: 'resolve'
    });
    $('#ownership_end_date').change(function () {
       var message = 'Until '+$('#ownership_end_date').val()+'.';

       $('#status_reason_message').val(message)
    });
    $('#ownership_type_id').change(function () {
       var message = $('#ownership_type_id option:selected').text().replace(' ', '-' );
       message = message.replace(/\w\S*/g, function(word) {
            return word.charAt(0).toUpperCase() + word.substr(1).toLowerCase();
        });
       $('#type').val(message)
    });
     $('#make_id').change(function () {
       var id = $('#make_id').val();
       console.log(id)
       $.ajax({
        type: 'POST',
            url: "<?php echo admin_url('fleet/getmodels'); ?>",
        data: {'makes_id': id },
        dataType:'html',
        error: function() {
        },
        success: function(data) {
            $("#model_id").select2("val", "");
            $('#model_id').find('option')
                .remove()
                .end()
                .append(data);
            $("#model_id").val("").trigger("change"); 
        }
    });
    });
});

</script>
<?php js_end(); ?>
