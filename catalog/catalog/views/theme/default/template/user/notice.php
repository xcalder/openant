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
			
			<div class="row" style="margin: 0">
				<?php if(isset($notices)):?>
				<div id="accordion" class="text-left">
					<?php foreach ($notices as $notice):?>
					<a data-toggle="collapse" data-parent="#accordion" href="#collapse-<?php echo $notice['id'];?>" <?php echo ($notice['read'] == '0') ? "onclick="."o_read('".$notice['id']."')" : '';?>><?php echo ($notice['read'] == '1') ? '<i class="glyphicon glyphicon-eye-open"></i>' : '<i class="glyphicon glyphicon-eye-close"></i>'?>&nbsp;&nbsp;&nbsp;<?php echo $notice['title'];?><span class="pull-right"><?php echo $notice['date_added'];?>&nbsp;&nbsp;<span class="caret"></span></span></a>
					<div id="collapse-<?php echo $notice['id'];?>" class="panel-collapse collapse" style="text-indent: 2em;"><?php echo $notice['msg'];?></div><hr style="margin: 4px 0">
					<?php endforeach;?>
				</div>
				<?php endif;?>
				
				<?php echo $pagination;?>
					
			</div>
			<!-- /widget -->
			<?php echo $position_bottom; ?>
		</div>
		<?php echo $position_right; ?>
	</div>
	<script type="text/javascript">
		function o_read(id){
			//已读
			$.get('<?php echo $this->config->item('catalog').'/user/notice/o_read?id='?>' + id);
		}
	</script>
	<!-- /row --> 
</div>
<!-- /container -->
<?php echo $footer;//装载header?>