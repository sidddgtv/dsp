<?php /*if ($this->user->isLogged()){?>
<footer>DOJO CMS(Page rendered in <strong>{elapsed_time} seconds</strong>)</footer>
</section>

<div id="loading" style="display:none;">
<img src="<?php echo theme_url('assets/images/ajax-loader.gif');?>" alt="Loading">Processing...
</div>	


<?php }*/  ?>









<?php if ($this->user->isLogged()){?>

		</div>
	</div>
</div>	

<?php }  ?>



<?php if ($this->user->isLogged()){
	echo '<div id="parent_chat_box" class="chatbox"></div><!--chatbox ends-->';
}  ?>




<?php 
/*if(array_key_exists('scorecard_modal', $_SESSION)){
	echo $_SESSION['scorecard_modal'];
	unset($_SESSION['scorecard_modal']);
}*/
?>


<!-- Modal -->
<div class="modal fade" id="scorecardModal" tabindex="-1" aria-labelledby="scorecardLabel" aria-hidden="true">
			  <div class="modal-dialog modal-lg">
				<div class="modal-content">
				  <div class="modal-header">
					<h1 class="modal-title fs-5" id="scorecardModalLabel">Scorecard</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				  </div>
				  <div id="scorecard_modal_body" class="modal-body">
				   

				  </div><!--modal body ends-->
				  <div class="modal-footer">
				  
					<span id="bonus_button"></span>

					<form method="POST" target="_blank" action="<?php echo admin_url('users/generate'); ?>">
					<input type="hidden" id="sc_driver_id" name="driver_id" value="0" />
					<input type="hidden" id="sc_week" name="week" value="0" />
					<input type="hidden" id="sc_year" name="year" value="0" />
					<button type="submit" title="Download" class="btn btn-danger"><i class="las la-file-pdf"></i> Download Scorecard</button>
					</form>
					<!--<a href="#" class="btn btn-success"><i class="las la-hand-holding-usd"></i> Bonus Eligible</a>-->
				  
				  </div>
			
			
				  <div class="col-12">
				
			</div>
			
			
				</div>
			  </div>
			</div>






<!-- Modal -->
<div class="modal fade" id="scheduleModal" tabindex="-1" aria-labelledby="scheduleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<div id="schedule_modal_body" class="modal-body">
		

		</div><!--modal body ends-->



	</div>
	</div>
</div>



<!-- Modal -->
<div class="modal fade" id="sheetModal" tabindex="-1" aria-labelledby="sheetModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<div id="sheet_modal_body" class="modal-body">
		

		</div><!--modal body ends-->



	</div>
	</div>
</div>






<!-- Modal -->
<div class="modal fade" id="broadcastModal" tabindex="-1" aria-labelledby="broadcastModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="broadcastModalLabel">Broadcast Message (Send all Users)</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
		<form action="<?php echo admin_url('users/broadcast'); ?>" method="POST">
			<textarea class="form-control" id="broadcast_message" name="broadcast_message" placeholder="Type your message here" rows="5"></textarea>
			

			<div class="d-flex align-items-center justify-content-between mt-2">

			<small style="font-size:10px" class="ps-2 text-muted">WARNING: Message once sent cannot be deleted. </small>
			<button type="submit" class="btn btn-danger"><i class="las la-paper-plane"></i> Send All</button>

			</div>

		</form>
      </div>
    </div>
  </div>
</div>




<!-- Modal -->
<div class="modal fade" id="pointModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Point(s)</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0 m-0">
        
		<table class="table mb-0 small ps-2">
		<tbody>
		<tr><th>Check In</th><td>8:31 AM</td></tr>
		<tr><th>Check Out</th><td>06:00 PM</td></tr>
		<tr><th>Remarks</th><td>LATE</td></tr>
		<tr><th>Point</th><td>-0.5</td></tr>
		</tbody>
		</table>



      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
		<div class="modal-header">
			<h1 class="modal-title fs-5" id="uploadModalLabel">Upload Week Schedule</h1>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body">

      <input type="file" id="schedule_file" name="schedule_file" class="form-control mb-2" onchange="jobs_preview()" required />

      <div id="show_tmp" class="my-3 small"></div>

      <button type="button" id="week_btn" class="btn btn-dark" disabled><i class="las la-plus-circle"></i> Upload</button>

            

			
		</div>

    <div class="modal-footer text-center d-block">
        Reference Template: <a target="_blank" href="<?php echo base_url('schedule_template.xlsx'); ?>" class="btn btn-sm btn-outline-success align-items-center"><i class="las la-file-excel"></i> Download</a>
    </div><!--modal-footer ends-->


		</div>
	</div>
</div>



<!-- Modal -->
<div class="modal fade" id="uploadSheetModal" tabindex="-1" aria-labelledby="uploadSheetModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
		<div class="modal-header">
			<h1 class="modal-title fs-5" id="uploadSheetModalLabel">Upload Sheet</h1>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body">

      <input type="date" id="sheet_date" name="sheet_date" class="form-control mb-2" onchange="sheets_preview()" required />

      <input type="file" id="sheet_file" name="sheet_file" class="form-control mb-2" onchange="sheets_preview()" required />

      <div id="show_sheet_tmp" class="my-3 small"></div>

      <button type="button" id="week_sheet_btn" class="btn btn-dark" disabled><i class="las la-plus-circle"></i> Upload</button>

            

			
		</div>

    <div class="modal-footer text-center d-block">
        Reference Template: <a target="_blank" href="<?php echo base_url('sheet_template.xlsx'); ?>" class="btn btn-sm btn-outline-success align-items-center"><i class="las la-file-excel"></i> Download</a>
    </div><!--modal-footer ends-->


		</div>
	</div>
</div>




<!-- Modal -->
<div class="modal fade" id="publishModal" tabindex="-1" aria-labelledby="publishModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
		<div class="modal-header">
			<h1 class="modal-title fs-5" id="publishModalLabel">Publish Week Schedule?</h1>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body">
      
      <div id="publish_message"></div>
      
      <button type="button" id="week_btn" class="btn btn-dark mt-3" onclick="publishschedule()">Publish</button>
      <div class="text-success small mt-3" id="publish_success_message"></div>
            

			
		</div>


		</div>
	</div>
</div>





<!-- Modal -->
<div class="modal fade" id="summaryModal" tabindex="-1" aria-labelledby="summaryModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
		<div class="modal-header">
			<h1 class="modal-title fs-5" id="summaryModalLabel">Summary of Week Schedule</h1>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body">
      
      <div id="summary_message"></div>
      
      <div class="small mt-3" id="summary_success_message"></div>
            

			
		</div>


		</div>
	</div>
</div>




<!-- Scorecard Modal -->
<div class="modal fade" id="uploadscorecardModal" tabindex="-1" aria-labelledby="uploadscorecardModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
		<div class="modal-header">
			<h1 class="modal-title fs-5" id="uploadscorecardModalLabel">Upload Scorecard</h1>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body">
			<form action="<?php echo admin_url('users/uploadweekscorecard'); ?>" method="POST" enctype="multipart/form-data">

			<div class="row mb-3">
				<label for="scorecard_file" class="col-sm-2 col-form-label">Select File</label>
				<div class="col-sm-10">
				<input type="file" id="scorecard_file" name="scorecard_file" class="form-control" required />
				</div>
			</div>

			<div class="row mb-3">
				<label class="col-sm-2 col-form-label">&nbsp;</label>
				<div class="col-sm-10">
				<button type="submit" class="btn btn-primary"><i class="las la-plus-circle"></i> Upload</button>
				</div>
			</div>

            <hr/>
            <div class="row">
				<label for="scorecard_file" class="col-sm-2 col-form-label">Reference Template</label>
				<div class="col-sm-3">
				    <a target="_blank" href="<?php echo base_url('scorecard_template.csv'); ?>" class="btn btn-sm btn-outline-success align-items-center"><i class="las la-file-excel"></i> Download</a>
				</div>
			</div>

			
			</form>
		</div>
		</div>
	</div>
</div>


<!-- Temp Driver Add Modal -->
<div class="modal fade" id="tempDriverAddModal" tabindex="-1" aria-labelledby="tempDriverAddModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="tempDriverAddModalLabel">Approve Driver</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="<?php echo admin_url('users/approvedriver'); ?>" method="POST">
            <div class="form-floating mb-3">
            <input type="text" readonly class="form-control-plaintext" id="full_name" name="full_name" placeholder="name@example.com" value="Mr. Full Name">
            <label for="full_name">Full Name</label>
            </div>
            <div class="form-floating mb-3">
            <input type="email" class="form-control" id="email_id" name="email_id" placeholder="name@example.com" oninput="check_email_id(this.value)">
            <label for="email_id">Email Address</label>
            <small id="email_id_msg" class="text-danger"></small>
            </div>
            <div class="form-floating mb-3">
            <input type="password" class="form-control" id="user_pwd" name="user_pwd" placeholder="Password">
            <label for="user_pwd">Password</label>
            </div>
            <input type="hidden" id="tmp_user_id" name="tmp_user_id" value="0">
            <button type="submit" id="btn_submit" class="btn btn-success">Approve</button>
        </form>
      </div><!-- modal body -->
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="bonusModal" tabindex="-1" aria-labelledby="bonusModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title fs-5" id="bonusModalLabel">Bonus Breakdown</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0">
        <?php 
        if(!empty($bonus_amount) && array_key_exists('breakdown', $bonus_amount) && !empty($bonus_amount['breakdown'])){
            echo '<table class="table table-bordered table-stripped table-hover table-sm text-center mb-0">';
            echo '<tr>
            <th>Field</th>
            <th>Condition</th>
            <th>Amount</th>
            <th>Tier</th>
            </tr>';
            echo $bonus_amount['breakdown'];
            echo '<tr><th colspan="2" class="text-end">TOTAL</th><th>$'.$bonus_amount['bonus'].'</th><th>'.$bonus_amount['tier'].'</th></tr>';
            echo '</table>';
        }
        ?>
      </div>
    </div>
  </div>
</div>



<!-- Gas Modal -->
<div class="modal fade" id="gasModal" tabindex="-1" aria-labelledby="gasModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <strong class="modal-title fs-5" id="gasModalLabel">Gas Pin</strong>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div id="gas_card_output" class="modal-body">
        
      </div>
    </div>
  </div>
</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script src="<?php echo base_url('storage/plugins/superfish/js/superfish.js');?>"></script>
<script src="<?php echo theme_url('assets/js/common.js'); ?>"></script>
<script src="<?php echo theme_url('assets/js/jquery-ui.min.js'); ?>"></script>
<script src="<?php echo theme_url('assets/js/ui.nestedSortable.js'); ?>"></script>
<script src="https://cdn.datatables.net/rowreorder/1.2.8/js/dataTables.rowReorder.min.js"></script>

<script>


$(document).ready(function(){
	$("#leftside-navigation .sub-menu > a").click(function(e) {	
	  $("#leftside-navigation ul ul").slideUp(), $(this).next().is(":visible") || $(this).next().slideDown(),
	  e.stopPropagation();
		$(this).parent().toggleClass('active').siblings().removeClass('active');	
	})



/*
  $('.nav-tabs li a').click(function (e) {     alert('test');
			//get selected href
			var href = $(this).attr('href');    

			//set all nav tabs to inactive
			$('.nav-tabs li').removeClass('active');

			//get all nav tabs matching the href and set to active
			$('.nav-tabs li a[href="'+href+'"]').closest('li').addClass('active');

			//active tab
			$('.tab-pane').removeClass('active');
			$('.tab-pane'+href).addClass('active');
		});


    */
})	
function myFunction() {
  var x = document.getElementById("left-col");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}

//chat controls
//scroll
$(document).ready(function(){
	//var container = document.getElementById("chat_body_1");

    // Automatically scroll to the bottom when content is added

      //container.scrollTop = container.scrollHeight;

})

function minimize(id){
	$('#chat_body_'+id).hide();
	$('#chat_footer_'+id).hide();
	$('#title_minus_'+id).hide();
	$('#title_plus_'+id).show();
	$('#chat_minus_'+id).hide();
	$('#chat_plus_'+id).show();
	//update window status
	/*$.ajax({
        url: "<?php //echo admin_url('users/updatechatwindowstatusajax'); ?>",
        type: "POST",
        data:{"driver_id": id, "window_status": 0},
        beforeSend: function() {
            
        },
        success: function (data) {
            //call to refresh
			startchat(0);
        },
        error: function () {
            alert("error");
        }
    });*/
}

function maximize(id){
	$('#chat_body_'+id).show();
	$('#chat_footer_'+id).show();
	$('#title_minus_'+id).show();
	$('#title_plus_'+id).hide();
	$('#chat_minus_'+id).show();
	$('#chat_plus_'+id).hide();
	//update window status
	/*$.ajax({
        url: "<?php //echo admin_url('users/updatechatwindowstatusajax'); ?>",
        type: "POST",
        data:{"driver_id": id, "window_status": 1},
        beforeSend: function() {
            
        },
        success: function (data) {
            //call to refresh
			startchat(0);
        },
        error: function () {
            alert("error");
        }
    });*/
}

function enlargechat(id, url){
	//alert(id);
	//removewindow(id);
	// Opens a link in a new window or tab
	//window.open(url);
	// Open a URL in the same tab
	window.location = url;
}

function removewindow(id){
	const chat = document.getElementById("chat_"+id);
	chat.remove();
	//remove from session
	$.ajax({
        url: "<?php echo admin_url('users/removechatboxajax'); ?>",
        type: "POST",
        data:{"driver_id":id},
        beforeSend: function() {
            
        },
        success: function (data) {
            //call to refresh
			startchat(0);
        },
        error: function () {
            alert("error");
        }
    });
}

function startchat(driver_id){
	$.ajax({
        url: "<?php echo admin_url('users/addchatboxajax'); ?>",
        type: "POST",
        data:{"driver_id":driver_id},
        beforeSend: function() {
            
        },
        success: function (data) {
            $('#parent_chat_box').html(data);
			window.scrollTo(0, 0);
        },
        error: function () {
            alert("error");
        }
    });
}

$(function(){
	startchat(0);
});




function load_chat(user_id){
    $.ajax({
        url: "<?php echo admin_url('users/loadchatajax'); ?>",
        type: "POST",
        data:{"user_id":user_id},
        beforeSend: function() {
            
        },
        success: function (data) {
            //alert(data);
            /*var res = JSON.parse(data);
            $('#home_state_name').html(res.state_name);
            $('#home_cities').html(res.cities);*/
            
            $('#chat_body').html(data);
			window.scrollTo(0, 0);
            //highlight the particular selected user
            $('.list-group-item').removeClass('bg-light');
            $('#user_btn_'+user_id).addClass('bg-light');

            chat_scroll = 1;

            //$('#is_typing_'+user_id).html('<div class="bubble"><div class="ellipsis dot_1"></div>&nbsp;<div class="ellipsis dot_2"></div>&nbsp;<div class="ellipsis dot_3"></div></div>');
            
            //add style
            //style="height: calc(100vh - 280px); "
            //$("#chat_box").css("height", "calc(100vh - 280px)");
            //alert($('#chat_box').height());
            //$('#chat_box').animate({ scrollTop: 9999 }, 'slow');
            //$("html,body").scrollTop(0);
            //$('#chat_box').animate({ scrollBottom: $('#chat_box').height() }, 1000);

            //$("#chat_box").animate({ scrollTop: $().prop("scrollHeight")}, 1000);
            
        },
        error: function () {
            alert("error");
        }
    });



    
    //$('html,body').animate({scrollTop: $('#last').offset().top},'slow');
    //alert($('#last').offset().top);
/*
    var $container = $("#chat_box_body");
    var $scrollTo = $('.card-footer');

    alert($scrollTo.offset().top - $container.offset().top + $container.scrollTop());

    $container.animate({scrollTop: $scrollTo.offset().top - $container.offset().top + $container.scrollTop(), scrollLeft: 0},300); 
*/
    //$('.chat-history')[0].animate({scrollTop:200}, 1000);
}

function send_message(driver_id = 0){
	let from_id = $('#from_id').val();
	let to_id = $('#to_id').val();
	let message_body = $('#message_body').val();

	if(driver_id > 0){
		from_id = $('#from_id_'+driver_id).val();
		to_id = $('#to_id_'+driver_id).val();
		message_body = $('#message_body_'+driver_id).val();
	}
    $.ajax({
        url: "<?php echo admin_url('users/replychat'); ?>",
        type: "POST",
        data:{"from_id":from_id,"to_id":to_id,"message_body":message_body},
        beforeSend: function() {
            
        },
        success: function (data) {
			load_chat(to_id);
			startchat(0);
            
            //remove typing
            $.ajax({
                url: "<?php echo admin_url('users/removetyping'); ?>",
                type: "POST",
                data:{"from_id":from_id,"to_id":to_id},
                beforeSend: function() {
                    
                },
                success: function (data) {
                    //$('#is_typing_'+to_id).html('');
                },
                error: function () {
                    alert("error");
                }
            });
            
        },
        error: function () {
            alert("error");
        }
    });
}

function typing(from_id, to_id){
    if($('#message_body').val().length){
        $.ajax({
            url: "<?php echo admin_url('users/addtyping'); ?>",
            type: "POST",
            data:{"from_id":from_id,"to_id":to_id},
            beforeSend: function() {
                
            },
            success: function (data) {
                //$('#is_typing_'+to_id).html('<div class="bubble"><div class="ellipsis dot_1"></div>&nbsp;<div class="ellipsis dot_2"></div>&nbsp;<div class="ellipsis dot_3"></div></div>');
            },
            error: function () {
                alert("error");
            }
        });
    }else{
        $.ajax({
            url: "<?php echo admin_url('users/removetyping'); ?>",
            type: "POST",
            data:{"from_id":from_id,"to_id":to_id},
            beforeSend: function() {
                
            },
            success: function (data) {
                //$('#is_typing_'+to_id).html('');
            },
            error: function () {
                alert("error");
            }
        });
    }
}

function approve_driver(tmp_id){
    // / data-bs-toggle="modal" data-bs-target="#"
    var driver_name = $('#approve_driver_'+tmp_id).html();
    $('#full_name').val(driver_name);
    $('#tmp_user_id').val($('#tmp_id_'+tmp_id).val());
    $('#tempDriverAddModal').modal('show');
    
}



function check_email_id(email_id){
    $.ajax({
        url: "<?php echo admin_url('users/checkemailid'); ?>",
        type: "POST",
        data:{"email_id":email_id},
        beforeSend: function() {
            
        },
        success: function (data) {
            if(data == 2){
                //email id exists
                $("#email_id").removeClass("is-valid");
                $("#email_id").addClass("is-invalid");

                //show a message
                $('#email_id_msg').html('Invalid Email ID format! Please try again.');

                //disable button
                $('#btn_submit').attr('disabled','disabled');
                $("#btn_submit").removeClass("btn-primary");
                $("#btn_submit").addClass("btn-secondary");
            }else if(data == 1){
                //email id exists
                $("#email_id").removeClass("is-valid");
                $("#email_id").addClass("is-invalid");

                //show a message
                $('#email_id_msg').html('Sorry, Account with this Email ID exists! Please try again.');

                //disable button
                $('#btn_submit').attr('disabled','disabled');
                $("#btn_submit").removeClass("btn-primary");
                $("#btn_submit").addClass("btn-secondary");
            }else if(data == 0){
                //email id available
                $("#email_id").removeClass("is-invalid");
                $("#email_id").addClass("is-valid");

                //hide message
                $('#email_id_msg').html('');

                //enable button
                $('#btn_submit').removeAttr('disabled');
                $("#btn_submit").removeClass("btn-secondary");
                $("#btn_submit").addClass("btn-primary");
            }
            /*var res = JSON.parse(data);
            $('#home_state_name').html(res.state_name);
            $('#home_cities').html(res.cities);*/
        },
        error: function () {
            alert("error");
        }
    });
}


function updateschedulecode(val, schedule_id, driver_id, dt, week, year){
    $.ajax({
          type: 'POST',
          url: "<?php echo admin_url() . 'schedule/updateschedulecode'; ?>",
          data: {'code_id': val, 'schedule_id': schedule_id, 'driver_id': driver_id, 'dt': dt, 'week': week, 'year': year},
          dataType:'html',
          error: function() {
          },
          success: function(data) {
              //$('#schedule_modal_body').html(data);
              //$('#scheduleModal').modal('show');
              $('#code_status_message').html('<i class="las la-check-circle"></i> Status updated');
              loadSchedule(week, year);
          }
    });
}

function updatenotes(schedule_id, driver_id, dt, week, year){
    var notes = $('#notes_schedule').val();
    //alert(notes);
    $.ajax({
          type: 'POST',
          url: "<?php echo admin_url() . 'schedule/updateschedulenote'; ?>",
          data: {'notes': notes, 'schedule_id': schedule_id, 'driver_id': driver_id, 'dt': dt, 'week': week, 'year': year},
          dataType:'html',
          error: function() {
          },
          success: function(data) {
              //$('#schedule_modal_body').html(data);
              //$('#scheduleModal').modal('show');
              $('#note_status_message').html('<i class="las la-check-circle"></i> Notes updated');
              loadSchedule(week, year);
          }
    });
}

/*
var chat_scroll = 0;

setInterval(function(){
    if($('#chat_box_body').length && chat_scroll){
        //alert($('#chat_box_body').prop('scrollHeight'));
        //load_chat($('#to_id').val());
        $('#chat_box_body').animate({scrollTop:$('#chat_box_body').prop('scrollHeight')}, 1);
        chat_scroll = 0;
    }

   
    if($('#bubble').length){
        //alert($('#bubble').length);
        client_refresh = 1;
    }else if($('#from_id').length && client_refresh){
        //refresh chat also
        $.ajax({
            url: "<?php echo admin_url('users/refreshchat'); ?>",
            type: "POST",
            data:{"user_id":$('#from_id').val()},
            beforeSend: function() {
                
            },
            success: function (data) {
                //alert(data);
                if(data > 0){
                    //alert($('#from_id').val());
                    load_chat($('#to_id').val());
                }
                    
            },
            error: function () {
                alert("error");
            }
        });
        client_refresh = 0;
    }

    
    
    if($('#message_body').length){
        
        //in order to check opposite guy item, we need to swap the from and to received to check from DB
        //if($('#message_body').val().length){
            $.ajax({
                url: "<?php echo admin_url('pages/checktyping'); ?>",
                type: "POST",
                data:{"from_id":$('#to_id').val(),"to_id":$('#from_id').val()},
                beforeSend: function() {
                    
                },
                success: function (data) {
                    if(data > 0)
                        $('#is_typing_'+$('#to_id').val()).html('<div id="bubble" class="bubble"><div class="ellipsis dot_1"></div>&nbsp;<div class="ellipsis dot_2"></div>&nbsp;<div class="ellipsis dot_3"></div></div>');
                    else
                        $('#is_typing_'+$('#to_id').val()).html('');
                },
                error: function () {
                    alert("error");
                }
            });
       //}
    }

},100);
*/





</script>

<script>
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
</script>



<!--
<script src="<?php echo theme_url('assets/js/jquery.min.js'); ?>"></script>
<script src="<?php echo theme_url('assets/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('storage/plugins/superfish/js/superfish.js');?>"></script>
<script src="<?php echo theme_url('assets/js/common.js'); ?>"></script>
<script src="<?php echo theme_url('assets/js/jquery-ui.min.js'); ?>"></script>
<script src="<?php echo theme_url('assets/js/ui.nestedSortable.js'); ?>"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

-->
<?php echo $this->template->footer_javascript(); ?>


<!--<script>
	const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
	const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
</script>-->

</body>
</html>