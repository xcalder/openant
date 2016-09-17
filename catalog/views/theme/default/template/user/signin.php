<?php echo $header;//装载header?>
<?php echo $login_top;//装载top?>
<div class="container">
	<div class="row">
		<div id="middle" class="col-sm-12">
			<?php echo $position_top; ?>
			<div class="col-sm-9 hidden-xs hidden-sm" style="padding-left:0">
				<?php echo $position_bottom; ?>
			</div>
			<?php echo $position_left;?>
			<div class="col-sm-3 panel panel-default middle-flat-left">
				<div class="panel-body">
					<form action="<?php echo base_url('user/signin/login.html');?>?url=<?php echo $this->input->get('url')?>" method="post" enctype="multipart/form-data" id="signin">
						<p class="text-center login-title">
						<strong><?php echo lang_line('login');?></strong><hr style="margin: 10px 0">
						<div class="form-group error">
						</div>
						<div class="form-group">
							<input type="text" id="email" name="email" value=""
							placeholder="<?php echo lang_line('email');?>"
							class="form-control" />
						</div>
						<!-- /field -->
						<div class="form-group">
							<input type="password" id="password" name="password" value=""
							placeholder="<?php echo lang_line('password');?>"
							class="form-control" />
						</div>
						<!-- /password -->
						<div class="form-group">
							<a href="user/forget.html">
								<?php echo lang_line('forget');?>
							</a>
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-info btn-block">
								<?php echo lang_line('login');?>
							</button>
						</div>
						<!-- .actions -->
					</form>
				</div>
				<div class="modal-footer mylogin-footer" style="text-align: center; padding-left: 0; padding-right: 0">
					<?php
					foreach($sign_ins as $key=>$value):?>
					<a onclick="with_login('<?php echo $key;?>');">
						<img width="32px" height="32px" class="lazy"
						data-original="public/resources/default/image/login_ico/<?php echo $value['setting']['image'];?>"
						data-toggle="tooltip" data-placement="top"
						title="<?php echo $value['setting']['extra'];?>">
					</a>
					<?php endforeach;?>
				</div>
			</div>
			<?php echo $position_right; ?>
		</div>
	</div>
</div>

<?php
if(isset($error_times)):?>
<script type="text/javascript">
	$(document).ready(function () {$.notify({message: '<?php echo $error_times;?>' },{type: 'danger'});});
</script><?php endif;?>
<?php
if(isset($message)):?>
<script type="text/javascript">
	$(document).ready(function () {$.notify({message: '<?php echo $message;?>' },{type: 'message'});});
</script><?php endif;?>
<?php
if(isset($error_check)):?>
<script type="text/javascript">
	$(document).ready(function () {$.notify({message: '<?php echo $error_check;?>' },{type: 'warning'});});
</script><?php endif;?>
<?php
if(isset($_SESSION['warning'])):?>
<script type="text/javascript">
	$(document).ready(function () {$.notify({message: '<?php echo $_SESSION['warning'];?>' },{type: 'warning'});});
</script><?php endif;?>

<?php echo $login_footer;?>
<script>
	//第三方登陆
	function with_login(key)
	{
		window.open ('user/sns/session/'+key+'.html','newwindow','height=400,width=400,top=0,left=0,toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no');
	}

	//登陆
	$(document).ready(function()
		{
			$("#signin").validate(
				{
					rules:
					{
						email:
						{
							required: true,
							email: true
						},
						password:
						{
							required: true,
							rangelength: [6,18],
						}
					},
					messages:
					{
						email:
						{
							required: "<?php echo lang_line('email');?>",
							email: "<?php echo lang_line('error_email');?>"
						},
						password:
						{
							required: "<?php echo lang_line('password');?>",
							rangelength: "<?php echo lang_line('error_password');?>"
						}
					}
				});
		});
</script>