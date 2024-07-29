<?php 
if(array_key_exists('message', $_SESSION)){
	echo $_SESSION['message'];
	unset($_SESSION['message']);
}
?>
<div class="d-flex align-items-center justify-content-between">
<h6 class="mb-0"><strong>Scorecards</strong></h6>
<div class="fw-bold">
<button type="button" onclick="updateWeek(-1)" class="btn btn-none btn-sm text-dark"><i class="las la-chevron-circle-left la-2x" style="vertical-align: bottom;"></i></button>
<span id="week_text" class="ms-2 me-3 fs-6">Week <?php echo $currentWeek.', '.$currentYear; ?></span>
<button type="button" onclick="updateWeek(1)" class="btn btn-none btn-sm text-dark"><i class="las la-chevron-circle-right la-2x" style="vertical-align: bottom;"></i></button>
<input type="hidden" id="week_number" value="<?php echo $currentWeek; ?>" />
<input type="hidden" id="year_number" value="<?php echo $currentYear; ?>" />
</div>
<!--<div class="pull-right">
	<a href="#" class="btn btn-sm btn-success btn-sm">
	<i class="las la-filter"></i> Filter
	</a>
</div>-->
<div class=" text-end">

	<!-- Button trigger modal -->
	<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#uploadscorecardModal">
		<i class="las la-plus-circle"></i> Upload
	</button>
        
</div>


</div>

<hr>



<div id="scorecard_table" class="table-responsive">

</div>

<div class="table-responsive d-none">
<table id="datatable" class="table" width="100%">
<thead>
<tr class="fw-bold"><td>#</td><td>Name</td><td>Deliveries</td><td>Ranking</td><td>Overall Tier</td><td width="80px">Download</td></tr>
</thead>
<tbody>
<tr><td>1</td><td>Shawniki Lynette Taylor</td><td>1040</td><td>1</td><td>
<div class="progress">
 <div class="progress-bar progress-bar-striped bg-danger" style="width: 100%">POOR</div>
</div>	

</td><td class="text-center">
<button type="button" class="btn btn-sm btn-outline-dark" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="las la-eye"></i></button>
<a class="btn btn-sm btn-outline-dark" href="#"><i class="las la-arrow-circle-down"></i></a></td></tr>
<tr><td>2</td><td>Anthony Michael Reed</td><td>978</td><td>2</td><td>

<div class="progress">
 <div class="progress-bar progress-bar-striped bg-warning" style="width: 100%">FAIR</div>
</div>
</td><td class="text-center">
<button type="button" class="btn btn-sm btn-outline-dark" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="las la-eye"></i></button>
<a class="btn btn-sm btn-outline-dark" href="#"><i class="las la-arrow-circle-down"></i></a></td></tr>
<tr><td>3</td><td>Marco Antonio Serna</td><td>345</td><td>3</td><td>
<div class="progress">
 <div class="progress-bar progress-bar-striped bg-success" style="width: 100%">GREAT</div>
</div>
</td><td class="text-center">
<button type="button" class="btn btn-sm btn-outline-dark" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="las la-eye"></i></button>
<a class="btn btn-sm btn-outline-dark" href="#"><i class="las la-arrow-circle-down"></i></a></td></tr>
<tr><td>4</td><td>Nicholas Ryan Hogue</td><td>445</td><td>4</td><td>
<div class="progress">
 <div class="progress-bar progress-bar-striped bg-danger" style="width: 100%">POOR</div>
</div>
</td><td class="text-center">
<button type="button" class="btn btn-sm btn-outline-dark" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="las la-eye"></i></button>
<a class="btn btn-sm btn-outline-dark" href="#"><i class="las la-arrow-circle-down"></i></a></td></tr>
<tr><td>5</td><td>Andrew David Renteria</td><td>991</td><td>5</td><td>
<div class="progress">
 <div class="progress-bar progress-bar-striped bg-warning" style="width: 100%">FAIR</div>
</div>
</td><td class="text-center">
<button type="button" class="btn btn-sm btn-outline-dark" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="las la-eye"></i></button>
<a class="btn btn-sm btn-outline-dark" href="#"><i class="las la-arrow-circle-down"></i></a></td></tr>









































</tbody>
</table>
</div>










<?php js_start(); ?>
<script type="text/javascript">
$(function(){
	loadSchedule(<?php echo $currentWeek; ?>, <?php echo $currentYear; ?>);
	
});

function updateWeek(direction){
	// Example Usage
	let currentYear = $('#year_number').val();
	let currentWeek = $('#week_number').val();
	let increment = direction; // -1 for previous week, 1 for next week

	let newDate = adjustWeek(currentYear, currentWeek, increment);
	//alert(`New Year: ${newDate.year}, New Week: ${newDate.week}`);
	loadSchedule(newDate.week, newDate.year);
    //alert(newDate.week);
	//update hidden fields
	$('#year_number').val(newDate.year);
	$('#week_number').val(newDate.week);
	//update week text
	$('#week_text').html('Week '+newDate.week+', '+newDate.year);
}

function loadSchedule(week, year){
	$.ajax({
        type: 'POST',
        url: "<?php echo admin_url() . 'users/loadscorecardtable'; ?>",
        data: {'week': week, 'year': year},
        dataType:'html',
        error: function() {
        },
        success: function(data) {
			$('#scorecard_table').html(data);
			$('#datatable').dataTable( {
            "pageLength": 50
            } );
            /*console.log(data);
            
            $("#imageinfo").modal('show');
            $("#imageinfo").appendTo("body");*/
        }
    });
}

function adjustWeek(year, week, increment) {
    // Calculate the first day of the given week
    /*let date = new Date(year, 0, 1 + (week - 1) * 7);

    // Adjust for first day of the year not being a Monday
    let dayCorrection = date.getDay() - 1;
    if (dayCorrection == -1) dayCorrection = 6;
    date.setDate(date.getDate() - dayCorrection);

    // Increment or decrement the week
    date.setDate(date.getDate() + increment * 7);

    // Recalculate the new week number and year
    let newYear = date.getFullYear();
    let firstJan = new Date(newYear, 0, 1);
    let newWeek = week;
    if(increment == '-1'){
        newWeek = parseInt(week) - 1;
    }else{
        newWeek = parseInt(week) + 1;
    }
    //let newWeek = Math.ceil((((date - firstJan) / 86400000) + firstJan.getDay() + 1) / 7);
    //alert(newWeek);

    // Handle year wrapping
    if (newWeek <= 0) {
        // Adjust for the previous year
        //newYear--;
        let lastJan = new Date(newYear, 0, 1);
        let lastDec = new Date(newYear, 11, 31);
        newWeek = Math.ceil((((lastDec - lastJan) / 86400000) + lastJan.getDay() + 1) / 7);
    } else if (newWeek > 52) {
        // Check if the year actually has 53 weeks
        let dec31 = new Date(newYear, 11, 31);
        if (dec31.getDay() != 4 && (dec31.getDay() != 3 || !isLeapYear(newYear))) {

            newWeek = 1;
            newYear = dec31.getFullYear();
            //newYear++;
        }
    }*/

    //alert(week);

    let newWeek = 0;
	let newYear = parseInt(year);

	if(increment == '-1'){
        //check week
		if(parseInt(week) == 1){
			newWeek = 52;
			newYear = parseInt(year) - 1;
		}else{
			newWeek = parseInt(week) - 1;
		}
    }else{
        //check week
		if(parseInt(week) == 52){
			newWeek = 1;
			newYear = parseInt(year) + 1;
		}else{
			newWeek = parseInt(week) + 1;
		}
    }

    return { year: newYear, week: newWeek };
}

// Helper function to check for leap year
function isLeapYear(year) {
    return ((year % 4 === 0 && year % 100 !== 0) || year % 400 === 0);
}

function loadscorecardmodal(driver_id, week, year, scorecard_id){
	
	$.ajax({
        type: 'POST',
        url: "<?php echo admin_url() . 'users/loadscorecardmodalbody'; ?>",
        data: {'driver_id': driver_id, 'week': week, 'year': year},
        dataType:'html',
        error: function() {
        },
        success: function(data) {
			$('#scorecard_modal_body').html(data);
            //set hidden fields also
            $('#sc_driver_id').val(driver_id);
            $('#sc_week').val(week);
            $('#sc_year').val(year);

            if(scorecard_id > 0){
                $('#bonus_button').html('<a href="<?php echo admin_url() . 'users/bonus/'; ?>'+scorecard_id+'" class="btn btn-dark"><i class="las la-money-bill"></i> View Bonus</a>');
            }
            
            
			$('#scorecardModal').modal('show');
        }
    });
}

</script>
<?php js_end(); ?>