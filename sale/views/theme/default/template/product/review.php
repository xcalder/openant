<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
	<div class="row">
		<!-- /span6 -->
		<div class="col-md-12 middle-flat-left">
			<div class="panel panel-default">
				<div class="panel-heading row row-panel-heading bg-info">
					<p class="navbar-left"><i class="glyphicon glyphicon-th-list"></i>&nbsp;商品评论列表</p>
				</div>
				<!-- /widget-header -->
				<div class="panel-body">
					<form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-review">
						<table class="table">
							<thead>
								<tr>
									<td></td>
									<td>商品</td>
									<td>内容</td>
									<td>评论时间</td>
									<td>修改时间</td>
									<td>回评</td>
								</tr>
							</thead>
							<tbody>
								<?php if(isset($reviews)):?>
								<?php foreach($reviews as $review):?>
								<tr>
									<td><img width="<?php echo $this->config->get_config('wish_cart_image_size_s_w');?>px" height="<?php echo $this->config->get_config('wish_cart_image_size_s_h');?>px" class="lazy" data-original="<?php echo $this->image_common->resize($review['image'], $this->config->get_config('wish_cart_image_size_s_w'), $this->config->get_config('wish_cart_image_size_s_h'));?>"/></td>
									<td><?php echo $review['name'];?></td>
									<td><?php echo $review['text'];?></td>
									<td><?php echo $review['date_added'];?></td>
									<td><?php echo $review['date_modified'];?></td>
									<td><?php echo $review['date_modified'];?></td>
								</tr>
								<?php endforeach;?>
								<?php endif;?>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="7"><?php echo $pagination;?></td>
								</tr>
							</tfoot>
						</table>
					</form>
				</div>
				<!-- /widget-content --> 
			</div>
			<!-- /widget -->
		</div>
		<!-- /span6 --> 
	</div>
	<!-- /row --> 
</div>
<!-- /container -->
<?php echo $footer;//装载header?>