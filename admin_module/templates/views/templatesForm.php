<div class="d-flex align-items-center justify-content-between">
<h6 class="mb-0"><strong><?php echo $heading_title; ?></strong></h6>
<div class="pull-right">
    <button type="submit" form="form-page" data-toggle="tooltip" title="Add Templates" class="btn btn-primary btn-sm"><i class="fa fa-save"></i></button>
    <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="cancel" class="btn btn-danger btn-sm"><i class="fa fa-reply"></i></a>
</div>
</div>
<hr>

<?php echo form_open_multipart(null, 'id="form-page" class="form-vertical"'); ?>

<div class="row mt-4 required">
    <label for="title" class="col-2 control-label">Template Name</label>
    <div class="col-10">
        <?php echo form_input(array('class' => 'form-control', 'name' => 'doc_title', 'id' => 'doc_title', 'placeholder' => 'Title', 'value' => set_value('doc_title', $doc_title))); ?>
        <?php echo form_error('doc_title', '<div class="text-danger">', '</div>'); ?>		
    </div>
</div>


<div class="row mt-4">
    <label for="title" class="col-2 control-label">File Upload</label>
    <div class="col-10">
       <input oninput="this.className = ''" type="file" class="form-control" name="uploadfile" id="fileToUpload"  accept="application/pdf" required>
    </div>
</div>
<!--<div class="row mt-4">
    <label for="title" class="col-2 control-label">Assign User</label>
     <div class="col-10">
    <select name="user" id="user" class="form-select" aria-label="Users">
        <option selected>Select any User</option>
        <?php foreach($all_users as $u) { ?>
            <option value="<?php echo $u->id ?>" <?php if($user == $u->id ) echo "selected" ?>> <?php echo $u->name ?> 
            </option>
        <?php }?> 
    </select>
</div>
</div>-->

<?php echo form_close(); ?>
<?php js_start(); ?>
<script type="text/javascript"><!--
    $(templates).ready(function() {
        $('textarea.ckeditor_textarea').each(function(index) {
            
            ckeditor_config.height = $(this).height();
            
            CKEDITOR.replace($(this).attr('name'), ckeditor_config); 
        });
        
        $('#title').keyup( function(e) {
            $('#slug').val($(this).val().toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9\-_]/g, ''))
        });
    });
//--></script>
<script type="text/javascript">
    var thin_config = {
        toolbar : [
            { name: 'basicstyles', items : [ 'Bold','Italic','-','NumberedList','BulletedList','-','Link','Unlink','Source'] }
        ],
        skin : 'office2013',
        entities : true,
        entities_latin : false,
        allowedContent: true,
        enterMode : CKEDITOR.ENTER_BR,
        resize_maxWidth : '400px',
        width : '550px',
        height : '120px'
  };
 
  $(templates).ready(function() {
      initDnD = function() {
            
         // Sort images (table sort)
         $('#banner_images').tableDnD({
            onDrop: function(table, row) {
               order = $('#banner_images').tableDnDSerialize()
               $.post('<?php echo base_url(ADMIN_PATH . '/banner/images_order') ?>', order, function() {
                  
               });
            },
            dragHandle: ".drag_handle"
         });
      }
      initDnD();
      $('textarea.description').ckeditor(thin_config);
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
</script>
<script type="text/javascript"><!--
var image_row = <?php echo $image_row; ?>;

function addImage() {
    
   html = '<tr class="image-row' +image_row + '">';
    html += '   <td class="drag_handle"></td>';
    html += '   <td class="text-left">';
    html += '       <div class="fileinput text-center">';
    html += '           <div class="thumbnail file-browse">';
    html += '               <img src="<?php echo $no_image; ?>" alt="" id="thumb-image' + image_row + '" />';
    html += '                   <input type="hidden" name="banner_image[' + image_row + '][image]" value="" id="input-image'+image_row+'" />';
    html += '           </div>';
    html += '           <div class="btn-group" role="group">';
    html += '               <a class="btn btn-primary btn-xs" onclick="image_upload(\'input-image' + image_row + '\',\'thumb-image' + image_row + '\')">Browse</a>';
    html += '               <a class="btn btn-danger btn-xs" onclick="$(\'#thumb-image' + image_row  + '\').attr(\'src\',  \'<?php echo $no_image; ?>\'); $(\'#input-image'+ image_row +'\').attr(\'value\', \'\');">Clear</a>';
    html += '           </div>';
    html += '       </div>';
    html += '   </td>';
    html += '   <td class="text-left">';
    html += '       <div class="fileinput text-center">';
    html += '           <div class="thumbnail file-browse">';
    html += '               <img src="<?php echo $no_image; ?>" alt="" id="thumb-truck_image' + image_row + '" />';
    html += '                   <input type="hidden" name="banner_image[' + image_row + '][truck_image]" value="" id="input-truck_image'+image_row+'" />';
    html += '           </div>';
    html += '           <div class="btn-group" role="group">';
    html += '               <a class="btn btn-primary btn-xs" onclick="image_upload(\'input-truck_image' + image_row + '\',\'thumb-truck_image' + image_row + '\')">Browse</a>';
    html += '               <a class="btn btn-danger btn-xs" onclick="$(\'#thumb-truck_image' + image_row  + '\').attr(\'src\',  \'<?php echo $no_image; ?>\'); $(\'#input-truck_image'+ image_row +'\').attr(\'value\', \'\');">Clear</a>';
    html += '           </div>';
    html += '       </div>';
    html += '   </td>';
    html += '   <td class="text-left">';
    html += '   <select class="form-control" name="banner_image[' + image_row + '][option_id]">';
    <?php foreach($options as $option){ ?>
    html += '<option value="<?php echo $option->id ; ?>"><?php echo $option->name ; ?></option>';
    <?php } ?>
    html += ' </select>';
    html += ' </td>';       
    html += '   <td class="text-right"><button type="button" onclick="$(\'.image-row' + image_row  + '\').remove();" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="las la-trash"></i></button></td>';
    html += '</tr>';
    
    $('#banner_images tbody').append(html);
    $('textarea.description').ckeditor(thin_config);
    image_row++;
}
function removeimage(j)
{
    $(".image-row"+j).remove();
    var instance="banner_image["+j+"][description]";
    var editor = CKEDITOR.instances[instance];
    if (editor) { editor.destroy(true); }
    //$('textarea.description').ckeditor(thin_config);
    
}
//--></script>
<?php js_end(); ?>
