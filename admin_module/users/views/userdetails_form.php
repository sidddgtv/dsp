<div class="d-flex align-items-center justify-content-between mb-4">
<h6 class="mb-0"><strong>Fleet Management</strong></h6>


<div class="pull-right">
  <a href="<?php echo admin_url('fleet'); ?>" data-toggle="tooltip" title="Cancel" class="btn btn-danger btn-sm"><i class="fa fa-reply"></i></a>
</div>
</div>

<hr/>

<form action="" id="form-user" class="form-horizontal" enctype="multipart/form-data" method="post" accept-charset="utf-8">
    <div class="row mt-4 required">
      <label class="col-2 control-label" for="name">Vehicle ID</label>
        <div class="col-10">
          <input type="text" name="name" value="" class="form-control" id="name" placeholder="Vehicle ID">
                  </div>
    </div>
    <div class="row mt-2 required">
      <label class="col-2 control-label" for="email">VIN</label>
        <div class="col-10">
          <input type="email" name="email" value="" class="form-control" id="email" placeholder="VIN">
                  </div>
    </div>


    <div class="row mt-2 required">
      <label class="col-2 control-label" for="email">Image(s)</label>
        <div class="col-10">
          <input type="file" name="email" value="" class="form-control" id="email" placeholder="VIN">
                  </div>
    </div>


    <div class="row mt-2 required">
      <label class="col-2 control-label" for="password">Notes</label>
        <div class="col-10">
          <textarea name="password" value="" class="form-control" id="password" placeholder="Notes"></textarea>
                  </div>
    </div>

    <!--<div class="row mt-2 required">
      <label class="col-2 control-label" for="template_file">Template</label>
      <div class="col-10">
              </div>
    </div>-->

    <div class="row mt-2 required">
      <label class="col-2 control-label" for="activated">Status</label>
      <div class="col-10">
        <select name="activated" class="form-select select2" id="activated">
<option value="1">Activated</option>
<option value="0">Deactivated</option>
</select>
      </div>
    </div>

    <div class="row mt-2">
      <label class="col-2 control-label">&nbsp;</label>
      <div class="col-10">
        <button type="submit" form="form-user" data-toggle="tooltip" title="Save" class="btn btn-primary btn-sm"><i class="las la-save"></i> Save</button>
        <input type="hidden" id="user_edit_form" name="user_edit_form" value="1">
      </div>
    </div>


    </form>

