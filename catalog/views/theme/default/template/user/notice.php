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
			
			<div class="row" style="margin: 0" id="category-product-list">
				<?php if(isset($notices)):?>
				
				<?php if($position_left && $position_right):?>
				<?php $class = 'col-sm-6'; ?>
				<?php elseif($position_left || $position_right):?>
				<?php $class = 'col-sm-4'; ?>
				<?php else:?>
				<?php $class = 'col-sm-3'; ?>
				<?php endif;?>
				
				<table class="<?php echo $class;?> table">
					<tbody>
					<?php foreach($notices as $notice):?>
						<tr>
							<?php if($notice['read'] == '1'):?>
							<td><span class="label label-default">已读</span></td>
							<?php else:?>
							<td><span class="label label-info">未读</span></td>
							<?php endif;?>
							<td><?php echo $notice['message'];?></td>
							<td><?php echo $notice['date_added'];?></td>
						</tr>
					<?php endforeach;?>
					</tbody>
				</table>
				<?php endif;?>
				
				<?php echo $pagination;?>
					
			</div>
			<!-- /widget -->
			<?php echo $position_bottom; ?>
		</div>
		<?php echo $position_right; ?>
	</div>
	<!-- /row --> 
</div>
<!-- /container -->
<?php echo $footer;//装载header?>