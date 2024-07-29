<div class="d-flex align-items-center justify-content-between">
	<h6 class="mb-0"><strong><?php echo $text_bonus_edit; ?></strong></h6>
		<div class="pull-right">
			
			<a href="<?php echo $cancel; ?>" class="btn btn-danger btn-sm" title="" data-toggle="tooltip"  data-original-title="<?php echo $button_cancel; ?>"><i class="fa fa-reply"></i></a>
		</div>
</div>
<hr>

<ul class="nav nav-tabs" id="settingsTab" role="tablist"> 
	<li class="nav-item" role="presentation">
		<button class="nav-link active" id="tab-bonusrule-button" data-bs-toggle="tab" data-bs-target="#tab-bonusrule" type="button" role="tab" aria-controls="social" aria-selected="false">Bonus Rule</button>
	</li>
	<li class="nav-item" role="presentation">
		<button class="nav-link" id="tab-pointsrule-button" data-bs-toggle="tab" data-bs-target="#tab-pointsrule" type="button" role="tab" aria-controls="social" aria-selected="false">Points Rule</button>
	</li>
	<li class="nav-item" role="presentation">
		<button class="nav-link" id="tab-payroll-button" data-bs-toggle="tab" data-bs-target="#tab-payroll" type="button" role="tab" aria-controls="social" aria-selected="false">PayRoll</button>
	</li>
	
	<!--<li class="nav-item" role="presentation">
		<button class="nav-link" id="tab-bonusamount-button" data-bs-toggle="tab" data-bs-target="#tab-bonusamount" type="button" role="tab" aria-controls="social" aria-selected="false">Bonus Amount</button>
	</li>

	<li class="nav-item" role="presentation">
		<button class="nav-link" id="tab-bonustype-button" data-bs-toggle="tab" data-bs-target="#tab-bonustype" type="button" role="tab" aria-controls="social" aria-selected="false">Bonus Type</button>
	</li>
	<li class="nav-item" role="presentation">
		<button class="nav-link" id="tab-pointtype-button" data-bs-toggle="tab" data-bs-target="#tab-pointtype" type="button" role="tab" aria-controls="social" aria-selected="false">Point Type</button>
	</li>

	<li class="nav-item" role="presentation">
		<button class="nav-link" id="tab-pointruletype-button" data-bs-toggle="tab" data-bs-target="#tab-pointruletype" type="button" role="tab" aria-controls="social" aria-selected="false">Point Rule Type</button>
	</li>-->

	<li class="nav-item" role="presentation">
		<button class="nav-link" id="tab-shift-button" data-bs-toggle="tab" data-bs-target="#tab-shift" type="button" role="tab" aria-controls="social" aria-selected="false">Working Shift</button>
	</li>
	<li class="nav-item" role="presentation">
		<button class="nav-link" id="tab-payrolltype-button" data-bs-toggle="tab" data-bs-target="#tab-payrolltype" type="button" role="tab" aria-controls="social" aria-selected="false">Payroll Type</button>
	</li>
	
</ul>
<div id="settingsTabContent" class="tab-content">
	<div class="tab-pane bg-body-secondary p-3 fade show active" role="tabpanel" id="tab-bonusrule">
	
		<?php $this->load->view('bonustabs/bonusrule'); ?>

	</div>
	<div class="tab-pane bg-body-secondary p-3 fade " role="tabpanel" id="tab-pointsrule">
	
		<?php $this->load->view('bonustabs/pointsrule'); ?>

	</div>
	<div class="tab-pane bg-body-secondary p-3 fade" role="tabpanel" id="tab-payroll">
		<?php $this->load->view('bonustabs/payroll'); ?>
	</div>
	<div class="tab-pane bg-body-secondary p-3 fade " role="tabpanel" id="tab-bonusamount">
	
		<?php $this->load->view('bonustabs/bonusamount'); ?>

	</div>
	<div class="tab-pane bg-body-secondary p-3 fade " role="tabpanel" id="tab-bonustype">
	
		<?php $this->load->view('bonustabs/bonustype'); ?>

	</div>
	<div class="tab-pane bg-body-secondary p-3 fade " role="tabpanel" id="tab-pointtype">
	
		<?php $this->load->view('bonustabs/pointtype'); ?>

	</div>
	<div class="tab-pane bg-body-secondary p-3 fade " role="tabpanel" id="tab-pointruletype">
	
		<?php $this->load->view('bonustabs/pointruletype'); ?>

	</div>
	<div class="tab-pane bg-body-secondary p-3 fade " role="tabpanel" id="tab-shift">
	
		<?php $this->load->view('bonustabs/shift'); ?>

	</div>
	<div class="tab-pane bg-body-secondary p-3 fade " role="tabpanel" id="tab-payrolltype">
	
		<?php $this->load->view('bonustabs/payrolltype'); ?>

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

		$('table input[type="checkbox"]').on('change', function() {
		  var $row = $(this).closest('tr');
		  var $checkboxes = $row.find('input[type="checkbox"]');
		  var selectedCheckboxes = $checkboxes.filter(':checked');
		  var id = selectedCheckboxes.attr('id');
		  
		  if ($row.find('#'+id).is(':checked') && id == 'option1' ) {
		    $row.find('#option2').prop('disabled', true);
		  } else  {
		    $row.find('#option2').prop('disabled', false);
		  }

		  if ($row.find('#'+id).is(':checked') && id == 'option2' ) {
		    $row.find('#option1').prop('disabled', true);
		  } else  {
		    $row.find('#option1').prop('disabled', false);
		  }
		  if (selectedCheckboxes.length > 2) {
		    var firstChecked = selectedCheckboxes.first();
		    console.log(firstChecked.attr('value'));
		    firstChecked.prop('checked', true);
		    selectedCheckboxes.not(firstChecked).prop('checked', false);
		  }
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

function addeditmodal(url, bonustype){
	
	$.ajax({
        type: 'POST',
        url: url,
        dataType:'html',
        data: {bonustype: bonustype},
        error: function() {
        },
        success: function(data) {
            
            $('#adddetailsbody').html(data);
            $("#adddetails").modal('show');
            $("#adddetails").appendTo("body");
            
        }
    });
    return false;
}
function updatesetting(url, bonustype){
	var name = $("#name").val();
	var car_make = $("#car_make").val();
	var is_active = $("#is_active").val();
	var value = $("#value").val();
	var points_id = $("#points_id").val();
	
	$.ajax({
        type: 'POST',
        url: url,
        dataType:'html',
        data: {name: name, bonustype:bonustype, make_id : car_make, is_active:is_active, points_id:points_id,value:value},
        error: function() {
        },
        success: function(data) {
        	console.log(data);
        	data = JSON.parse(data);
        	
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
    $('#bonus_amount').DataTable();
    $('#all_bonus_type').DataTable();
    $('#point_rule').DataTable();
    $('#all_point_type').DataTable();
    $('#working_shift').DataTable();
   	$('#all_payroll').DataTable();
});

</script>
<?php js_end(); ?>