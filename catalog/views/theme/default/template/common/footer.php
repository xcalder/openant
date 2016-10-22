</div>
<div id="footer">
	<div class="visible-sm visible-xs" style="height: 55px"></div>
	<div class="visible-lg visible-md">
		<hr>
		<div class="container">
			<div class="row">
				<?php echo htmlspecialchars_decode($footer_html);?>
			</div>
		</div><hr>
		<!-- /container -->
		<div class="footer">
			<!-- Start Navigation -->
			<nav class="navbar bootsnav" style="border-bottom-width: 0px;">
				<div class="container">
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse" id="navbar-menu">
						<ul class="nav navbar-nav navbar-center">
							<li><a><span style="font-size:12px;font-family:Arial, Helvetica, sans-serif;" >&#169;</span><?php echo date("Y-m");?><?php echo lang_line('copyright');?></a></li>
							<?php if(ENVIRONMENT != 'production'):?>
							<li><a><?php echo lang_line('elapsed_time') . $this->benchmark->elapsed_time();?></a></li>
							<li><a><?php echo lang_line('memory_usage') . $this->benchmark->memory_usage();?></a></li>
							<?php endif;?>
							
							<?php echo lang_line('case_number');?>
							
							<?php echo lang_line('police_record');?>
							
						</ul>
					</div><!-- /.navbar-collapse -->
				</div>   
			</nav>
		</div>
		<!-- /footer -->
		<script>
			$(document).ready(function(){
					//重写编辑器文件管理器
					$('button[data-event=\'showImageDialog\']').attr('data-toggle', 'image').removeAttr('data-event');
		
					$(document).delegate('button[data-toggle=\'image\']', 'click', function() {
							$('#modal-image').remove();
			
							$(this).parents('.note-editor').find('.note-editable').focus();
			
							$.ajax({
									url: '<?php echo site_url();?>/common/filemanager',
									dataType: 'html',
									beforeSend: function() {
										NProgress.start();
									},
									complete: function() {
										NProgress.done();
									},
									success: function(html) {
										$('body').append('<div id="modal-image" class="modal" tabindex="-1" role="dialog" aria-labelledby="modal-image">' + html + '</div>');
		
										$('#modal-image').modal('show');
									}
								});	
						});
		
					// Image Manager
					$(document).delegate('span[data-toggle=\'image\']', 'click', function(e) {
							e.preventDefault();
			
							$('.popover').popover('hide', function() {
									$('.popover').remove();
								});
						
							var element = this;
			
							$(element).popover({
									html: true,
									placement: 'right',
									trigger: 'manual',
									content: function() {
										return '<button type="button" id="button-image" class="btn btn-primary"><i class="glyphicon glyphicon-edit"></i></button> <button type="button" id="button-clear" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i></button>';
									}
								});
			
							$(element).popover('show');

							$('#button-image').on('click', function() {
									$('#modal-image').remove();
			
									$.ajax({
											url: '<?php echo site_url();?>/common/filemanager?target=' + $(element).parent().find('input').attr('id') + '&thumb=' + $(element).attr('id'),
											dataType: 'html',
											beforeSend: function() {
												NProgress.start();
											},
											complete: function() {
												NProgress.done();
											},
											success: function(html) {
												$('body').append('<div id="modal-image" class="modal">' + html + '</div>');
			
												$('#modal-image').modal('show');
											}
										});
				
									$(element).popover('hide', function() {
											$('.popover').remove();
										});
								});		
			
							$('#button-clear').on('click', function() {
									$(element).find('img').attr('src', $(element).find('img').attr('data-placeholder'));
				
									$(element).parent().find('input').attr('value', '');
				
									$(element).popover('hide', function() {
											$('.popover').remove();
										});
								});
						});
				});
		</script>
	</div>
</div>
</body>
</html>