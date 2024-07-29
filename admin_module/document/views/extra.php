<div class="d-flex align-items-center justify-content-between">
<h6 class="mb-0"><strong>Extra Resources</strong></h6>
<div class="pull-right">
    
</div>
</div>
<hr>

<table class="table" id="page_list" width="100%" >
    <thead>
        <tr>
            <th class="col" width="50px">#</th>
            <th class="col">Title</th>
            <th class="col" width="200px">Download</th>
        </tr>
    </thead>
    <tbody>
    <?php 
    $c = 1;
    if(empty($extras)){
        echo '<tr>
        <td colspan="3">No items to show</td>
       
    </tr>';
    }
    foreach($extras as $e){
        echo '<tr>
        <td>'.$c++.'</td>
        <td>'.$e->extra_title.'</td>
        <td><a href="'.base_url('storage/uploads/files/'.$e->extra_file).'" class="btn btn-danger btn-sm"><i class="las la-file-pdf"></i> Download</a></td>
    </tr>';
    }
    ?>
    </tbody>				
</table>