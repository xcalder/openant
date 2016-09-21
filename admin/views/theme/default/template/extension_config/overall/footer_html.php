<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<div class="container">
	<div class="row">
		<div class="col-md-12 middle-flat-left">
			<div class="panel panel-default">
				<div class="panel-heading row row-panel-heading bg-info">
					<p class="navbar-left"><i class="glyphicon glyphicon-signal"></i>全局底部设置</p>
					<div class="navbar-right btn-group" style="margin-right: 0">
						<button type="button" onclick="submit('form-module')" class="btn btn-default"><i class="glyphicon glyphicon-floppy-save"></i></button>
						<a href="<?php echo site_url('extension_config/module/product');?>" class="btn btn-default"><i class="glyphicon glyphicon-share-alt"></i></a>
					</div>
				</div>
				<!-- /widget-header -->
				<div class="panel-body">
					<form action="admin.php/extension_config/overall/footer_html.html" method="post" enctype="multipart/form-data" id="form-module" class="form-horizontal">
						<div role="tabpanel" class="tab-pane active" id="tab-general">
							<ul class="nav nav-tabs" role="tablist" id="language-description">
								<?php foreach($languages as $language):?>
								<li role="presentation">
									<a href="#description-<?php echo $language['language_id']?>" role="tab" data-toggle="tab">
										<img  width="16px" height="11px" class="lazy" data-original="public/flags/<?php echo $language['image']?>">&nbsp;&nbsp;<?php echo $language['name']?>
									</a>
								</li>
								<?php endforeach;?>
							</ul>
							<!-- Tab panes -->
							<div class="tab-content" id="language-description-form">
								<?php foreach($languages as $language):?>
								<div role="tabpanel" class="tab-pane" id="description-<?php echo $language['language_id']?>">
									<div class="form-group">
										<div class="col-sm-12">
											<textarea name="description[<?php echo $language['code']?>]" id="input-description-<?php echo $language['language_id']?>"><?php echo isset($footer_htmls['setting']) ? $footer_htmls['setting'][$language['code']] : '';?></textarea>
										</div>
									</div>
								</div>
								<?php endforeach;?>
								<?php if(isset($footer_htmls['setting'])):?>
								<input type="hidden" name="module_id" value="<?php echo $footer_htmls['module_id'];?>">
								<?php endif;?>
							</div>
						</div>
					</form>
					<!-- /area-chart --> 
				</div>
				<!-- /widget-content --> 
			</div>
			<!-- /widget -->
		</div>
		<!-- /span6 --> 
	</div>
	<script>
		$('#language-description li:first').addClass('active');
		$('#language-description-form .tab-pane:first').addClass('active');
		
		<?php foreach ($languages as $language):?>
		$(document).ready(function () {
				$('#input-description-<?php echo $language['language_id']; ?>').summernote({
						height: 200,                 // set editor height
					});
			});
		<?php endforeach; ?>
	</script>
	<!-- /row --> 
</div>
<!-- /container -->
<?php echo $footer;//装载header?>