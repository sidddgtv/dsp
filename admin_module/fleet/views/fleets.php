<div class="d-flex align-items-center justify-content-between">
<h6 class="mb-0"><strong><?php echo $heading_title; ?></strong></h6>
<div class="pull-right">
    <a href="<?php echo $add; ?>" data-toggle="tooltip" title="Add" class="btn btn-success btn-sm"><i class="las la-plus-circle"></i> Add Fleet</a>
</div>
</div>
<hr>

<div class="table-responsive">
<table id="Test" class="table" width="100%">
    <thead>
        <tr>
            <th width="50px">#</th>
          
                <td>QR</td>
                <td>Vehicle ID</td>
                <td>Route Type</td>
                <td>Fleet Details</td>
                <td>Notes</td>
                <td>Status</td>
                <td width="80px">History</td>
                <td width="80px">Action</td>
        </tr>
    </thead>
</table>
</div>
<!-- Modal -->
<div class="modal" tabindex="-1" id="imageinfo">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" id="imageinfobody">
      
    </div>
  </div>
</div>  

<?php js_start(); ?>
<script type="text/javascript">

$('body').on('click',"#view-image" ,function(event) {
    var id = $(this).data("test");
    console.log(id);
   $.ajax({
        type: 'POST',
        url: "<?php echo admin_url() . 'fleet/images/'; ?>"+id,
        data: {'id': id},
        dataType:'html',
        error: function() {
        },
        success: function(data) {
            console.log(data);
            $('#imageinfobody').html(data);
            $("#imageinfo").modal('show');
            $("#imageinfo").appendTo("body");
        }
    });
    return false;
});
</script>
<script type="text/javascript">

$(function(){
    $('#Test').DataTable({
        "processing": true,
        "serverSide": true,
        "pageLength": 50,
        "columnDefs": [
            { targets: 'no-sort', orderable: false }
        ],
        "ajax":{
            url :"<?=$datatable_url?>", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
                $(".datatable-error").html("");
                $("#Test").append('<tbody class="datatable-error"><tr><th colspan="6">No data found.</th></tr></tbody>');
                $("#datatable_processing").css("display","none");
                
            },
            dataType:'json'
        },
    });
});
</script>
<?php js_end(); ?>