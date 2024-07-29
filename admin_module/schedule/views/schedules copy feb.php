<?php 
if(array_key_exists('message', $_SESSION)){
	echo $_SESSION['message'];
	unset($_SESSION['message']);
}
?>
<div class="d-flex align-items-center justify-content-between">
<h6 class="mb-0"><strong>Schedule</strong></h6>
<div class="fw-bold">
<button type="button" onclick="updateWeek(-1)" class="btn btn-none btn-sm text-dark"><i class="las la-chevron-circle-left la-2x" style="vertical-align: bottom;"></i></button>
<span id="week_text" class="ms-2 me-3 fs-6">Week <?php echo $currentWeek.', '.$currentYear; ?></span>
<button type="button" onclick="updateWeek(1)" class="btn btn-none btn-sm text-dark"><i class="las la-chevron-circle-right la-2x" style="vertical-align: bottom;"></i></button>
<input type="hidden" id="week_number" value="<?php echo $currentWeek; ?>" />
<input type="hidden" id="year_number" value="<?php echo $currentYear; ?>" />
</div>
<div class=" text-end">

		<!-- Button trigger modal -->
		<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#uploadModal">
			<i class="las la-plus-circle"></i> Upload
		</button>
        
    </div>
</div>

<hr>
<!--<button type="button" class="btn btn-secondary"
        data-bs-toggle="tooltip" data-bs-placement="bottom"
        data-bs-custom-class="custom-tooltip"
        data-bs-title="This top tooltip is themed via CSS variables.">
  Custom tooltip
</button>-->
<!--
<div class="row">
<div class="col-auto my-auto">SEARCH/ FILTER</div>
<div class="col"><input type="text" class="form-control" placeholder="Employee Name" /></div>
<div class="col"><select class="form-select"><option>No. of Absence</option></select></div>
<div class="col"><select class="form-select"><option>Performance</option></select></div>
</div>

<hr/>-->

<div id="schedule_table" class="table-responsive">

</div>







<?php js_start(); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/jszip.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/xlsx.js"></script>


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
	//update hidden fields
	$('#year_number').val(newDate.year);
	$('#week_number').val(newDate.week);
	//update week text
	$('#week_text').html('Week '+newDate.week+', '+newDate.year);
}

function loadSchedule(week, year){
	$.ajax({
        type: 'POST',
        url: "<?php echo admin_url() . 'schedule/loadscheduletable'; ?>",
        data: {'week': week, 'year': year},
        dataType:'html',
        error: function() {
        },
        success: function(data) {
			$('#schedule_table').html(data);
			$('#datatable').DataTable();
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
	//alert(newYear);
    let firstJan = new Date(newYear, 0, 1);
    //let newWeek = Math.ceil((((date - firstJan) / 86400000) + firstJan.getDay() + 1) / 7);
	let newWeek = week;
    if(increment == '-1'){
        newWeek = parseInt(week) - 1;
    }else{
        newWeek = parseInt(week) + 1;
    }

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
			//alert(newYear);
        }
    }*/

	//alert(newYear);

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


document.getElementById('week_btn').addEventListener('click', jobs_import, false);

var ExcelToJSON = function() {

this.parseExcel = function(file) {
  var reader = new FileReader();

  reader.onload = function(e) {
	var data = e.target.result;
	var workbook = XLSX.read(data, {
	  type: 'binary'
	});

	var sheetName = workbook.SheetNames[0];
	var sheet = workbook.Sheets[sheetName];

	// Convert the sheet to an array of arrays
	var rows = XLSX.utils.sheet_to_json(sheet, { header: 1 });

	// Transform each row array into an object with numeric keys
	var XL_row_objects = rows.map(row => {
	return row.reduce((accumulator, currentValue, currentIndex) => {
		accumulator[currentIndex] = currentValue;
		return accumulator;
	}, {});
	});

	var json_object = JSON.stringify(XL_row_objects);

	//send to PHP
	$.ajax({
			url: '<?php echo admin_url('schedule/add'); ?>',
			type: 'post',
			data: { 'ls_values': json_object },
			success: function(response){
				//$("#open_jobs_container").html(response);
				//alert(response);
				//window.location = response;
			}
		});

	//console.log(XL_row_objects);
	/*workbook.SheetNames.forEach(function(sheetName) {
		// Here is your object
		var XL_row_object = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
		var json_object = JSON.stringify(XL_row_object);
		//alert(json_object);
		//console.log(JSON.parse(json_object));
		//jQuery('#xlx_json').val(json_object);
		//send to PHP
	  	$.ajax({
			url: '<?php //echo admin_url('schedule/add'); ?>',
			type: 'post',
			data: { 'ls_values': json_object },
			success: function(response){
				//$("#open_jobs_container").html(response);
				//alert(response);
				//window.location = response;
			}
		});
	})*/
  };

  reader.onerror = function(ex) {
	console.log(ex);
  };

  reader.readAsBinaryString(file);
};
};


function jobs_import(evt) {
	var files = document.getElementById('schedule_file').files; // FileList object
	//alert(files);

	//var fileInput = document.getElementById('file_input');
    var file = files[0]; // Get the file

    // Check if any file is selected or not
    if (!file) {
        alert('Please select a file first!');
        return;
    }

    // Check the file extension before reading it
    if (!(/\.(xls|xlsx)$/i).test(file.name)) {
        alert('Please upload Schedule Excel file only (.xls or .xlsx).');
        return; // Stop further execution if not an Excel file
    }



	var xl2json = new ExcelToJSON();
	xl2json.parseExcel(files[0]);
}

function loadschedulemodal(driver_id, dt, week, year){
	
	$.ajax({
        type: 'POST',
        url: "<?php echo admin_url() . 'schedule/schedulemodalbody'; ?>",
        data: {'driver_id': driver_id, 'dt': dt, 'week': week, 'year': year},
        dataType:'html',
        error: function() {
        },
        success: function(data) {
			$('#schedule_modal_body').html(data);
			$('#scheduleModal').modal('show');
        }
    });
}

</script>
<?php js_end(); ?>