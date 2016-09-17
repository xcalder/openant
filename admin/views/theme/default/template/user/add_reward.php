<table class="table table-striped table-bordered table-hover" id="table-reward">
	<thead>
		<tr>
			<th>添加日期</th>
			<th>内容</th>
			<th>积分</th>
		</tr>
	</thead>
	<tbody>
		<?php if(isset($user_rewards)):?>
		<?php foreach($user_rewards as $user_reward):?>
		<tr>
			<td><?php echo $user_reward['date_added'];?></td>
			<td><?php echo $user_reward['description'];?></td>
			<td><?php echo $user_reward['points'];?></td>
		</tr>
		<?php endforeach;?>
		<?php endif;?>
	</tbody>
	<tfoot>
		<tr>
			<td></td>
			<td class="text-right">小计</td>
			<td class="text-right"><?php echo isset($total_rewards) ? $total_rewards : '0';?></td>
		</tr>
		<tr>
			<td colspan="3"><?php echo $rewards_pagination;?></td>
		</tr>
	</tfoot>
</table>