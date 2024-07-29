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
<form action="" id="form-user" class="form-horizontal" enctype="multipart/form-data" method="post" accept-charset="utf-8">
    <div class="row mt-4 required">
        <label class="col-2 control-label" for="name">Vehicle ID</label>
        <div class="col-4">
            <input type="text" name="name" value="" class="form-control" id="name" placeholder="Vehicle ID">
        </div>
   
        <label class="col-2 control-label" for="email">VIN</label>
        <div class="col-4">
            <input type="text" name="email" value="" class="form-control" id="email" placeholder="VIN">
        </div>
    </div>
    <div class="row mt-4 required">
        <label class="col-2 control-label" for="name">Vehicle Name</label>
        <div class="col-4">
            <input type="text" name="name" value="" class="form-control" id="name" placeholder="Vehicle Name">
        </div>
   
        <label class="col-2 control-label" for="email">Make</label>
        <div class="col-4">
            <select name="activated" class="form-select select2" id="activated">
                <option value="1">Mercedes-Benz</option>
                <option value="0">Ram</option>
                <option value="0">Ford</option>
                <option value="0">Freightliner</option>
            </select>
        </div>
    </div>
    <div class="row mt-4 required">
        <label class="col-2 control-label" for="name">Model</label>
        <div class="col-4">
            <input type="text" name="name" value="" class="form-control" id="name" placeholder="Model">
        </div>
   
        <label class="col-2 control-label" for="email">Sub-Model</label>
        <div class="col-4">
            <input type="text" name="email" value="" class="form-control" id="email" placeholder="Sub-Model">
        </div>
    </div>
    <div class="row mt-4 required">
        <label class="col-2 control-label" for="name">Subcontractor Name</label>
        <div class="col-4">
            <input type="text" name="name" value="" class="form-control" id="name" placeholder="Subcontractor Name">
        </div>
   
        <label class="col-2 control-label" for="email">Vehicle Provider</label>
        <div class="col-4">
            <input type="text" name="email" value="" class="form-control" id="email" placeholder="Vehicle Provider">
        </div>
    </div>

    <div class="row mt-4 required">
        <label class="col-2 control-label" for="name">Vehicle Registration Type</label>
        <div class="col-4">
            <input type="text" name="name" value="" class="form-control" id="name" placeholder="Vehicle Registration Type">
        </div>
   
        <label class="col-2 control-label" for="email">Year</label>
        <div class="col-4">
            <select name="activated" class="form-select select2" id="activated">

                <?php for ($i=2023; $i>=1980 ; $i--) { 
                   
               ?>
            <option value="<?php echo $i ?>" > <?php echo $i; ?> </option>
            </option>
        <?php }?> 
            </select>
        </div>
    </div>
    <div class="row mt-4 required">
        <label class="col-2 control-label" for="activated">Type</label>
        <div class="col-4">
             <input type="text" name="name" value="" class="form-control" id="name" placeholder="Type">
        </div>
        <label class="col-2 control-label" for="activated">Ownership Type</label>
        <div class="col-4">
            <select name="ownershipType" class="form-select select2" id="activated">
                <option value="RENTAL">RENTAL</option>
                <option value="AMAZON_OWNED">AMAZON OWNED</option>
                <option value="AMAZON_LEASED">AMAZON LEASED</option>
            </select>
        </div>
    
    </div>
    <div class="row mt-4 required">
        <label class="col-2 control-label" for="name">Ownership Start Date</label>
        <div class="col-4">
            <input type="Date" name="name" value="" class="form-control" id="name" placeholder="Ownership Start Date">
        </div>
   
        <label class="col-2 control-label" for="email">Ownership End Date</label>
        <div class="col-4">
            <input type="Date" name="email" value="" class="form-control" id="email" placeholder="Ownership End Date">
        </div>
    </div>
     <!--  <div class="row mt-4 required">
        <hr>
        <h5>Status</h5>
      </div> -->
    <div class="row mt-4 required">
        <label class="col-2 control-label" for="activated">Status</label>
        <div class="col-4">
            <select name="activated" class="form-select select2" id="activated">
                <option value="1">Activated</option>
                <option value="0">Deactivated</option>
            </select>
        </div>
        <label class="col-2 control-label" for="activated">Status Reason Code</label>
        <div class="col-4">
            <select name="activated" class="form-select select2" id="activated">
                <option value="1">HEALTHY</option>
                <option value="0">Not HEALTHY</option>
            </select>
        </div>
    </div>
     <div class="row mt-4 required">
        
        <label class="col-2 control-label" for="password">Status Reason Message</label>
        <div class="col-4">
            <textarea name="password" value="" class="form-control" id="password" placeholder="Status Reason Message"></textarea>
        </div>
         <label class="col-2 control-label" for="activated">Status Search Value</label>
        <div class="col-4">
            <select name="activated" class="form-select select2" id="activated">
               <option value="1">Active</option>
                <option value="0">Deactivate</option>
            </select>
        </div>
    </div>
    <div class="row mt-4 required">
        <label class="col-2 control-label" for="activated">Status Priority</label>
        <div class="col-4">
              <input type="text" name="email" value="" class="form-control" id="email" placeholder="status Priority">
        </div>
        <label class="col-2 control-label" for="name">PM Stat</label>
        <div class="col-4">
            <input type="text" name="name" value="" class="form-control" id="name" placeholder="PM Stat">
        </div>
    </div>
   
     <div class="row mt-4 required">
        
   
        <label class="col-2 control-label" for="email">Registration Expiry Date</label>
        <div class="col-4">
            <input type="Date" name="email" value="" class="form-control" id="email" placeholder="Registration Expiry Date">
        </div>
         <label class="col-2 control-label" for="activated">registered State</label>
        <div class="col-4">
            <select name="activated" class="form-select select2" id="activated">
                <option value="1">Activated</option>
                <option value="0">Deactivated</option>
            </select>
        </div>
    </div>
    <div class="row mt-4 required">
       
        
        <label class="col-2 control-label" for="activated">registeredCountry</label>
        <div class="col-4">
            <select name="activated" class="form-select select2" id="activated">
                <option value="1">Activated</option>
                <option value="0">Deactivated</option>
            </select>
        </div>
         <label class="col-2 control-label" for="activated">Service Tier</label>
        <div class="col-4">
            <select name="activated" class="form-select select2" id="activated">
                <option value="EXTRA_LARGE_CARGO_VAN">EXTRA_LARGE_CARGO_VAN</option>
                <option value="LARGE_CARGO_VAN">LARGE_CARGO_VAN</option>
                <option value="STANDARD_CARGO_VAN">STANDARD_CARGO_VAN</option>
            </select>
        </div>
    </div>
    <div class="row mt-4 required">
       
        <label class="col-2 control-label" for="activated">Station Code</label>
        <div class="col-4">
               <input type="text" name="email" value="" class="form-control" id="email" placeholder="Station Code">
        </div>
          <label class="col-2 control-label" for="email">Image(s)</label>
        <div class="col-4">
            <input type="file" name="email" value="" class="form-control" id="email" placeholder="VIN">
        </div>
    </div>
    <div class="row mt-4 required">
      
    
        <label class="col-2 control-label" for="password">Notes</label>
        <div class="col-4">
            <textarea name="password" value="" class="form-control" id="password" placeholder="Notes"></textarea>
        </div>
    </div>
   
    <div class="row mt-2">
        <label class="col-2 control-label">&nbsp;</label>
        <div class="col-4">
            <button type="submit" form="form-user" data-toggle="tooltip" title="Save" class="btn btn-primary btn-sm">
                <i class="las la-save"></i> Save </button>
            <input type="hidden" id="user_edit_form" name="user_edit_form" value="1">
        </div>
    </div>
</form>