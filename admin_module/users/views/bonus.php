<div class="row g-1">
	<div class="col"><h6 class="mb-0"><strong>Bonus Summary</strong></h6></div>
	<div class="col-auto fw-bold fs-5 my-auto pe-4">Bonus: $<?php echo $bonus_amount['bonus'];echo ($bonus_amount['tier'] > 0 ? '/ Tier: '.$bonus_amount['tier'].'&nbsp;<i class="las la-info-circle" data-bs-toggle="modal" data-bs-target="#bonusModal" style="cursor:pointer"></i>' : ''); ?></div>

	<!--<div class="col-auto"><a href="#" class="btn btn-sm btn-primary btn-sm"><i class="las la-save"></i> Save</a></div>-->
	<div class="col-auto"><a href="<?php echo admin_url('users/scorecards'); ?>" class="btn btn-sm btn-danger btn-sm"><i class="las la-chevron-circle-left"></i> Back</a></div>
	

	
</div>


<hr>

<?php //print_r($scorecard_data); ?>

<div class="row g-2">

<div class="col-6">

<div class="card bg-light">
  <div class="card-body">
	<h4><?php echo $driver_data['name']; ?></h4>
	<p class="text-muted mb-0">TNTL</p>
	<p class="mb-0">Week <?php echo $scorecard_data['week_number']; ?></p>
	Deliveries: <?php echo $scorecard_data['delivered_packages']; ?>
  </div>
</div>

</div>

<?php 
$card_color = '';

switch($scorecard_data['overall_standing']){
	case 'Fantastic':
		$card_color = 'bg-dark';
		break;
	case 'Great':
		$card_color = 'bg-success';
		break;
	case 'Fair':
		$card_color = 'bg-warning';
		break;
	case 'Poor':
		$card_color = 'bg-danger';
		break;
}

?>
<div class="col">

<div class="card <?php echo $card_color; ?> text-white">
  <div class="card-body text-center">
	<i class="las la-3x la-chart-area"></i>
	<h3><?php echo $scorecard_data['overall_standing']; ?></h3>
	<p class="mb-0">Overall Tier</p>
  </div>
</div>


</div>
<div class="col">

<div class="card <?php echo $card_color; ?> text-white">
  <div class="card-body text-center">
	<i class="las la-3x la-trophy"></i>
	<h3><?php echo $scorecard_data['ranking']; ?></h3>
	<p class="mb-0">Ranking</p>
  </div>
</div>


</div>


</div><!--row ends-->


<div class="mt-2 row g-2">

<div class="col m-0">

<div class="row g-2">

<div class="col-12">
<div class="card">
  <div class="card-header">
  	
		<div class="d-flex align-items-center justify-content-between">
			<div><i class="las la-shield-alt"></i> Driving Safety</div>
			
		</div>
  </div>
  <div class="card-body">
    <!--<p class="card-text">Looks like you don't have any driving safety events.<br/>Keep up the great work!</p>-->
	<table class="table table-sm small">

	<tr><th>FICO</th><td class="text-end"><?php echo $scorecard_data['fico']; ?></td></tr>
	<tr><th>Acceleration</th><td class="text-end"><?php echo $scorecard_data['acceleration']; ?></td></tr>
	<tr><th>Braking</th><td class="text-end"><?php echo $scorecard_data['braking']; ?></td></tr>
	<tr><th>Cornering</th><td class="text-end"><?php echo $scorecard_data['cornering']; ?></td></tr>
	<tr><th>Distraction</th><td class="text-end"><?php echo $scorecard_data['distraction']; ?></td></tr>
	<tr><th>Seatbelt-Off Rate</th><td class="text-end"><?php echo $scorecard_data['seatbelt_off_rate']; ?></td></tr>

	<tr><th>Speeding</th><td class="text-end"><?php echo $scorecard_data['speeding']; ?></td></tr>
	<tr><th>Speeding Event Rate</th><td class="text-end"><?php echo $scorecard_data['speeding_event_rate']; ?></td></tr>
	<tr><th>Distractions Rate</th><td class="text-end"><?php echo $scorecard_data['distractions_rate']; ?></td></tr>
	<tr><th>Looking at Phone</th><td class="text-end"><?php echo $scorecard_data['looking_at_phone']; ?></td></tr>
	<tr><th>Talking on Phone</th><td class="text-end"><?php echo $scorecard_data['talking_on_phone']; ?></td></tr>
	<tr><th>Looking Down</th><td class="text-end"><?php echo $scorecard_data['looking_down']; ?></td></tr>
	<tr><th>Following Distance Rate</th><td class="text-end"><?php echo $scorecard_data['following_distance_rate']; ?></td></tr>

	<tr><th>Sign/ Signal Violations Rate</th><td class="text-end"><?php echo $scorecard_data['sign_signal_violations_rate']; ?></td></tr>
	<tr><th>Stop Sign Violations</th><td class="text-end"><?php echo $scorecard_data['stop_sign_violations']; ?></td></tr>
	<tr><th>Stop Light Violations</th><td class="text-end"><?php echo $scorecard_data['stop_light_violations']; ?></td></tr>
	<tr><th>Illegal U-Turns</th><td class="text-end"><?php echo $scorecard_data['illegal_u_turns']; ?></td></tr>

	</table>
  </div>
</div>
</div>
<div class="col-12">
<div class="card">
  <div class="card-header">
  
  <div class="d-flex align-items-center justify-content-between">
  	<div><i class="las la-check-square"></i> Delivery Quality</div>
	
  </div>

  </div>
  <div class="card-body">
	<table class="table table-sm small">
	<tr><th>Completion Rate</th><td class="text-end">-</td><!-- <td class="d-flex justify-content-center mt-2"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked"></div></td>--></tr>
	<tr><th>Photo-On-Delivery Compliance</th><td class="text-end">-</td><!-- <td class="d-flex justify-content-center mt-2"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked"></div></td>--></tr>
	<tr><th>Photo-On-Delivery Rejects</th><td class="text-end">-</td><!-- <td class="d-flex justify-content-center mt-2"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked"></div></td>--></tr>
	<tr><th>Human in Photo</th><td class="text-end">-</td><!-- <td class="d-flex justify-content-center mt-2"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked"></div></td>--></tr>
	<tr><th>Contact Compliance</th><td class="text-end">-</td><!-- <td class="d-flex justify-content-center mt-2"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked"></div></td>--></tr>
	</table>
  </div>
</div>
</div>

<div class="col-12">
<div class="card">
  <div class="card-header">
  <i class="las la-chart-line"></i> Productivity
  </div>
  <div class="card-body">
    <p class="card-text">Weekly productivity results.</p>
  </div>
</div>
</div>



</div><!--inenr row ends left side for 2 cards-->

</div>
<div class="col mt-0">

<div class="card">
  <div class="card-header">
  <div class="d-flex align-items-center justify-content-between">
  	<div><i class="las la-grin"></i> Customer Feedback</div>
	<!-- <div class="form-check form-switch">
		<input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked">
	</div>
 -->  </div>
	

  </div>
  <div class="card-body">

  <?php 
	//echo '<pre>';
	//print_r($bonus_data);
  ?>


	<table class="table table-sm small">
	<tr><th>Feedback Score (CDF)</th><td class="text-end"><?php echo (floatval($scorecard_data['cdf'])*100); ?>%</td><!-- <td class="d-flex justify-content-center mt-2"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked"></div></td>--></tr>
	<tr><th>Tier</th><td class="text-end"><?php echo $scorecard_data['overall_standing']; ?></td><!-- <td class="d-flex justify-content-center mt-2"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked"></div></td>--></tr>
	
	<tr><th>DCR</th><td class="text-end"><?php echo $scorecard_data['dcr']; ?></td>
	<tr><th>DSB</th><td class="text-end"><?php echo $scorecard_data['dsb']; ?></td>
	<tr><th>SWC POD</th><td class="text-end"><?php echo (floatval($scorecard_data['swc_pod'])*100); ?>%</td>
	<tr><th>SWC CC</th><td class="text-end"><?php echo (floatval($scorecard_data['swc_cc'])*100); ?>%</td>
	<tr><th>SWC AD</th><td class="text-end"><?php echo (floatval($scorecard_data['swc_ad'])*100); ?>%</td>

	<tr><th>DNRS</th><td class="text-end"><?php echo $scorecard_data['dnrs']; ?></td>
	<tr><th>Shipments Zone Hour</th><td class="text-end"><?php echo $scorecard_data['shipments_zone_hour']; ?></td>

	<tr><th>POD OPPS</th><td class="text-end"><?php echo $scorecard_data['pod_opps']; ?></td>
	<tr><th>CC OPPS</th><td class="text-end"><?php echo $scorecard_data['cc_opps']; ?></td>
	<tr><th>Customer Escalation Defect</th><td class="text-end"><?php echo $scorecard_data['customer_escalation_defect']; ?></td>
	<tr><th>Customer Delivery Feedback</th><td class="text-end"><?php echo $scorecard_data['customer_delivery_feedback']; ?></td>
	<?php /*
	<tr><th>Alexa Thank-My-Driver</th><td class="text-end">-</td><!-- <td class="d-flex justify-content-center mt-2"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked"></div></td>--></tr>
	<tr><th>No Feedback</th><td class="text-end">1,079</td><!-- <td class="d-flex justify-content-center mt-2"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked"></div></td>--></tr>

	<tr><th colspan="2">Negative Feedback<br/>No Negative Feedback - Excellent!</td><!-- <td class="d-flex justify-content-center mt-2"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked"></div></td>--></tr>
	<tr><th colspan="2">Positive Feedback</td><!-- <td class="d-flex justify-content-center mt-2"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked"></div></td>--></tr>

	<tr><th>Delivery was Great!</th><td class="text-end">22</td><!-- <td class="d-flex justify-content-center mt-2"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked"></div></td>--></tr>
	<tr><th>Delivered with Care</th><td class="text-end">21</td><!-- <td class="d-flex justify-content-center mt-2"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked"></div></td>--></tr>
	<tr><th>Respectful of Property</th><td class="text-end">13</td><!-- <td class="d-flex justify-content-center mt-2"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked"></div></td>--></tr>
	<tr><th>Above &amp Beyond</th><td class="text-end">13</td><!-- <td class="d-flex justify-content-center mt-2"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked"></div></td>--></tr>
	<tr><th>Followed Instructions</th><td class="text-end">11</td><!-- <td class="d-flex justify-content-center mt-2"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked"></div></td>--></tr>
	<tr><th>Friendly</th><td class="text-end">10</td><!-- <td class="d-flex justify-content-center mt-2"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked"></div></td>--></tr>

	*/ ?>

	</table>




  </div>
</div>

</div>



</div><!--row ends-->










<?php js_start(); ?>
<script type="text/javascript"><!--
$(function(){
	$('#datatable').DataTable();
});
//--></script>
<?php js_end(); ?>