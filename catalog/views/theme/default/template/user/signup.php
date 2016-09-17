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
						<form action="<?php echo base_url('user/signin/signinup.html');?>" method="post" enctype="multipart/form-data" id="signup">
							<p class="text-center login-title">
							<strong><?php echo lang_line('register');?></strong><hr style="margin: 10px 0">
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
								<input type="text" id="nickname" name="nickname" value=""
								placeholder="<?php echo lang_line('nickname');?>"
								class="form-control" />
							</div>
							<!-- /password -->
							<div class="form-group form-captcha">
								<input type="text" id="captcha" name="captcha" value=""
								placeholder="<?php echo lang_line('captcha');?>"
								class="form-control" />
								<img title="<?php echo lang_line('refresh');?>"
											src="<?php echo site_url('common/captcha');?>"
											align="absbottom"
											onclick="this.src='common/captcha.html?'+Math.random();">
								</img>
							</div>
							<!-- /field -->
							<div class="form-group">
								<div class="checkbox login-checkbox">
									<label>
										<input id="agree" type="checkbox" name="agree" value="1"><?php echo lang_line('agree');?>
									</label>

									<label class="login-forget">
										<a onclick="window.open('<?php echo base_url('helper/faq.html?id=').$this->config->get_config('registration_terms');?>');"><?php echo lang_line('registration_terms');?></a>
									</label>
								</div>
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-info btn-block">
									<?php echo lang_line('register');?>
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
	//注册
	$(document).ready(function()
		{
			$("#signup").validate(
				{
					rules:
					{
						email:
						{
							required: true,
							email: true,
							remote: "user/signin/check_email_web.html"
						},
						password:
						{
							required: true,
							rangelength: [6,18],
						},
						nickname:
						{
							required: true,
							cn_edu: true,
							rangelength: [3,18],
						},
						captcha:
						{
							required: true,
							rangelength:[4,4],
							remote: "common/captcha/veri.html"
						},
						agree:
						{
							required: true,
						}
					},
					messages:
					{
						email:
						{
							required: "<?php echo lang_line('email');?>",
							email: "<?php echo lang_line('error_email');?>",
							remote: "<?php echo lang_line('error_registered');?>"
						},
						password:
						{
							required: "<?php echo lang_line('password');?>",
							equalTo: "<?php echo lang_line('error_password');?>"
						},
						nickname:
						{
							required: "<?php echo lang_line('nickname');?>",
							cn_edu: "<?php echo lang_line('error_nickname');?>",
							rangelength: "<?php echo lang_line('error_nickname');?>",
						},
						captcha:
						{
							required: "<?php echo lang_line('captcha');?>",
							rangelength: "<?php echo lang_line('error_captcha_lenght');?>",
							remote: "<?php echo lang_line('error_captcha');?>"
						},
						agree:
						{
							required: "<?php echo lang_line('agree');?>",
						},
					},
					errorPlacement: function(error, element)
					{
						if ( element.is(":checkbox") )
						error.appendTo ( element.parent().parent().parent() );
						else
						error.insertAfter(element);
					}
				});
		});
</script>