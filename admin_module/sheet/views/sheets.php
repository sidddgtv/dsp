<?php 
if(array_key_exists('message', $_SESSION)){
	echo $_SESSION['message'];
	unset($_SESSION['message']);
}
?>
<div class="d-flex align-items-center justify-content-between">
<h6 class="mb-0"><strong>Sheet</strong></h6>
<div class="fw-bold">
<button type="button" onclick="updateWeek(-1)" class="btn btn-none btn-sm text-dark"><i class="las la-chevron-circle-left la-2x" style="vertical-align: bottom;"></i></button>
<span id="week_text" class="ms-2 me-3 fs-6">Week <?php echo $currentWeek.', '.$currentYear; ?></span>
<button type="button" onclick="updateWeek(1)" class="btn btn-none btn-sm text-dark"><i class="las la-chevron-circle-right la-2x" style="vertical-align: bottom;"></i></button>
<input type="hidden" id="week_number" value="<?php echo $currentWeek; ?>" />
<input type="hidden" id="year_number" value="<?php echo $currentYear; ?>" />
</div>
<div class=" text-end">
        <!-- Button for publish -->
        <!--<button type="button" class="btn btn-danger btn-sm" onclick="loadpublishmodal()">
			<i class="las la-file-export"></i> Publish
		</button>-->
		<!-- Button trigger modal -->
		<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#uploadSheetModal">
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

<div id="sheet_table" class="table-responsive">

</div>







<?php js_start(); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/jszip.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/xlsx.js"></script>


<script type="text/javascript">
$(function(){
	loadSheet(<?php echo $currentWeek; ?>, <?php echo $currentYear; ?>);
	
});

function updateWeek(direction){
	// Example Usage
	let currentYear = $('#year_number').val();
	let currentWeek = $('#week_number').val();
	let increment = direction; // -1 for previous week, 1 for next week

	let newDate = adjustWeek(currentYear, currentWeek, increment);
	//alert(`New Year: ${newDate.year}, New Week: ${newDate.week}`);
	loadSheet(newDate.week, newDate.year);
	//update hidden fields
	$('#year_number').val(newDate.year);
	$('#week_number').val(newDate.week);
	//update week text
	$('#week_text').html('Week '+newDate.week+', '+newDate.year);
}

function loadSheet(week, year){
	$.ajax({
        type: 'POST',
        url: "<?php echo admin_url() . 'sheet/loadsheettable'; ?>",
        data: {'week': week, 'year': year},
        dataType:'html',
        error: function() {
        },
        success: function(data) {
			$('#sheet_table').html(data);
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


document.getElementById('week_sheet_btn').addEventListener('click', sheets_import, false);

var ExcelToJSON = function() {

this.parseExcel = function(file, type) {
  var reader = new FileReader();

  reader.onload = function(e) {
	var data = e.target.result;
	var workbook = XLSX.read(data, {
	  type: 'binary'
	});
	workbook.SheetNames.forEach(function(sheetName) {
		// Here is your object
		//var XL_row_object = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
		//var excelRows = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName],{raw:false});
        //var excelRows = XLSX.utils.sheet_to_json(workbook.Sheets[sheetName], { raw: false, range: 3 }); // Skip first 3 rows


        

		//var json_object = JSON.stringify(excelRows);
        var worksheet = workbook.Sheets[sheetName];
        var excelRows = XLSX.utils.sheet_to_json(worksheet, { header: 1 });

        var filteredHeaders = excelRows.slice(0, 3); // Get only the first 3 rows
        var json_object_header = JSON.stringify(filteredHeaders);

        var filteredRows = excelRows.slice(3); // Skip first 3 rows
        var json_object = JSON.stringify(filteredRows);
		//console.log(json_object);
		//console.log(JSON.parse(json_object));
		//jQuery('#xlx_json').val(json_object);
		//frst add loading screen

        //type
        if(type == 1){
            //preview
            $("#show_sheet_tmp").html('<img src="<?php echo base_url('storage/uploads/loadingnew.gif');?>" alt="Loading" height="20" />');
            //send to PHP
            $.ajax({
                url: '<?php echo admin_url('sheet/preview'); ?>',
                type: 'post',
                data: { 'ls_headers': json_object_header, 'ls_values': json_object, 'sheet_date': $('#sheet_date').val() },
                success: function(response){
                    var data = JSON.parse(response);
                    if(data.status){
                        $("#show_sheet_tmp").html(data.message);
                        //enable upload button
                        $('#week_sheet_btn').prop('disabled', false);
                    }else{
                        $("#show_sheet_tmp").html(data.message);
                        //disable upload button
                        $('#week_sheet_btn').prop('disabled', true);
                    }
                    
                    //window.location = data;
                }
            });
        }else if(type == 2){
            //import
            $("#show_sheet_tmp").html('<img src="<?php echo base_url('storage/uploads/loadingnew.gif');?>" alt="Loading" height="20" />');
            //send to PHP
            $.ajax({
                url: '<?php echo admin_url('sheet/add'); ?>',
                type: 'post',
                data: { 'ls_headers': json_object_header, 'ls_values': json_object, 'sheet_date': $('#sheet_date').val() },
                success: function(response){
                    //alert(response);
                    var data = JSON.parse(response);
                    if(data.status){
                        $("#show_sheet_tmp").html(data.message);
                        //enable upload button
                        $('#week_sheet_btn').prop('disabled', false);
                        //refresh page
                        window.location.reload();
                    }else{
                        $("#show_sheet_tmp").html(data.message);
                        //disable upload button
                        $('#week_sheet_btn').prop('disabled', true);
                    }
                    
                    //window.location = data;
                }
            });
        }
        
	})
  };

  reader.onerror = function(ex) {
	console.log(ex);
  };

  reader.readAsBinaryString(file);
};
};

function sheets_preview(){
    //check date also
    var for_date = $('#sheet_date').val();
    if (for_date.length == 0) {
        alert('Date is mandatory');
        return;
    }else{
        //start checking file
        var files = document.getElementById('sheet_file').files; // FileList object
        //alert(files);

        //var fileInput = document.getElementById('file_input');
        var file = files[0]; // Get the file

        // Check if any file is selected or not
        if (!file) {
            alert('Please select a file!');
            return;
        }else if (!(/\.(xls|xlsx)$/i).test(file.name)) {
            // Check the file extension before reading it
            alert('Please upload Sheet Excel file only (.xls or .xlsx).');
            return; // Stop further execution if not an Excel file
        }else{
            var xl2json = new ExcelToJSON();
            xl2json.parseExcel(files[0], 1);
        }
    }
}


function sheets_import(){
	var files = document.getElementById('sheet_file').files; // FileList object
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
        alert('Please upload Sheet Excel file only (.xls or .xlsx).');
        return; // Stop further execution if not an Excel file
    }



	var xl2json = new ExcelToJSON();
	xl2json.parseExcel(files[0], 2);
}

function loadsheetmodal(driver_id, dt, week, year){
	
	$.ajax({
        type: 'POST',
        url: "<?php echo admin_url() . 'sheet/sheetmodalbody'; ?>",
        data: {'driver_id': driver_id, 'dt': dt, 'week': week, 'year': year},
        dataType:'html',
        error: function() {
        },
        success: function(data) {
			$('#sheet_modal_body').html(data);
			$('#sheetModal').modal('show');
        }
    });
}

function loadpublishmodal(){
	var year = $('#year_number').val();
	var week = $('#week_number').val();
	$('#publish_message').html('Publish all sheets for Week: <strong>'+week+'</strong> | Year: <strong>'+year+'</strong>?');
    $('#publish_success_message').html('');
    $('#publishModal').modal('show');
}

function publishsheet(){
    var year = $('#year_number').val();
	var week = $('#week_number').val();
    $.ajax({
        type: 'POST',
        url: "<?php echo admin_url() . 'sheet/publishsheet'; ?>",
        data: {'week': week, 'year': year},
        dataType:'html',
        error: function() {
        },
        success: function(data) {
			$('#publish_success_message').html('<i class="las la-check-circle"></i> Sheet published');
        }
    });
    
    //$('#publishModal').modal('hide');
}

</script>
<?php js_end(); ?>