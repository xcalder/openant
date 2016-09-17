<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
	<div class="row">
		<div class="col-md-12 middle-flat-left" role="main">
			<form action="<?php echo $action;?>" method="post" enctype="multipart/form-data" id="form-select_category" class="form-horizontal">
				<div class="panel panel-default">
					<p class="panel-heading row row-panel-heading bg-info" style="margin: 0">
						<i class="glyphicon glyphicon-tags">
						</i>&nbsp;请选择一个分类
					</p>
					<!-- /widget-header -->
					<div class="panel-body row">
						<span style="margin-left: 15px;">
							提示：分类选择后不可以修改！
						</span>
						<div style="margin-top: 15px" id="parent">
							<div class="col-md-6">
								<div class="well well-sm">
									<?php
									if($parent_categorys):?>
									<?php
									foreach($parent_categorys as $parent_category):?>
									<div class="radio">
										<label>
											<input type="radio" name="parent_id" id="parent-<?php echo $parent_category['category_id'];?>" value="<?php echo $parent_category['category_id'];?>" onchange="child_category('<?php echo $parent_category['category_id'];?>');" ><?php echo $parent_category['name'];?>
										</label>
									</div>
									<?php endforeach;?>
									<?php endif;?>
								</div>
							</div>
							<div class="col-md-6">

								<div class="well well-sm" id="child">

								</div>

							</div>
						</div>
						<div class="col-md-12 text-right">
							<button type="submit" class="btn btn-info">
								下一步
							</button>
						</div>
					</div>
					<!-- /widget-content -->
				</div>
			</form>
		</div>
		<!-- /span6 -->
	</div>
	<!-- /row -->
	<script type="text/javascript">
		$(document).ready(function()
			{
				<?php if($last_add):?>
				$('#parent-'+<?php echo $last_add['parent_id'];?>).attr("checked", "checked");
				child_category(<?php echo $last_add['parent_id'];?>);
				<?php else:?>
				$('#parent div:first').attr("checked", "checked");
				child_category($('#parent div:first').val());
				<?php endif;?>
			});
		function child_category(parent_id)
		{
			$.ajax(
				{
					url: "<?php echo site_url();?>/product/product/get_child_category?parent_id=" + parent_id,
					dataType: 'json',
					beforeSend: function()
					{
						NProgress.start();
					},
					complete: function()
					{
						NProgress.done();
					},
					success: function(json)
					{
						if(json['child_id'])
						{
							child_id=json['child_id'];
						}
						html = '';

						if (json && json != '')
						{
							for (i = 0; i < json.length; i++)
							{
								html += '<div class="radio"><label><input type="radio" name="child_id" value="' + json[i]['category_id'] + '"';

								if (json[i]['child_id'])
								{
									html += ' checked="checked"';
								}

								html += '>' + json[i]['name'] + '</label></div>';
							}
						} else
						{
							html += '<div class="radio"><label><input type="radio" name="child_id" value="">无</label></div>';
						}

						$('#child').html(html);
					},
					error: function(xhr, ajaxOptions, thrownError)
					{
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});
		}

		//$('select[name$=\'[country_id]\']').trigger('change');
	</script>
</div>
<!-- /container -->
<?php echo $footer;//装载header?>