<table class="table table-striped table-bordered table-hover" id="table-history">
	<thead>
		<tr>
			<th>
				添加日期
			</th>
			<th>
				内容
			</th>
		</tr>
	</thead>
	<tbody>
		<?php
		if(isset($user_historys)):?>
		<?php
		foreach($user_historys as $user_history):?>
		<tr>
			<td>
				<?php echo $user_history['date_added'];?>
			</td>
			<td>
				<?php echo $user_history['comment'];?>
			</td>
		</tr>
		<?php endforeach;?>
		<?php endif;?>
	</tbody>
	<tfoot>
		<td colspan="2">
			<?php echo $history_pagination;?>
		</td>
	</tfoot>
</table>