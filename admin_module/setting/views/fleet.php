<div class="d-flex align-items-center justify-content-between">
	<h6 class="mb-0"><strong><?php echo $text_fleet_edit; ?></strong></h6>
		<div class="pull-right">
			
			<a href="<?php echo $cancel; ?>" class="btn btn-danger btn-sm" title="" data-toggle="tooltip"  data-original-title="<?php echo $button_cancel; ?>"><i class="fa fa-reply"></i></a>
		</div>
</div>
<hr>

<ul class="nav nav-tabs" id="settingsTab" role="tablist"> 
	<li class="nav-item" role="presentation">
		<button class="nav-link active" id="tab-routetype-button" data-bs-toggle="tab" data-bs-target="#tab-routetype" type="button" role="tab" aria-controls="social" aria-selected="false">Route Type</button>
	</li>
	<li class="nav-item" role="presentation">
		<button class="nav-link" id="tab-vehicleproviders-button" data-bs-toggle="tab" data-bs-target="#tab-vehicleproviders" type="button" role="tab" aria-controls="social" aria-selected="false">Vehicle Provider</button>
	</li>
	<li class="nav-item" role="presentation">
		<button class="nav-link" id="tab-ownershiptype-button" data-bs-toggle="tab" data-bs-target="#tab-ownershiptype" type="button" role="tab" aria-controls="social" aria-selected="false">Ownership Type</button>
	</li>
	<li class="nav-item" role="presentation">
		<button class="nav-link" id="tab-servicetier-button" data-bs-toggle="tab" data-bs-target="#tab-servicetier" type="button" role="tab" aria-controls="social" aria-selected="false">Service Tier</button>
	</li>
	<li class="nav-item" role="presentation">
		<button class="nav-link" id="tab-statusreasoncodes-button" data-bs-toggle="tab" data-bs-target="#tab-statusreasoncodes" type="button" role="tab" aria-controls="social" aria-selected="false">Status Reason Codes</button>
	</li>
	<li class="nav-item" role="presentation">
		<button class="nav-link" id="tab-carmakes-button" data-bs-toggle="tab" data-bs-target="#tab-carmakes" type="button" role="tab" aria-controls="social" aria-selected="false">Car Makes</button>
	</li>

	<li class="nav-item" role="presentation">
		<button class="nav-link" id="tab-carmodels-button" data-bs-toggle="tab" data-bs-target="#tab-carmodels" type="button" role="tab" aria-controls="social" aria-selected="false">Car Models</button>
	</li>
</ul>
<div id="settingsTabContent" class="tab-content">
	<div class="tab-pane bg-body-secondary p-3 fade show active" role="tabpanel" id="tab-routetype">
	
		<?php $this->load->view('fleettabs/routetype'); ?>

	</div>
		
	<div class="tab-pane bg-body-secondary p-3 fade" role="tabpanel" id="tab-vehicleproviders">
	
		<?php $this->load->view('fleettabs/vehicleproviders'); ?>

	</div>

	<div class="tab-pane bg-body-secondary p-3 fade" role="tabpanel" id="tab-ownershiptype">
	
		<?php $this->load->view('fleettabs/ownershiptype'); ?>

	</div>
		
	<div class="tab-pane bg-body-secondary p-3 fade" role="tabpanel" id="tab-servicetier">
	
		<?php $this->load->view('fleettabs/servicetier'); ?>

	</div>

	<div class="tab-pane bg-body-secondary p-3 fade" role="tabpanel" id="tab-statusreasoncodes">
	
		<?php $this->load->view('fleettabs/statusreasoncodes'); ?>

	</div>
		
	<div class="tab-pane bg-body-secondary p-3 fade" role="tabpanel" id="tab-carmakes">
	
		<?php $this->load->view('fleettabs/carmakes'); ?>

	</div>

	<div class="tab-pane bg-body-secondary p-3 fade" role="tabpanel" id="tab-carmodels">
	
		<?php $this->load->view('fleettabs/carmodels'); ?>

	</div>
</div>
<!-- Modal -->
<div class="modal" id="adddetails" aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow:hidden;">
<!-- <div class="modal" id="adddetails"  role="dialog" aria-labelledby="myModalLabel"> -->
  <div class="modal-dialog modal-lg">
    <div class="modal-content" id="adddetailsbody" >
      
    </div>
  </div>
</div>
<!-- Modal -->

<?php js_start(); ?>
<script type="text/javascript"><!--
    $(document).ready(function() {

		$('textarea.ckeditor_textarea').each(function(index) {
			
			ckeditor_config.height = $(this).height();
			
			CKEDITOR.replace($(this).attr('name'), ckeditor_config); 
		});
		$('textarea.ckeditor_textarea2').each(function(index) {
			
			ckeditor_config.height = $(this).height();
			
			CKEDITOR.replace($(this).attr('name'), ckeditor_config); 
		});

		$('textarea.ckeditor_textarea3').each(function(index) {
			
			ckeditor_config.height = $(this).height();
			
			CKEDITOR.replace($(this).attr('name'), ckeditor_config); 
		});
    });
	
	function image_upload(field, thumb) {
		window.KCFinder = {
			callBack: function(url) {
				
				window.KCFinder = null;
				var lastSlash = url.lastIndexOf("uploads/");
				
				var fileName=url.substring(lastSlash+8);
				url=url.replace("images", ".thumbs/images"); 
				$('#'+thumb).attr('src', url);
				$('#'+field).attr('value', fileName);
				$.colorbox.close();
			}
		};
		$.colorbox({href:BASE_URL+"storage/plugins/kcfinder/browse.php?type=images",width:"850px", height:"550px", iframe:true,title:"Image Manager"});	
	};

function addeditmodal(url, fleettype){
	
	$.ajax({
        type: 'POST',
        url: url,
        dataType:'html',
        data: {fleettype: fleettype},
        error: function() {
        },
        success: function(data) {
            
            $('#adddetailsbody').html(data);
            $("#adddetails").modal('show');
            $("#adddetails").appendTo("body");
            
			// $("#car_make").select2({    				
			// 	dropdownParent: $("#adddetails #adddetailsbody")
			// });
            
            
        }
    });
    return false;
}
function updatesetting(url, fleettype){
	 var name = $("#type").val();
	  var car_make = $("#car_make").val();
	var is_active = $("#is_active").val();
	
	$.ajax({
        type: 'POST',
        url: url,
        dataType:'html',
        data: {name: name, fleettype:fleettype, make_id : car_make, is_active:is_active},
        error: function() {
        },
        success: function(data) {
        	data = JSON.parse(data);
        	console.log(data);
			if(data.status){
				window.location.reload();
			} else {
				$('#imageinfobody #error').remove();
				var html = '<div role="alert" class="alert alert-danger text-white alert-dismissible fade show" id="error">'+
				'<i class="fa fa-exclamation-circle"></i>&nbsp; ' + data.message + ' <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">'+
				'<i class="las la-times"></i></button>	</div>';
				
				$("#imageinfobody").prepend(html);
			}
			
            
        }
    });
    return false;
}
//--></script>
<script type="text/javascript"><!--
$(function(){
    $('#vehicle_providers').DataTable();
    $('#datatable').DataTable();
    $('#statusreasoncodes').DataTable();
    $('#carmakes').DataTable();
    $('#ownershiptype').DataTable();
    $('#servicetier').DataTable();
    $('#carmodels').DataTable();

   
});

</script>
<?php js_end(); ?>