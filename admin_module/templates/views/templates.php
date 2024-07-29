<div class="d-flex align-items-center justify-content-between">
<h6 class="mb-0"><strong><?php echo $heading_title; ?></strong></h6>
<div class="pull-right">
    <a href="<?php echo $add; ?>" data-toggle="tooltip" title="Add" class="btn btn-primary btn-sm"><i class="las la-plus-circle"></i> Add Template</a>
</div>
</div>
<hr>
<form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-pages">        
    <table class="table" id="page_list" width="100%" >
        <thead>
            <tr>
                <th class="no-sort col-auto">#</th>
                <th class="col">Title</th>
                <th class="col">Download</th>
                <th class="no-sort col-auto" width="100px">Action</th>
            </tr>
        </thead>				
    </table>
</form>

<?php js_start(); ?>
    <script type="text/javascript"><!--
    $(function () {
        $('#page_list').DataTable({
            "processing": true,
            "serverSide": true,
            "pageLength": 50,
            "columnDefs": [
                {targets: 'no-sort', orderable: false}
            ],
            "ajax": {
                url: "<?= $datatable_url ?>", // json datasource
                type: "post", // method  , by default get
                error: function () {  // error handling
                    $(".page_list_error").html("");
                    $("#page_list").append('<tbody class="page_list_error"><tr><th colspan="2">No data found.</th></tr></tbody>');
                    $("#page_list_processing").css("display", "none");

                },
                dataType: 'json'
            },
        });
    });
//--></script>
    <?php js_end(); ?>