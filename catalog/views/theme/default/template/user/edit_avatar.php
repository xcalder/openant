<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
	<div class="row"><?php echo $position_left;?>
  
		<?php if($position_left && $position_right):?>
		<?php $class = 'col-sm-6'; ?>
		<?php elseif($position_left || $position_right):?>
		<?php $class = 'col-sm-9'; ?>
		<?php else:?>
		<?php $class = 'col-sm-12'; ?>
		<?php endif;?>
	
		<div id="middle" class="<?php echo $class; ?> middle-flat-left">
			<?php echo $position_top; ?>
			<div class="container-box">
				<div class="imageBox">
					<div class="thumbBox"></div>
					<div class="spinner" style="display: none">Loading...</div>
				</div>
				<div class="action"> 
					<!-- <input type="file" id="file" style=" width: 200px">-->
					<div class="new-contentarea tc"> <a href="javascript:void(0)" class="upload-img">
							<label for="upload-file">选择图片</label>
						</a>
						<input type="file" class="" name="upload-file" id="upload-file" />
					</div>
					<input type="button" id="btnCrop"  class="Btnsty_peyton" value="裁切">
					<input type="button" id="btnZoomIn" class="Btnsty_peyton" value="+"  >
					<input type="button" id="btnZoomOut" class="Btnsty_peyton" value="-" >
				</div>
				<div class="cropped">
					<img src="<?php echo $image?>" align="absmiddle" style="width:32px;margin-top:4px;border-radius:32px;box-shadow:0px 0px 12px #7E7E7E;" ><p>32px*32px</p>
					<img src="<?php echo $image?>" align="absmiddle" style="width:64px;margin-top:4px;border-radius:64px;box-shadow:0px 0px 12px #7E7E7E;"><p>64px*64px</p>
					<img src="<?php echo $image?>" align="absmiddle" style="width:128px;margin-top:4px;border-radius:128px;box-shadow:0px 0px 12px #7E7E7E;"><p>128px*128px</p>
				</div><hr>
				<button type="button" id="up-load-avatar" class="btn btn-success btn-block" disabled="disabled">请先剪裁</button>
			</div>
			<!-- /widget -->
			<?php echo $position_bottom; ?>
		</div>
		<?php echo $position_right; ?>
	</div>
	<script type="text/javascript">
		$(window).load(function() {
				var options =
				{
					thumbBox: '.thumbBox',
					spinner: '.spinner',
					imgSrc: '<?php echo $image?>'
					//imgSrc: 'public/head_portrait_update/images/avatar.png'
				}
				var cropper = $('.imageBox').cropbox(options);
				$('#upload-file').on('change', function(){
						var reader = new FileReader();
						reader.onload = function(e) {
							options.imgSrc = e.target.result;
							cropper = $('.imageBox').cropbox(options);
						}
						reader.readAsDataURL(this.files[0]);
						this.files = [];
					})
				$('#btnCrop').on('click', function(){
						var img = cropper.getDataURL();
						$('.cropped').html('');
						$('.cropped').append('<img src="'+img+'" align="absmiddle" style="width:32px;margin-top:4px;border-radius:32px;box-shadow:0px 0px 12px #7E7E7E;" ><p>32px*32px</p>');
						$('.cropped').append('<img src="'+img+'" align="absmiddle" style="width:64px;margin-top:4px;border-radius:64px;box-shadow:0px 0px 12px #7E7E7E;"><p>64px*64px</p>');
						$('.cropped').append('<img src="'+img+'" id="up-load-img" align="absmiddle" style="width:128px;margin-top:4px;border-radius:128px;box-shadow:0px 0px 12px #7E7E7E;"><p>128px*128px</p>');
						$('#up-load-avatar').removeAttr('disabled').attr("onclick", "upload_avatar();").html('<i class="glyphicon glyphicon-open"></i>确认上传');
					});
				$('#btnZoomIn').on('click', function(){
						cropper.zoomIn();
					})
				$('#btnZoomOut').on('click', function(){
						cropper.zoomOut();
					})
			});
			
			function upload_avatar(){
				var img=$('#up-load-img').attr('src');
				
				$.ajax(
					{
						url: '<?php echo site_url();?>user/edit/upload_avatar.html',
						type: 'post',
						dataType: 'json',
						data: {img:img},
						beforeSend: function()
						{
							NProgress.start();
						},
						complete: function()
						{
							NProgress.done();
						},
						success: function(data)
						{
							if(data.status == '0'){
								window.location.replace("user");
							}else{
								 window.location.reload();
							}
						},
						error: function(xhr, ajaxOptions, thrownError)
						{
							alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
						}
					});
					
			}
		
	</script>
	<!-- /row --> 
</div>
<!-- /container -->
<?php echo $footer;//装载header?>