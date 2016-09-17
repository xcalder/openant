<table class="table table-striped table-bordered table-hover" id="table-transaction">
	<thead>
		<tr>
			<th>添加日期</th>
			<th>内容</th>
			<th>金额</th>
		</tr>
	</thead>
	<tbody>
		<?php if(isset($user_transactions)):?>
		<?php foreach($user_transactions as $user_transaction):?>
		<tr>
			<td><?php echo $user_transaction['date_added'];?></td>
			<td><?php echo $user_transaction['description'];?></td>
			<td><?php echo $this->currency->Compute($user_transaction['amount']);?></td>
		</tr>
		<?php endforeach;?>
		<?php endif;?>
	</tbody>
	<tfoot>
		<tr>
			<td></td>
			<td class="text-right">小计</td>
			<td class="text-right"><?php echo isset($total_amount) ? $this->currency->Compute($total_amount) : $this->currency->Compute('0');?></td>
		</tr>
		<tr>
			<td colspan="3"><?php echo $transactions_pagination;?></td>
		</tr>
	</tfoot>
</table>