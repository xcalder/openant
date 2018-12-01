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
			
			<?php echo $pagination;?>
			<table class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<td>余额</td>
						<td>支付金额</td>
						<td>说明</td>
						<td>日期</td>
					</tr>
				</thead>
				<tbody>
					<?php if(isset($activitys) && $activitys):?>
					<?php foreach($activitys as $activity):?>
					<?php $activity['content']=unserialize($activity['content']);?>
					<tr>
						<td><?php echo $activity['balances'];?></td>
						<td><?php echo $activity['operators'].$activity['money'];?></td>
						<td><?php echo (isset($activity['content']['title']) ? $activity['content']['title'].'<br/>' : '').(isset($activity['content']['description']) ? $activity['content']['description'] : '');?></td>
						<td><?php echo $activity['date_added'];?></td>
					</tr>
					<?php endforeach;?>
					<?php endif;?>
				</tbody>
			</table>
			<?php echo $pagination;?>
			
			<?php echo $position_bottom; ?>
		</div>
		<?php echo $position_right; ?>
	</div>
</div>
<!-- /container -->
<?php echo $footer;//装载header?>