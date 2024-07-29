<div class="card">
	<div class="card-header">
		<div class="d-flex align-items-center">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb mb-0">
					<li class="breadcrumb-item active" aria-current="page">Menu</li>
				</ol>
			</nav>
			<div class="w-100 text-end">
			<a href="<?php echo admin_url('menu/group'); ?>" data-toggle="tooltip" title="Add" id="add_group_menu" class="btn btn-primary btn-sm"><i class="las la-plus"></i> Add Menu Group</a>
			<a href="" data-toggle="tooltip" title="Add" class="btn btn-primary btn-sm" id="add_menu" data-id="<?php echo $menu_group_id; ?>"><i class="las la-plus"></i> Add Menu</a>
		</div>
		</div>
	</div>
	<div class="card-body">
		<div class="row">
	<div class="col-md-12">













		











		<ul id="menu-group myTab" class="nav nav-tabs"role="tablist">
			<?php $active = $this->uri->segment(4)?$this->uri->segment(4):1;
				foreach((array)$menu_groups as $key => $value) : ?>
			<li id="group-<?php echo $value['id']; ?>" class="nav-item" role="presentation"> <a href="<?php echo admin_url("menu/index/{$value['id']}"); ?>" class="nav-link <?php if($value['id'] == $active){ ?> active <?php } ?>"> <?php echo $value['title']; ?> </a> </li>
				

			<?php endforeach; ?>
		</ul>
		<div class="clear"></div>
		<?php echo form_open($action,array('class' => 'form-horizontal', 'id' => 'form-menu','role'=>'form')); ?>
			<div class="row mt-3">
				<div class="col-4 ps-5"><strong>Title</strong></div>
				<div class="col-2"><strong>URL</strong></div>
				<div class="col-2"><strong>Class</strong></div>
				<div class="col-2"><strong>Icon</strong></div>
				<div class="col-2 text-end"><strong>Action</strong></div>
			</div>
			<div id="menu_area" class="dd">
			<?php echo $menu; ?>
			</div>
			<div id="ns-footer">
				<button type="submit" class="btn btn-primary" id="btn-save-menu">Update Menu</button>
			</div>
			<br />
		<?php echo form_close(); ?>
	</div>
</div>
	</div>
</div>
<!-- Modal -->
<div class="modal" tabindex="-1" id="getmoalMenuForm" data-backdrop="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit menu</h5>
        <!--<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
        <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">X</button>
      </div>
      <div class="modal-body" id="getCode">
      </div>
    </div>
  </div>
</div>	

<!-- Modal -->
<div class="modal" tabindex="-1" id="addmenuform">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="addmenubody">
      </div>
    </div>
  </div>
</div>	

<!-- Modal -->
<div class="modal" tabindex="-1" id="addgroupmenuform" data-backdrop="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Group Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="addgroupmenubody">
      </div>
    </div>
  </div>
</div>	

<!-- Modal -->
<div class="modal" tabindex="-1" id="deletemenuform">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="deletemenubody">
      </div>
    </div>
  </div>
</div>	


<?php js_start(); ?>
<script type="text/javascript">
	$(function() {
		
	function admin_url(url) {
		return ADMIN_URL + url;
	}
	var menu_serialized; 
	var updateOutput = function(e) {
		
		var list = e.length ? e : $(e.target),
		output = list.data('output');
		if(window.JSON) {
			menu_serialized=window.JSON.stringify(list.nestable('serialize'));//, null, 2));
		}
		else {
			menu_serialized='';
		}
		console.log(menu_serialized);
	};
	$('#menu_area').nestable({
		listNodeName:'ul',
		group: 1,
		collapsedClass:'',
		
	}).on('change', updateOutput);
	
	$('#form-menu').submit(function() {
		$('#btn-save-menu').attr('disabled', true);
		$.ajax({
			type: 'POST',
			url: $(this).attr('action'),
			data: {menu:menu_serialized},
			error: function() {
				$('#btn-save-menu').attr('disabled', false);
				gbox.show({
					content: '<h2>Error</h2>Save menu error. Please try again.',
					autohide: 1000
				});
			},
			success: function(data) {
				gbox.show({
					content: '<h2>Success</h2>Menu position has been saved',
					autohide: 1000
				});
			}
		});
		return false;
	});
	
	$('.groupaction').click(function() {
		url=$(this).attr('href');
		gbox.show({
			type: 'ajax',
			url: $(this).attr('href'),
			buttons: {
				'Save': function() {
					var group_title = $('#menu-group-title').val();
					if (group_title == '') {
						$('#menu-group-title').focus();
					} else {
						$.ajax({
							type: 'POST',
							url: url,
							data: 'title=' + group_title,
							error: function() {
								//$('#gbox_ok').attr('disabled', false);
							},
							success: function(data) {
								alert(data);
								//$('#gbox_ok').attr('disabled', false);
								switch (data.status) {
									case 1:
										gbox.hide();
										if(data.action=='edit'){
											$('#menu-group').find("#group-" + data.id +" a" ).text(group_title) ;
											$('#edit-group-input').text(group_title);
										}else{
											$('#menu-group').append('<li id="group-"'+data.id+'"><a href="' + admin_url('menu/index/' + data.id) + '">' + group_title + '</a></li>');	
										}
										break;
									case 2:
										$('<span class="error"></span>')
											.text(data.msg)
											.prependTo('#gbox_footer')
											.delay(1000)
											.fadeOut(500, function() {
												$(this).remove();
											});
										break;
									case 3:
										$('#menu-group-title').val('').focus();
										break;
								}
							}
						});
					}
				},
				'Cancel': gbox.hide
			}
		});
		return false;
	});
	
	/* delete menu group
	------------------------------------------------------------------------- */
	$('#delete-group').click(function() {
		var group_title = $('#menu-group li.current a').text();
		var param = { menu_group_id : '<?=$menu_group_id?>' };
		gbox.show({
			content: '<h2>Delete Group</h2>Are you sure you want to delete this group?<br><b>'
				+ group_title +
				'</b><br><br>This will also delete all menus under this group.',
			buttons: {
				'Yes': function() {
					$.post(admin_url('menu/delete'), param, function(data) {
						if (data.success) {
							window.location = admin_url('menu');
						} else {
							gbox.show({
								content: 'Failed to delete this menu.'
							});
						}
					});
				},
				'No': gbox.hide
			}
		});
		return false;
	});
	
	/* edit menu
	------------------------------------------------------------------------- */
	$('#menu_area').on('click',".edit-menu" ,function(event) {
		var menu_id = $(this).closest('.dd-item').data('id');
		var menu_div = $(this).closest('.dd-item');
		$.ajax({
				type: 'POST',
				 url: "<?php echo admin_url() . 'menu/edit'; ?>",
				data: {'id': menu_id},
				dataType:'html',
				error: function() {
				},
				success: function(data) {
					$('#getCode').html(data);
					$("#getmoalMenuForm").modal('show');
					$("#getmoalMenuForm").appendTo("body");
				}
		});
		return false;
	});
	
	/* add menu
	------------------------------------------------------------------------- */

	$('body').on('click',"#add_menu" ,function(event) {
		var id = $(this).data("id");
		$.ajax({
				type: 'POST',
				 url: "<?php echo admin_url() . 'menu/addmenuform'; ?>",
				data: {'id': id},
				dataType:'html',
				error: function() {
				},
				success: function(data) {
					$('#addmenubody').html(data);
					$("#addmenuform").modal('show');
					$("#addmenuform").appendTo("body");
				}
		});
		return false;
	});

	$('body').on('click',"#add_group_menu" ,function(event) {
		$.ajax({
				type: 'POST',
				 url: "<?php echo admin_url() . 'menu/addGroupMenuform'; ?>",
				dataType:'html',
				error: function() {
				},
				success: function(data) {
					$('#addgroupmenubody').html(data);
					$("#addgroupmenuform").modal('show');
					 $("#addgroupmenuform").appendTo("body");
				}
		});
		return false;
	});




	$('#form-add-menu').submit(function() {
		if ($('#menu-title').val() == '') {
			$('#menu-title').focus();
		} else {
			$.ajax({
				type: 'POST',
				url: $(this).attr('action'),
				data: $(this).serialize(),
				dataType:'json',
				error: function() {
					gbox.show({
						content: 'Add menu error. Please try again.',
						autohide: 1000
					});
				},
				success: function(json) {
					$('.text-danger').remove();
					if(json['server_errors']) {
						for (i in json['server_errors']) {
							var element = $('#form-add-menu').find('#menu-' + i.replace('_', '-'));

							if ($(element).parent('.form-group')) {
								$(element).parent().after('<div class="text-danger">' + json['server_errors'][i] + '</div>');
							} else {
								$(element).after('<div class="text-danger">' + json['server_errors'][i] + '</div>');
							}
						}
					}else{
						
						switch (json.menu.status) {
							case 1:
								$('#form-add-menu')[0].reset();
								$('#menu_area > ul').append(json.menu.li);
								break;
							case 2:
								gbox.show({
									content: json.menu.msg,
									autohide: 1000
								});
								break;
							case 3:
								$('#menu-title').val('').focus();
								break;
						}
					}
					
					
					
				}
			});
		}
		return false;
	});
	
	/* delete menu
	------------------------------------------------------------------------- */

});
	$('body').on('submit', '.updateForm', function(e) {
		var gid = $(".group_id").val();
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        type: "POST",
        url: "<?php echo admin_url() . 'menu/updateMenu'; ?>",
        data: $('form.updateForm').serialize(),
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
        success: function(data){
           $("#getmoalMenuForm").modal('hide');
           window.location = '<?php echo admin_url() . 'menu/index'; ?>/'+gid;
        },
        error: function(){
            alert("Error");
        }
    });
    return false;
});

	$('body').on('submit', '.addMenuForm', function(e) {
		var gid = $(".group_id").val();
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        type: "POST",
        url: "<?php echo admin_url() . 'menu/insertMenuForm'; ?>",
        data: $('form.addMenuForm').serialize(),
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
        success: function(data){
        	if(data == 'sucess'){
        		$("#getmoalMenuForm").modal('hide');
           	window.location = '<?php echo admin_url() . 'menu'; ?>';
        	}else{
        		$('.eror_msg').html(data);
        	}
        },
        error: function(){
            alert("Error");
        }
    });
    return false;
});

		$('body').on('submit', '.addGroupMenuForm', function(e) {
		var gid = $(".group_id").val();
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        type: "POST",
        url: "<?php echo admin_url() . 'menu/insertGroupMenuForm'; ?>",
        data: $('form.addGroupMenuForm').serialize(),
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
        success: function(data){
        	if(data == 'sucess'){
        		//$("#getmoalMenuForm").modal('hide');
           	window.location = '<?php echo admin_url() . 'menu'; ?>';
        	}else{
        		$('.eror_msg').html(data);
        	}
        },
        error: function(){
            alert("Error");
        }
    });
    return false;
});
</script>
<style>
	ul{
		padding: 0;
    margin: 0;
    list-style: none;
	}
	 ul li{
		display: inline-block;
		
	}   
</style>
<?php js_end(); ?>