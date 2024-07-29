<style>
.meter {
    color:#fff;
}
</style>
<input id="fileupload" type="file" name="files" multiple>
<div class="progress">
    <div class="meter progress-bar" style="width: 0%;"></div>
</div>
<div class="data"></div>

<!--
<script src="<?=theme_url('assets/js/jquery.ui.widget.js')?>"></script>
<script src="<?=theme_url('assets/js/jquery.iframe-transport.js')?>"></script>
<script src="<?=theme_url('assets/js/jquery.fileupload.js')?>"></script>
-->
<script>
$(function () {
    $('#fileupload').fileupload({
        url: ADMIN_URL+'common/upload/bulkuploader',
        maxChunkSize: 1048576,
        maxRetries: 3,
        dataType: 'json',
        multipart: true,
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10),
                meter = $('.progress .meter'),
                percent = progress + '%';
            meter.css('width', percent).text(percent);
        },
        add: function (e, data) {
            data.context = $('<p/>').text('Uploading...').appendTo('.data');
            data.submit();
        },
        done: function (e, data) {
            data.context.text('Upload success.');
			if(data.result.success){
				imgrow = addImage();
				$('#thumb-image' +imgrow).attr('src',data.result.file)
				$('#input-image'+imgrow).val(data.result.file_name)
			}
        },
        fail: function (e, data) {
            data.context.text('Upload failed.');
            $('.progress').addClass('alert');
            console.warn('Error: ', data);

        }
    }).on('fileuploadchunksend', function (e, data) {
          if (data.uploadedBytes === 3145728 ) return false;
    }).on('fileuploadchunkdone', function (e, data) {
      
    });
});
</script>