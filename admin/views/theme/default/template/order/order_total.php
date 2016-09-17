<?php echo $header;//装载header?>
<?php echo $top;//装载login_top?>
<!-- /subnavbar -->
<div class="container">
  <div class="row">
    <div class="col-md-12 middle-flat-left" role="main">
      <div class="panel panel-default">
        <p class="panel-heading row row-panel-heading bg-info"> <i class="glyphicon glyphicon-th-list"></i>&nbsp;&nbsp;会员订单统计</p>
        <!-- /widget-header -->
            <div class="panel-body">
				<table class="table">
					<thead>
						<tr>
							<td>昵称</td>
							<td>邮箱</td>
							<td>群组</td>
							<td>状态</td>
							<td>订单号</td>
							<td>商品数量</td>
							<td>总计</td>
							<td class="text-right">操作</td>
						</tr>
					</thead>
					<tbody>
						<?php if(isset($orders)):?>
						<?php foreach($orders as $order):?>
						<?php if(!empty($order)):?>
						<tr>
							<td><?php echo $order['nickname'];?></td>
							<td><?php echo $order['email'];?></td>
							<td><?php echo $order['name'];?></td>
							<td><?php echo $order['status_name'];?></td>
							<td><?php echo $order['order_id'];?></td>
							<td><?php echo isset($order['total_product']) ? $order['total_product'] : '0';?></td>
							<td><?php echo isset($order['total_price']) ? $this->currency->Compute($order['total_price']) : $this->currency->Compute('0');?></td>
							<td class="text-right"><a href="<?php echo site_url('user/user/edit?order_id=').$order['order_id'];?>" class="btn btn-primary" data-container="body" data-toggle="popover" data-placement="top" data-content="编辑"><i class="glyphicon glyphicon-edit"></i></a></td>
						</tr>
						<?php endif;?>
						<?php endforeach;?>
						<?php endif;?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="6"><?php echo !empty($pagination) ? $pagination : '';?></td>
							<td colspan="2"><div class="navbar-right pagination" style="margin-right: 0">共为你查询到&nbsp;<a><?php echo isset($count) ? $count : '0';?>条</a>&nbsp;订单记录</div></td>
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
<?php echo $footer;?>