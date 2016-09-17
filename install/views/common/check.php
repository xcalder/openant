<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
  <div class="row">
  	<form action="<?php echo site_url('common/install');?>" method="post" enctype="multipart/form-data" id="install">
    	<div id="middle" class="col-sm-12">
	    	<p><strong>1.检查PHP配置</strong>请确保你的PHP设置满足以下配置</p><hr>
	    	<div class="well well-sm">
	    		<table class="table" style="margin-bottom: 0">
	    			<thead>
	    				<tr>
	    					<td>PHP设置名称</td>
	    					<td>当前设置</td>
	    					<td>安装需求</td>
	    					<td>状态</td>
	    				</tr>
	    			</thead>
	    			<tbody>
	    				<tr>
	    					<td>PHP版本</td>
	    					<td><?php echo phpversion();?></td>
	    					<td>5.4+</td>
	    					<td><?php echo (phpversion() > '5.4.0') ? '<i class="glyphicon glyphicon-ok"></i><input type="hidden" name="phpversion" value="1">' : '<i class="glyphicon glyphicon-remove"></i>';?></td>
	    				</tr>
	    				<tr>
	    					<td>注册全局</td>
	    					<td><?php echo ini_get('register_globals') ? 'on' : 'off';?></td>
	    					<td>off</td>
	    					<td><?php echo ini_get('register_globals') ? '<i class="glyphicon glyphicon-remove"></i>' : '<i class="glyphicon glyphicon-ok"></i><input type="hidden" name="register_globals" value="1">';?></td>
	    				</tr>
	    				<tr>
	    					<td>魔术函数</td>
	    					<td><?php echo ini_get('magic_quotes_gpc') ? 'on' : 'off';?></td>
	    					<td>off</td>
	    					<td><?php echo ini_get('magic_quotes_gpc') ? '<i class="glyphicon glyphicon-remove"></i>' : '<i class="glyphicon glyphicon-ok"></i><input type="hidden" name="magic_quotes_gpc" value="1">';?></td>
	    				</tr>
	    				<tr>
	    					<td>文件上传</td>
	    					<td><?php echo ini_get('file_uploads') ? 'on' : 'off';?></td>
	    					<td>on</td>
	    					<td><?php echo ini_get('file_uploads') ? '<i class="glyphicon glyphicon-ok"></i><input type="hidden" name="file_uploads" value="1">' : '<i class="glyphicon glyphicon-remove"></i>';?></td>
	    				</tr>
	    				<tr>
	    					<td>自动启用session</td>
	    					<td><?php echo ini_get('session_auto_start') ? 'on' : 'off';?></td>
	    					<td>off</td>
	    					<td><?php echo ini_get('session_auto_start') ? '<i class="glyphicon glyphicon-remove"></i>' : '<i class="glyphicon glyphicon-ok"></i><input type="hidden" name="session_auto_start" value="1">';?></td>
	    				</tr>
	    				
	    			</tbody>
	    		</table>
	    	</div>
	    	
	    	<p><strong>2.检查PHP扩展</strong>请确保你的PHP扩展满足以下配置</p><hr>
	    	<div class="well well-sm">
	    		<table class="table" style="margin-bottom: 0">
	    			<thead>
	    				<tr>
	    					<td>PHP扩展名称</td>
	    					<td>当前设置</td>
	    					<td>安装需求</td>
	    					<td>状态</td>
	    				</tr>
	    			</thead>
	    			<tbody>
	    				<tr>
	    					<td>数据库</td>
	    					<td><?php echo $db ? 'on' : 'off';?></td>
	    					<td>on</td>
	    					<td><?php echo $db ? '<i class="glyphicon glyphicon-ok"></i><input type="hidden" name="db" value="1">' : '<i class="glyphicon glyphicon-remove"></i>';?></td>
	    				</tr>
	    				<tr>
	    					<td>PHP GD库</td>
	    					<td><?php echo extension_loaded('gd') ? 'on' : 'off';?></td>
	    					<td>on</td>
	    					<td><?php echo extension_loaded('gd') ? '<i class="glyphicon glyphicon-ok"></i><input type="hidden" name="gd" value="1">' : '<i class="glyphicon glyphicon-remove"></i>';?></td>
	    				</tr>
	    				<tr>
	    					<td>CURL扩展</td>
	    					<td><?php echo extension_loaded('curl') ? 'on' : 'off';?></td>
	    					<td>on</td>
	    					<td><?php echo extension_loaded('curl') ? '<i class="glyphicon glyphicon-ok"></i><input type="hidden" name="curl" value="1">' : '<i class="glyphicon glyphicon-remove"></i>';?></td>
	    				</tr>
	    				<tr>
	    					<td>mcrypt_encrypt 扩展</td>
	    					<td><?php echo function_exists('mcrypt_encrypt') ? 'on' : 'off';?></td>
	    					<td>on</td>
	    					<td><?php echo function_exists('mcrypt_encrypt') ? '<i class="glyphicon glyphicon-ok"></i><input type="hidden" name="mcrypt_encrypt" value="1">' : '<i class="glyphicon glyphicon-remove"></i>';?></td>
	    				</tr>
	    				<tr>
	    					<td>zlib 扩展</td>
	    					<td><?php echo extension_loaded('zlib') ? 'on' : 'off';?></td>
	    					<td>on</td>
	    					<td><?php echo extension_loaded('zlib') ? '<i class="glyphicon glyphicon-ok"></i><input type="hidden" name="zlib" value="1">' : '<i class="glyphicon glyphicon-remove"></i>';?></td>
	    				</tr>
	    				<tr>
	    					<td>zip 扩展</td>
	    					<td><?php echo extension_loaded('zip') ? 'on' : 'off';?></td>
	    					<td>on</td>
	    					<td><?php echo extension_loaded('zip') ? '<i class="glyphicon glyphicon-ok"></i><input type="hidden" name="zip" value="1">' : '<i class="glyphicon glyphicon-remove"></i>';?></td>
	    				</tr>
	    			</tbody>
	    		</table>
	    	</div>
	    	
	    	<p><strong>3.文件权限检查</strong>请确保下列文件权限状态为可写</p><hr>
	    	<div class="well well-sm">
	    		<table class="table" style="margin-bottom: 0">
	    			<thead>
	    				<tr>
	    					<td>文件</td>
	    					<td>状态</td>
	    				</tr>
	    			</thead>
	    			<tbody>
	    				<tr>
	    					<td><?php echo FCPATH.'catalog/config/config.php';?></td>
	    					<td><?php echo file_exists(FCPATH . 'catalog/config/config.php') ? (is_writable(FCPATH . 'catalog/config/config.php') ? '可写<input type="hidden" name="c_config" value="1">' : '只读') : '不存在';?></td>
	    				</tr>
	    				<tr>
	    					<td><?php echo FCPATH.'catalog/config/database.php';?></td>
	    					<td><?php echo file_exists(FCPATH . 'catalog/config/database.php') ? (is_writable(FCPATH . 'catalog/config/database.php') ? '可写<input type="hidden" name="c_db" value="1">' : '只读') : '不存在';?></td>
	    				</tr>
	    				<tr>
	    					<td><?php echo FCPATH.'admin/config/config.php';?></td>
	    					<td><?php echo file_exists(FCPATH . 'admin/config/config.php') ? (is_writable(FCPATH . 'admin/config/config.php') ? '可写<input type="hidden" name="a_config" value="1">' : '只读') : '不存在';?></td>
	    				</tr>
	    				<tr>
	    					<td><?php echo FCPATH.'admin/config/database.php';?></td>
	    					<td><?php echo file_exists(FCPATH . 'admin/config/database.php') ? (is_writable(FCPATH . 'admin/config/database.php') ? '可写<input type="hidden" name="a_db" value="1">' : '只读') : '不存在';?></td>
	    				</tr>
	    				<tr>
	    					<td><?php echo FCPATH.'sale/config/config.php';?></td>
	    					<td><?php echo file_exists(FCPATH . 'sale/config/config.php') ? (is_writable(FCPATH . 'sale/config/config.php') ? '可写<input type="hidden" name="s_config" value="1">' : '只读') : '不存在';?></td>
	    				</tr>
	    				<tr>
	    					<td><?php echo FCPATH.'sale/config/database.php';?></td>
	    					<td><?php echo file_exists(FCPATH . 'sale/config/database.php') ? (is_writable(FCPATH . 'sale/config/database.php') ? '可写<input type="hidden" name="s_db" value="1">' : '只读') : '不存在';?></td>
	    				</tr>
	    			</tbody>
	    		</table>
	    	</div>
	    	<p><strong>3.目录权限检查</strong>请确保下列目录权限状态为可写</p><hr>
	    	<div class="well well-sm">
	    		<table class="table" style="margin-bottom: 0">
	    			<thead>
	    				<tr>
	    					<td>目录</td>
	    					<td>状态</td>
	    				</tr>
	    			</thead>
	    			<tbody>
	    				<tr>
	    					<td><?php echo FCPATH.'image/';?></td>
	    					<td><?php echo is_writable(FCPATH . 'image') ? '可写<input type="hidden" name="image" value="1">' : '不可写';?></td>
	    				</tr>
	    				<tr>
	    					<td><?php echo FCPATH.'upload/';?></td>
	    					<td><?php echo is_writable(FCPATH . 'upload') ? '可写<input type="hidden" name="upload" value="1">' : '不可写';?></td>
	    				</tr>
	    			</tbody>
	    		</table>
	    	</div>
    	</div>
    	<div class="col-sm-6" style="margin-top: 15px">
	    	<button type="submit" class="btn btn-success">继续安装</button>
	    </div>
	    <div class="col-sm-6" style="margin-top: 15px;">
	    	<a href="<?php echo base_url().'install.php'?>" class="btn btn-warning" style="float: right;">上一步</a>
	    </div>
    </form>
  </div>
  <script>
	$(".ystep1").loadStep({
		//ystep的外观大小
		//可选值：small,large
		size: "small",
		//ystep配色方案
		//可选值：green,blue
		color: "green",
		//ystep中包含的步骤
		steps: [{
				//步骤名称
				title: "第一步",
				//步骤内容(鼠标移动到本步骤节点时，会提示该内容)
				content: "同意免费授权协议并继续"
			},{
				title: "第二步",
				content: "检查系统安装环境"
			},{
				title: "第三步",
				content: "设置初始密码和系统配置"
			},{
				title: "第四步",
				content: "完成安装"
			}]
		});
	$(".ystep1").setStep(2);
  </script>
  <style type="text/css">
  	.container .text{
		padding: 1px 0 !important;
	}
  </style>
  <!-- /row --> 
</div>
<!-- /container -->
<?php echo $footer;//装载header?>