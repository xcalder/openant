<?php echo $header;//装载header?>
<?php echo $top;//装载login_top?>
<!-- /subnavbar -->
<div class="container">
  <div class="row">
    <div class="col-md-12 middle-flat-left" role="main">
      <div class="panel panel-default">
        <p class="panel-heading row row-panel-heading bg-info"> <i class="glyphicon glyphicon-th-list"></i>&nbsp;商家列表</p>
        <!-- /widget-header -->
            <div class="panel-body">
				<table class="table">
					<thead>
						<tr>
							<td>名称</td>
							<td>昵称</td>
							<td>邮箱</td>
							<td>手机</td>
							<td>群组</td>
							<td>状态</td>
							<td>销量</td>
							<td>总计</td>
							<td>评分</td>
							<td>所在地</td>
							<td class="text-right">操作</td>
						</tr>
					</thead>
					<tbody>
						<?php if(isset($stores)):?>
						<?php foreach($stores as $store):?>
						<?php if(!empty($store)):?>
						<?php 
			    		if($store['store_status'] == '1' || $store['date_invalid'] > date("Y-m-d H:i:s")){
							$invalid='disabled="disabled"';
							$uninvalid='';
						}else{
							$invalid='';
							$uninvalid='disabled="disabled"';
						}
						
						if($store['store_status'] == 1){
							$str_invalid='<span style="color:red">永久屏蔽</span>';
						}elseif($store['date_invalid'] > date("Y-m-d H:i:s")){
							$str_invalid=$store['date_invalid'].'(<span style="color:red">处罚</span>)';
						}elseif($store['check'] == 1){
							$str_invalid='<span style="color:red">待审核</span>';
						}else{
							$str_invalid='正常';
						}
			    		?>
						<tr>
							<td><?php echo $store['store_name'];?></td>
							<td><?php echo $store['nickname'];?></td>
							<td><?php echo $store['email'];?></td>
							<td><?php echo $store['telephone'];?></td>
							<td><?php echo $store['name'];?></td>
							<td><?php echo $str_invalid;?></td>
							<td><?php echo isset($store['total_product']) ? $store['total_product'] : '0';?></td>
							<td><?php echo isset($store['total_price']) ? $this->currency->Compute($store['total_price']) : $this->currency->Compute('0');?></td>
							<td><ul class="list-unstyled">
								  <li>店铺评分:<?php echo $store['ratings'];?></li>
								  <li>商品质量:<?php echo $store['quality'];?></li>
								  <li>服务态度:<?php echo $store['attitude'];?></li>
								</ul>
							</td>
							<td>所在地</td>
							<td class="text-right">
								<div class="btn-group" role="group">
								 <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="top" data-content="解除屏蔽" <?php echo $uninvalid;?> onclick="uninvalid('<?php echo $store['store_id'];?>');"><i class="glyphicon glyphicon-ok"></i></button>
								 <div class="btn-group" data-container="body" data-toggle="popover" data-placement="top" data-content="选择屏蔽时间">
									 <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" <?php echo $invalid;?>>
									 	<i class="glyphicon glyphicon-calendar"></i>
									 </button>
									  <ul class="dropdown-menu" style="right: 0;left: auto;">
									    <li onclick="invalid('<?php echo $store['store_id'];?>','7');"><a>7天</a></li>
									    <li onclick="invalid('<?php echo $store['store_id'];?>','15');"><a>15天</a></li>
									    <li onclick="invalid('<?php echo $store['store_id'];?>','30');"><a>30天</a></li>
									    <li onclick="invalid('<?php echo $store['store_id'];?>','90');"><a>90天</a></li>
									  </ul>
								 </div>
								 <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="top" data-content="永久屏蔽" <?php echo $invalid;?> onclick="invalid('<?php echo $store['store_id'];?>','always');"><i class="glyphicon glyphicon-remove"></i></button>
								</div>
							</td>
						</tr>
						<?php endif;?>
						<?php endforeach;?>
						<?php endif;?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="7"><?php echo !empty($pagination) ? $pagination : '';?></td>
							<td colspan="4"><div class="navbar-right pagination" style="margin-right: 0">共为你查询到&nbsp;<a><?php echo isset($count) ? $count : '0';?>个</a>&nbsp;商家记录</div></td>
						</tr>
					</tfoot>
				</table>
            </div>
            <!-- /widget-content --> 
      </div>
      <!-- /widget --> 
    </div>
  </div>
  <!-- /row --> 
</div>
<!-- /container -->

<script>     
function invalid(store_id, date_invalid){
	$.ajax({
		url: '<?php echo site_url();?>/sale/sale/invalid',
		type: 'post',
		data: 'store_id=' + store_id + '&date_invalid='+date_invalid,
		beforeSend: function() {
			NProgress.start();
		},
		complete: function() {
			NProgress.done();
		},
		success: function(){
			window.location.reload();//刷新当前页面.
		} 
	});
}

function uninvalid(store_id){
	$.ajax({
		url: '<?php echo site_url();?>/sale/sale/uninvalid',
		type: 'post',
		data: 'store_id=' + store_id,
		beforeSend: function() {
			NProgress.start();
		},
		complete: function() {
			NProgress.done();
		},
		success: function(){
			window.location.reload();//刷新当前页面.
		} 
	});
}
</script><!-- /Calendar -->
<?php echo $footer;?>