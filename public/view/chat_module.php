<?php $row_id = rand(100, 999);?>
<div class="c_meau hidden-xs" id="c_meau-<?php echo $row_id;?>">
	<div class="fl">
		<h4 style="cursor: pointer;"><?php echo isset($name) ? $name : '';?></h4>
		<div class="fl_o">
			<?php foreach ($chats as $chat):?>
			<dl class="fl_o_o">
				<dt> <a <?php echo !empty($chat['url']) ? 'href="'.base_url('errors/page_missing/go_to?go_to=').$chat['url'].'" target="_blank"' : '';?>> <img src="<?php echo $this->image_common->resize($chat['image'], 100, 100);?>"></a></dt>
				<dd><?php echo @$chat['title'];?></dd>
			</dl>
			<?php endforeach;?>
		</div>
	</div>
</div>

<script>
$(document).ready(function() {
	var row_id = '<?php echo $row_id;?>';
	$('#c_meau-'+row_id).attr("style", 'bottom: -'+ (parseInt($('.fl_o').height()) + 20 ) +'px;<?php echo $position.':0';?>');

	$('#c_meau-'+row_id).click(function(){
		$(this).attr("style", 'bottom: 0;<?php echo $position.':0';?>');
	});
});

$(window).scroll(function () {
	var row_id = '<?php echo $row_id;?>';
    if ($(this).scrollTop() > 100) {
        $("#c_meau-"+row_id).stop().show().animate({bottom: '200px' }, 300);
    }
    else {
        $("#c_meau-"+row_id).stop().animate({bottom: '-'+ (parseInt($('.fl_o').height()) + 20 ) +'px' }, 300);
    }
});
</script>