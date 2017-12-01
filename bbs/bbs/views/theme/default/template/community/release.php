<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
  <div class="row"><?php echo $position_left;?>
	<?php if ($position_left && $position_right):?>
	<?php $class = 'col-sm-6'; ?>
	<?php elseif ($position_left || $position_right):?>
	<?php $class = 'col-sm-9'; ?>
	<?php else:?>
	<?php $class = 'col-sm-12'; ?>
	<?php endif;?>
    <div id="middle" class="<?php echo $class; ?>">
    <?php echo $position_top; ?>
    
    <form action="<?php echo $action;?>" method="post" enctype="multipart/form-data">
    	<div class="well well-sm" style="color: #b7b7b7">*明确的主题能让你的问题有更多的曝光机会，更容易得到论坛成员的解答</div>
	  <div class="form-group">
	    <label for="re-plate" style="font-weight: 100;">选择一个主题</label>
	    <select class="form-control" name="plate_id" id="re-plate">
	    	<?php if($plates):?>
	    	<?php foreach($plates as $plate):?>
	    	<?php if(isset($posting['plate_id']) && $plate['plate_id'] == $posting['plate_id']):?>
	    	<option value="<?php echo $plate['plate_id'];?>" selected><?php echo $plate['title'];?></option>
	    	<?php else:?>
	    	<option value="<?php echo $plate['plate_id'];?>"><?php echo $plate['title'];?></option>
	    	<?php endif;?>
	    	<?php endforeach;?>
	    	<?php endif;?>
	    </select>
	  </div>
	  <div class="well well-sm" style="color: #b7b7b7">*请使用简短概括的一句话来描述你遇到的问题<br/>*标题不要超过35个字符，超出的部分将会被截断</div>
	  <div class="form-group">
	  	<label for="re-plate" style="font-weight: 100;">请输入一个概括性的标题</label>
	    <input type="text" class="form-control" name="title" id="re-title" placeholder="请输入一个概括性的标题" value="<?php echo isset($posting) ? $posting['title'] : '';?>">
	  </div>
	  <div class="well well-sm" style="color: #b7b7b7">*请文明回帖，激烈讨论！<br/>*单张图片上传最大200kb<br/>*回帖内容10——2000字符内</div>
	  <div class="form-group">
	    <label for="re_description" style="font-weight: 100;color: #b7b7b7">描述你的内容</label>
	    <textarea rows="10" id="re_description" name="description" class="form-control" placeholder="<?php echo ($this->user->isLogged() == TRUE) ? '描述内容，最多2000个字"' : '请先登陆！" disabled="disabled"';?>"><?php echo isset($posting) ? htmlspecialchars_decode($posting['description']) : '';?></textarea>
	  </div>
	  <button type="submit" id="re_description-submit" class="btn btn-sm btn-info" <?php echo $this->user->isLogged() ? '' : 'disabled';?>>发布</button>&nbsp;Ctrl+Enter
	</form>
    
    <?php echo $position_bottom; ?>
    </div>
    <?php echo $position_right; ?>
  </div>
  <script type="text/javascript">
  	$('#re_description').keypress(function(e){
		if(e.ctrlKey && e.which == 13 || e.which == 10) {
			$('#re_description-submit').click();
		}
	});

	$(document).ready(function ()
	{
		$('#re_description').summernote(
		{
			height: 200,                 // set editor height
		});
	});
  </script>
  <!-- /row --> 
</div>
<!-- /container -->
<?php echo $footer;//装载header?>