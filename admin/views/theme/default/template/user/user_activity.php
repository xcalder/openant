<?php echo $header;//装载header?>
<?php echo $top;//装载login_top?>
<!-- /subnavbar -->
<div class="container">
  <div class="row">
    <div class="col-md-12 middle-flat-left" role="main">
      <div class="panel panel-default">
        <p class="panel-heading row row-panel-heading bg-info"> <i class="glyphicon glyphicon-th-list"></i>&nbsp;&nbsp;会员活动</p>
        <!-- /widget-header -->
            <div class="panel-body">
				<table class="table">
					<thead>
						<tr>
							<th>内容</th>
							<th>IP</th>
							<th>添加日期</th>
						</tr>
					</thead>
					<tbody>
						<?php if($user_activitys):?>
						<?php foreach($user_activitys as $user_activity):?>
						<tr>
							<td><?php echo $user_activity['comment'];?></td>
							<td><?php echo $user_activity['ip'];?></td>
							<td><?php echo $user_activity['date_added'];?></td>
						</tr>
						<?php endforeach;?>
						<?php endif;?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="3"><?php echo !empty($pagination) ? $pagination : '';?></td>
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