<div class="row">

<div class="col-3 bg-light pt-3">

<div class="d-flex align-items-center justify-content-between mb-2">

<h6 class=""><strong>Chat</strong></h6>
<button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#broadcastModal">
<i class="las la-bullhorn"></i> Broadcast
</button>

</div>



<input type="text" id="search_user" name="search_user" value="" placeholder="Search Users" class="form-control mb-2" oninput="search_chat_users(this.value)" />

<div id="chat_users"></div>

</div>


<div id="chat_body" class="col">
	<div class="text-center text-muted pt-5"><i class="lar la-comment la-2x d-block mb-3"></i>Pick a person from left menu,<br/>and start your conversation.</div>
</div>

</div>







<?php js_start(); ?>
<script type="text/javascript">

function loadchat(user_id){
	$.ajax({
		type: 'POST',
		url: "<?php echo admin_url('users/loadchatajax'); ?>",
		data: {user_id:user_id},
		error: function() {
			//$('#btn-save-menu').attr('disabled', false);
		},
		success: function(data) {
			$('#chat_body').html(data);
			window.scrollTo(0, 0);
		}
	});


}

<?php 
if(isset($active_user) && $active_user > 0){
	echo 'loadchat('.$active_user.');';
}
?>

function loadchatusersajax(search_text = ''){
	//loading
	$('#chat_users').html('<div class="alert alert-secondary p-2">Loading...</div>');
	$.ajax({
		type: 'POST',
		url: "<?php echo admin_url('users/loadchatusersajax'); ?>",
		data: {search_text: search_text},
		error: function() {
			//$('#btn-save-menu').attr('disabled', false);
		},
		success: function(data) {
			$('#chat_users').html(data);
			//window.scrollTo(0, 0);
		}
	});
}


$(function(){
	loadchatusersajax();
	
});

setInterval(function() {
	var to_id = $('#to_id').val();
	loadchatbodyajax(to_id);
}, 1000);

function search_chat_users(search_text){
	loadchatusersajax(search_text);
}

function loadchatbodyajax(user_id){
	//loading
	//$('#chat_users').html('<div class="alert alert-secondary p-2">Loading...</div>');
	$.ajax({
		type: 'POST',
		url: "<?php echo admin_url('users/loadchatbodyajax'); ?>",
		data: {user_id: user_id},
		error: function() {
			//$('#btn-save-menu').attr('disabled', false);
		},
		success: function(data) {
			$('#chat_box_body').html(data);
			//window.scrollTo(0, 0);
		}
	});
}
</script>
<?php js_end(); ?>