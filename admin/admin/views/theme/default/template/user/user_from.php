<?php echo $header;//装载header?>
<?php echo $top;//装载login_top?>
<!-- /subnavbar -->
<div class="container">
	<div class="row">
		<div class="col-md-12 middle-flat-left" role="main">
			<div class="panel panel-default">
				<div class="panel-heading row row-panel-heading bg-info">
					<p class="navbar-left"><i class="glyphicon glyphicon-th-list"></i>会员活动</p>
					<div class="navbar-right btn-group" role="group" aria-label="..." style="margin-right: 0">
						<button type="button" onclick="submit('form-user-edit')" class="btn btn-sm btn-default">
							<i class="glyphicon glyphicon-floppy-save">
							</i>
						</button>
						<a href="<?php echo $this->config->item('admin').'user/user';?>" class="btn btn-sm btn-default">
							<i class="glyphicon glyphicon-share-alt">
							</i>
						</a>
					</div>
				</div>
				<!-- /widget-header -->
				<div class="panel-body page-tab">
					<form action="<?php echo $action;?>" method="post" enctype="multipart/form-data" id="form-user-edit" class="form-horizontal">
						<ul class="nav nav-tabs">
							<li class="active">
								<a href="#tab-general" data-toggle="tab">
									基本信息
								</a>
							</li>
							<li>
								<a href="#tab-address" data-toggle="tab">
									地址簿
								</a>
							</li>
							<li>
								<a href="#tab-history" data-toggle="tab">
									历史
								</a>
							</li>
							<li>
								<a href="#tab-transaction" data-toggle="tab">
									交易
								</a>
							</li>
							<li>
								<a href="#tab-reward" data-toggle="tab">
									积分
								</a>
							</li>
							
							<li>
								<a href="#tab-competence" data-toggle="tab">
									权限管理
								</a>
							</li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="tab-general">
								<div class="form-group">
									<label class="col-sm-2 control-label" for="image">
										头像
									</label>
									<div class="col-sm-10">
										<a href="" id="thumb-image" data-toggle="admin-image" class="img-thumbnail">
											<img  width="100px" height="100px" class="lazy" data-original="<?php echo isset($image) ? $image : $placeholder_image;?>" alt="头像" title="头像" data-placeholder="<?php echo $placeholder_image;?>" />
										</a>
										<input type="hidden" name="user[image]" value="<?php echo $image_old;?>" id="input-image" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="user_group_id">
										权限组
									</label>
									<div class="col-sm-10">
										<select class="form-control" id="user-group" name="user[user_group_id]">
											<option value="">
												--无--
											</option>
											<?php
											if(isset($user_groups)):?>
											<?php
											foreach($user_groups as $user_group):?>
											<?php
											if($user_group_id == $user_group['user_group_id']):?>
											<option value="<?php echo $user_group['user_group_id']?>" selected>
												<?php echo $user_group['name']?>
											</option>
											<?php
											else:?>
											<option value="<?php echo $user_group['user_group_id']?>">
												<?php echo $user_group['name']?>
											</option>
											<?php endif;?>
											<?php endforeach;?>
											<?php endif;?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="user_class_id">
										买家组
									</label>
									<div class="col-sm-10">
										<select class="form-control" id="user-group" name="user[user_class_id]">
											<option value="">
												--无--
											</option>
											<?php
											if(isset($user_classs)):?>
											<?php
											foreach($user_classs as $user_class):?>
											<?php
											if($user_class_id == $user_class['user_class_id']):?>
											<option value="<?php echo $user_class['user_class_id']?>" selected>
												<?php echo $user_class['name']?>
											</option>
											<?php
											else:?>
											<option value="<?php echo $user_class['user_class_id']?>">
												<?php echo $user_class['name']?>
											</option>
											<?php endif;?>
											<?php endforeach;?>
											<?php endif;?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="nickname">
										<span style="color: red">
											*
										</span>&nbsp;昵称
									</label>
									<div class="col-sm-10">
										<input type="text" name="user[nickname]" class="form-control" id="nickname" placeholder="昵称" value="<?php echo $nickname;?>">
										<label style="color: red">
											<?php echo $error_nickname;?>
										</label>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="firstname">
										<span style="color: red">
											*
										</span>&nbsp;姓氏
									</label>
									<div class="col-sm-10">
										<input type="text" name="user[firstname]" class="form-control" id="firstname" placeholder="姓氏" value="<?php echo $firstname;?>">
										<label style="color: red">
											<?php echo $error_firstname;?>
										</label>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="lastname">
										名字
									</label>
									<div class="col-sm-10">
										<input type="text" name="user[lastname]" class="form-control" id="lastname" placeholder="名字" value="<?php echo $lastname;?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="email">
										<span style="color: red">
											*
										</span>&nbsp;EMAIL
									</label>
									<div class="col-sm-10">
										<input type="text" name="user[email]" class="form-control" id="email" placeholder="邮箱" value="<?php echo $email;?>">
										<label style="color: red">
											<?php echo $error_email;?>
										</label>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="telephone">
										手机号
									</label>
									<div class="col-sm-10">
										<input type="text" name="user[telephone]" class="form-control" id="telephone" placeholder="手机号" value="<?php echo $telephone;?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="password">
										密码
									</label>
									<div class="col-sm-10">
										<input type="text" name="user[password]" class="form-control" id="password" placeholder="密码" value="">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="newsletter">
										订阅
									</label>
									<div class="col-sm-10">
										<select class="form-control" id="newsletter" name="user[newsletter]">
											<?php
											if($newsletter == '0'):?>
											<option value="1">
												是
											</option>
											<option value="0" selected>
												否
											</option>
											<?php
											elseif($newsletter == '1'):?>
											<option value="1" selected>
												是
											</option>
											<option value="0">
												否
											</option>
											<?php
											else:?>
											<option value="1" selected>
												是
											</option>
											<option value="0">
												否
											</option>
											<?php endif;?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="status">
										状态
									</label>
									<div class="col-sm-10">
										<select class="form-control" id="status" name="user[status]">
											<?php
											if($status == '0'):?>
											<option value="1">
												启用
											</option>
											<option value="0" selected>
												停用
											</option>
											<?php
											elseif($status == '1'):?>
											<option value="1" selected>
												启用
											</option>
											<option value="0">
												停用
											</option>
											<?php
											else:?>
											<option value="1" selected>
												启用
											</option>
											<option value="0">
												停用
											</option>
											<?php endif;?>
										</select>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-2 control-label" for="safe">
										安全
									</label>
									<div class="col-sm-10">
										<select class="form-control" id="safe" name="user[safe]">
											<?php
											if($safe == '0'):?>
											<option value="1">
												启用
											</option>
											<option value="0" selected>
												停用
											</option>
											<?php
											elseif($safe == '1'):?>
											<option value="1" selected>
												启用
											</option>
											<option value="0">
												停用
											</option>
											<?php
											else:?>
											<option value="1">
												启用
											</option>
											<option value="0" selected>
												停用
											</option>
											<?php endif;?>
										</select>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="tab-address">
								<div class="col-md-2">
									<ul class="nav nav-pills nav-stacked">
										<?php $row_id = 1;?>
										<?php
										if($addresss):?>
										<?php
										foreach($addresss as $address):?>
										<li class="nav-address<?php echo $row_id;?>">
											<a href="#address<?php echo $row_id;?>" data-toggle="tab" style="padding: 5px 10px;font-size: 12px">
												<span onclick="remove_address('nav-address<?php echo $row_id;?>','address<?php echo $row_id;?>');" class="glyphicon glyphicon-remove-circle">
												</span>地址<?php echo $row_id;?>
											</a>
										</li>
										<?php $row_id++;?>
										<?php endforeach;?>
										<?php endif;?>
										<li class="nav-address">
											<a onclick="add_address();" style="cursor: pointer;padding: 5px 10px;font-size: 12px">添加一个新地址</a>
										</li>
									</ul>
								</div>
								<div class="col-md-10">
									<div class="tab-content address">
										<?php $row_id_ = 1;?>
										<?php
										if($addresss):?>
										<?php
										foreach($addresss as $address):?>
										<div class="tab-pane" id="address<?php echo $row_id_;?>">
											<div class="form-group">
												<label class="col-sm-2 control-label" for="firstname<?php echo $row_id_;?>"><span style="color: red">*</span>姓氏</label>
												<div class="col-sm-10">
													<input type="text" name="address[<?php echo $address['address_id']?>][firstname]" class="form-control" id="firstname<?php echo $row_id_;?>" placeholder="姓氏" value="<?php echo isset($post_address[$address['address_id']]['firstname']) ? $post_address[$address['address_id']]['firstname'] : $address['firstname'];?>">
													<lable style="color: red;">
														<?php echo isset($error_address[$address['address_id']]['error_firstname']) ? $error_address[$address['address_id']]['error_firstname'] : '';?>
													</lable>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-2 control-label" for="lastname<?php echo $row_id_;?>">名字</label>
												<div class="col-sm-10">
													<input type="text" name="address[<?php echo $address['address_id']?>][lastname]" class="form-control" id="lastname<?php echo $row_id_;?>" placeholder="名字" value="<?php echo isset($post_address[$address['address_id']]['lastname']) ? $post_address[$address['address_id']]['lastname'] : $address['lastname'];?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-2 control-label" for="address<?php echo $row_id_;?>"><span style="color: red">*</span>地址</label>
												<div class="col-sm-10">
													<input type="text" name="address[<?php echo $address['address_id']?>][address]" class="form-control" id="address<?php echo $row_id_;?>" placeholder="详细地址" value="<?php echo isset($post_address[$address['address_id']]['address']) ? $post_address[$address['address_id']]['address'] : $address['address'];?>">
													<lable style="color: red;">
														<?php echo isset($error_address[$address['address_id']]['error_address']) ? $error_address[$address['address_id']]['error_address'] : '';?>
													</lable>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-2 control-label" for="city<?php echo $row_id_;?>"><span style="color: red">*</span>城市</label>
												<div class="col-sm-10">
													<input type="text" name="address[<?php echo $address['address_id']?>][city]" class="form-control" id="city<?php echo $row_id_;?>" placeholder="所在城市" value="<?php echo isset($post_address[$address['address_id']]['city']) ? $post_address[$address['address_id']]['city'] : $address['city'];?>">
													<lable style="color: red;">
														<?php echo isset($error_address[$address['address_id']]['error_city']) ? $error_address[$address['address_id']]['error_city'] : '';?>
													</lable>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-2 control-label" for="input-postcode<?php echo $row_id_;?>">邮编</label>
												<div class="col-sm-10">
													<input type="text" name="address[<?php echo $address['address_id']?>][postcode]" class="form-control" id="input-postcode<?php echo $row_id_;?>" placeholder="邮编" value="<?php echo isset($post_address[$address['address_id']]['postcode']) ? $post_address[$address['address_id']]['postcode'] : $address['postcode'];?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-2 control-label" for="input-country<?php echo $row_id_; ?>">
													<span style="color: red">
														*
													</span>&nbsp;国家
												</label>
												<div class="col-sm-10">
													<select class="form-control" id="input-country<?php echo $row_id_?>" onchange="country(this, '<?php echo $address['address_id']; ?>', '<?php echo $address['zone_id']; ?>');" name="address[<?php echo $address['address_id']?>][country_id]" class="form-control">
														<option value="">
															--无--
														</option>
														<?php
														if($countrys):?>
														<?php
														foreach($countrys as $country):?>
														<?php
														if($country['country_id'] == $address['country_id']):?>
														<option value="<?php echo $address['country_id']?>" selected="selected">
															<?php echo $country['name'];?>
														</option>
														<?php
														else:?>
														<option value="<?php echo $country['country_id']?>">
															<?php echo $country['name'];?>
														</option>
														<?php endif;?>
														<?php endforeach;?>
														<?php endif;?>
													</select>
													<lable style="color: red;">
														<?php echo isset($error_address[$address['address_id']]['error_country']) ? $error_address[$address['address_id']]['error_country'] : '';?>
													</lable>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-2 control-label" for="input-zone<?php echo $row_id_;?>">
													<span style="color: red">
														*
													</span>&nbsp;省份
												</label>
												<div class="col-sm-10">
													<select name="address[<?php echo $address['address_id']?>][zone_id]" id="input-zone<?php echo $row_id_; ?>" class="form-control">
													</select>
													<lable style="color: red;">
														<?php echo isset($error_address[$address['address_id']]['error_zone']) ? $error_address[$address['address_id']]['error_zone'] : '';?>
													</lable>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-2 control-label" for="input-default<?php echo $row_id_;?>">
													设为默认地址
												</label>
												<div class="col-sm-10">
													<?php
													if(isset($post_address[$address['address_id']]['default']) && $post_address[$address['address_id']]['default'] == '1'):?>
													<label class="radio-inline">
														<input type="radio" name="address[<?php echo $address['address_id']?>][default]" id="input-default<?php echo $row_id_;?>" value="1" checked/>是
													</label>
													<label class="radio-inline">
														<input type="radio" name="address[<?php echo $address['address_id']?>][default]" id="input-default<?php echo $row_id_;?>" value="0"/>否
													</label>
													<?php
													elseif(isset($post_address[$address['address_id']]['default']) && $post_address[$address['address_id']]['default'] == '0'):?>
													<label class="radio-inline">
														<input type="radio" name="address[<?php echo $address['address_id']?>][default]" id="input-default<?php echo $row_id_;?>" value="1"/>是
													</label>
													<label class="radio-inline">
														<input type="radio" name="address[<?php echo $address['address_id']?>][default]" id="input-default<?php echo $row_id_;?>" value="0" checked/>否
													</label>
													<?php
													else:?>
													<label class="radio-inline">
														<input type="radio" name="address[<?php echo $address['address_id']?>][default]" id="input-default<?php echo $row_id_;?>" value="1"/>是
													</label>
													<label class="radio-inline">
														<input type="radio" name="address[<?php echo $address['address_id']?>][default]" id="input-default<?php echo $row_id_;?>" value="0" checked/>否
													</label>
													<?php endif;?>
												</div>
											</div>
										</div>
										<?php $row_id_++?>
										<?php endforeach;?>
										<?php endif;?>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="tab-history">
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
											<?php echo isset($history_pagination) ? $history_pagination : '';?>
										</td>
									</tfoot>
								</table>
								<div class="form-group well" style="margin-left: 0;margin-right: 0;margin-bottom: 0">
									<label class="col-sm-2 control-label" for="user-history">
										内容
									</label>
									<div class="col-sm-10">
										<textarea class="form-control" rows="3" id="user-history" name="user_history[comment]" placeholder="昵称"></textarea>
									</div>
									<div class="col-sm-12 text-right" style="margin-top: 15px">
										<button type="button" onclick="add_history();" id="user-history" class="btn btn-sm">
											提交
										</button>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="tab-transaction">
								<div class="tab-pane" id="tab-history">
									<table class="table table-striped table-bordered table-hover" id="table-transaction">
										<thead>
											<tr>
												<th>
													添加日期
												</th>
												<th>
													内容
												</th>
												<th>
													金额
												</th>
											</tr>
										</thead>
										<tbody>
											<?php
											if(isset($user_transactions)):?>
											<?php
											foreach($user_transactions as $user_transaction):?>
											<tr>
												<td>
													<?php echo $user_transaction['date_added'];?>
												</td>
												<td>
													<?php echo $user_transaction['description'];?>
												</td>
												<td>
													<?php echo $this->currency->Compute($user_transaction['amount']);?>
												</td>
											</tr>
											<?php endforeach;?>
											<?php endif;?>
										</tbody>
										<tfoot>
											<tr>
												<td colspan="2" class="text-right">
													小计
												</td>
												<td class="text-right">
													<?php echo isset($total_amount) ? $this->currency->Compute($total_amount) : $this->currency->Compute('0');?>
												</td>
											</tr>
											<tr>
												<td colspan="3">
													<?php echo isset($transactions_pagination) ? $transactions_pagination : '';?>
												</td>
											</tr>
										</tfoot>
									</table>
									<div class="well">
										<div class="form-group">
											<label class="col-sm-2 control-label" for="transaction-amount">
												金额
											</label>
											<div class="col-sm-10">
												<input type="text" name="transaction[amount]" class="form-control" id="transaction-amount" placeholder="金额" value="">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="transaction-description">
												描述
											</label>
											<div class="col-sm-10">
												<input type="text" name="transaction[description]" class="form-control" id="transaction-description" placeholder="描述" value="">
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-12 text-right">
												<button onclick="add_transaction();" type="button" id="submit-user-transactions" class="btn btn-sm">
													提交
												</button>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="tab-reward">
								<table class="table table-striped table-bordered table-hover" id="table-reward">
									<thead>
										<tr>
											<th>
												添加日期
											</th>
											<th>
												内容
											</th>
											<th>
												积分
											</th>
										</tr>
									</thead>
									<tbody>
										<?php
										if(isset($user_rewards)):?>
										<?php
										foreach($user_rewards as $user_reward):?>
										<tr>
											<td>
												<?php echo $user_reward['date_added'];?>
											</td>
											<td>
												<?php echo $user_reward['description'];?>
											</td>
											<td>
												<?php echo $user_reward['points'];?>
											</td>
										</tr>
										<?php endforeach;?>
										<?php endif;?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="2" class="text-right">
												小计
											</td>
											<td class="text-right">
												<?php echo isset($total_rewards) ? $total_rewards : '0';?>
											</td>
										</tr>
										<tr>
											<td colspan="3">
												<?php echo isset($rewards_pagination) ? $rewards_pagination : '';?>
											</td>
										</tr>
									</tfoot>
								</table>
								<div class="well">
									<div class="form-group">
										<label class="col-sm-2 control-label" for="reward-points">
											积分
										</label>
										<div class="col-sm-10">
											<input type="text" name="reward[points]" class="form-control" id="reward-points" placeholder="金额" value="">
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label" for="reward-description">
											描述
										</label>
										<div class="col-sm-10">
											<input type="text" name="reward[description]" class="form-control" id="reward-description" placeholder="描述" value="">
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-12 text-right">
											<button onclick="add_reward();" type="button" id="submit-user-rewards" class="btn btn-sm">
												提交
											</button>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="tab-competence">
								查看：
								<hr>
								<?php if(isset($competences['access']) && !empty($competences['access'])):?>
								<?php foreach($competences['access'] as $key=>$competence):?>
								<div class="form-group">
									<span class="col-sm-2 control-label" for="user_access<?php echo $key;?>">
										<?php echo $competence['title'];?>：
									</span>
									<div class="col-sm-10">
										<?php if(isset($user_competences['access']) && is_array($user_competences['access']) && in_array($competence['value'], $user_competences['access'])):?>
										<label class="radio-inline">
											<input type="radio" name="competence[user_access][<?php echo $key;?>]" id="user_access<?php echo $key;?>" value="<?php echo $competence['value'];?>" checked>是
										</label>
										<label class="radio-inline">
											<input type="radio" name="competence[user_access][<?php echo $key;?>]" id="user_access<?php echo $key;?>" value="">否
										</label>
										<?php else:?>
										<label class="radio-inline">
											<input type="radio" name="competence[user_access][<?php echo $key;?>]" id="user_access<?php echo $key;?>" value="<?php echo $competence['value'];?>">是
										</label>
										<label class="radio-inline">
											<input type="radio" name="competence[user_access][<?php echo $key;?>]" id="user_access<?php echo $key;?>" value="" checked>否
										</label>
										<?php endif;?>
										<label class="radio-inline"><?php echo $competence['description'];?></label>
									</div>
								</div><hr>
								<?php endforeach;?>
								<?php endif;?>
								
								修改：
								<hr>
								<?php foreach($competences['edit'] as $k=>$competence):?>
								<div class="form-group">
									<span class="col-sm-2 control-label" for="user_edit<?php echo $k;?>">
										<?php echo $competence['title'];?>：
									</span>
									<div class="col-sm-10">
										<?php if(isset($user_competences['edit']) && is_array($user_competences['edit']) && in_array($competence['value'], $user_competences['edit'])):?>
										<label class="radio-inline">
											<input type="radio" name="competence[user_edit][<?php echo $k;?>]" id="user_edit<?php echo $k;?>" value="<?php echo $competence['value'];?>" checked>是
										</label>
										<label class="radio-inline">
											<input type="radio" name="competence[user_edit][<?php echo $k;?>]" id="user_edit<?php echo $k;?>" value="">否
										</label>
										<?php else:?>
										<label class="radio-inline">
											<input type="radio" name="competence[user_edit][<?php echo $k;?>]" id="user_edit<?php echo $k;?>" value="<?php echo $competence['value'];?>">是
										</label>
										<label class="radio-inline">
											<input type="radio" name="competence[user_edit][<?php echo $k;?>]" id="user_edit<?php echo $k;?>" value="" checked>否
										</label>
										<?php endif;?>
										<label class="radio-inline"><?php echo $competence['description'];?></label>
									</div>
								</div><hr>
								<?php endforeach;?>
							</div>
						</div>
					</form>
				</div>
				<!-- /widget-content -->
			</div>
			<!-- /widget -->
		</div>
	</div>
	<!-- /row -->
</div>
<!-- /container -->

<script>
	$("#tab-address ul li:first").addClass('active');
	$("#tab-address .address div:first").addClass('active');

	var row_id = '<?php echo $row_id;?>';
	var address_id = '<?php echo $max_address_id;?>';
	function add_address()
	{
		//左边
		var cla="'nav-address"+row_id+"'";
		var id="'address"+row_id+"'";
		var nav_html = '<li class="active nav-address'+row_id+'"><a href="#address'+row_id+'" data-toggle="tab" style="padding: 5px 10px;font-size: 12px"><span class="glyphicon glyphicon-remove-circle" onclick="remove_address('+cla+','+id+');"></span>地址'+row_id+'</a></li>';
		$('#tab-address ul .active').removeClass('active');
		$('.nav-address').before(nav_html);

		//右边
		var tab_html = '<div class="tab-pane active" id="address'+row_id+'">';
		tab_html += '<div class="form-group"><label class="col-sm-2 control-label" for="firstname'+row_id+'"><span style="color: red">*</span>&nbsp;姓氏</label><div class="col-sm-10"><input type="text" name="address['+address_id+'][firstname]" class="form-control" id="firstname'+row_id+'" placeholder="姓氏" value=""></div></div>';
		tab_html += '<div class="form-group"><label class="col-sm-2 control-label" for="lastname'+row_id+'">名字</label><div class="col-sm-10"><input type="text" name="address['+address_id+'][lastname]" class="form-control" id="lastname'+row_id+'" placeholder="名字" value=""></div></div>';
		tab_html += '<div class="form-group"><label class="col-sm-2 control-label" for="address'+row_id+'"><span style="color: red">*</span>&nbsp;地址</label><div class="col-sm-10"><input type="text" name="address['+address_id+'][address]" class="form-control" id="address'+row_id+'" placeholder="详细地址" value=""></div></div>';
		tab_html += '<div class="form-group"><label class="col-sm-2 control-label" for="city'+row_id+'"><span style="color: red">*</span>&nbsp;城市</label><div class="col-sm-10"><input type="text" name="address['+address_id+'][city]" class="form-control" id="city'+row_id+'" placeholder="所在城市" value=""></div></div>';
		tab_html += '<div class="form-group"><label class="col-sm-2 control-label" for="postcode'+row_id+'">邮编</label><div class="col-sm-10"><input type="text" name="address['+address_id+'][postcode]" class="form-control" id="postcode'+row_id+'" placeholder="邮编" value=""></div></div>';
		tab_html += '<div class="form-group"><label class="col-sm-2 control-label" for="input-country'+row_id+'"><span style="color: red">*</span>国家</label><div class="col-sm-10"><select onchange="country(this, \'' + address_id + '\', \'0\');" class="form-control" id="input-country'+row_id+'" name="address['+address_id+'][country_id]"><option value="0">--无--</option>';
		<?php foreach ($countrys as $country):?>
		tab_html += '<option value="<?php echo $country['country_id']?>"><?php echo quotes_to_entities($country['name']);?></option>';
		<?php endforeach;?>
		tab_html += '</select></div></div>';
		tab_html += '<div class="form-group"><label class="col-sm-2 control-label" for="input-zone'+row_id+'"><span style="color: red">*</span>&nbsp;省份</label><div class="col-sm-10"><select name="address['+address_id+'][zone_id]" class="form-control" id="input-zone'+row_id+'"><option value="0">--无--</option></select></div></div>';
		tab_html += '<div class="form-group"><label class="col-sm-2 control-label" for="input-default'+row_id+'">设为默认地址</label><div class="col-sm-10"><label class="radio-inline"><input type="radio" name="address['+address_id+'][default]" id="input-default'+row_id+'" value="1">是</label><label class="radio-inline"><input type="radio" name="address['+address_id+'][default]" id="input-default'+row_id+'" value="0" checked/>否</label></div></div></div>';

		$('#tab-address div .address .active').removeClass('active');
		$('#tab-address div .address').append(tab_html);

		row_id++;
		address_id++;
	}
</script>

<script type="text/javascript">
	function country(element, index, zone_id)
	{
		$.ajax(
			{
				url: "<?php echo $this->config->item('admin').'localisation/country/get_country?country_id=';?>" + element.value,
				dataType: 'json',
				beforeSend: function()
				{
					NProgress.start();
				},
				complete: function()
				{
					NProgress.done();
				},
				success: function(json)
				{
					if (json['postcode_required'] == '1')
					{
						$('input[name=\'address[' + index + '][postcode]\']').parent().parent().find('label').prepend('<span style="color:red">*&nbsp;</span>');
					} else
					{
						$('input[name=\'address[' + index + '][postcode]\']').parent().parent().find('label').find('span').remove();
					}

					html = '<option value="0">--无--</option>';

					if (json['zone'] && json['zone'] != '')
					{
						for (i = 0; i < json['zone'].length; i++)
						{
							html += '<option value="' + json['zone'][i]['zone_id'] + '"';

							if (json['zone'][i]['zone_id'] == zone_id)
							{
								html += ' selected="selected"';
							}

							html += '>' + json['zone'][i]['name'] + '</option>';
						}
					} else
					{
						html += '<option value="0">--无--</option>';
					}

					$('select[name=\'address[' + index + '][zone_id]\']').html(html);
				},
				error: function(xhr, ajaxOptions, thrownError)
				{
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
	}

	$('select[name$=\'[country_id]\']').trigger('change');
</script>
<script type="text/javascript">
	function add_history()
	{
		$.ajax(
			{
				url: '<?php echo $this->config->item('admin').'user/user/add_history?user_id='.$user_id;?>',
				type: 'post',
				dataType: 'html',
				data: 'comment=' + encodeURIComponent($('#tab-history textarea[name=\'user_history[comment]\']').val()),
				beforeSend: function()
				{
					NProgress.start();
				},
				complete: function()
				{
					NProgress.done();
				},
				success: function(html)
				{
					if(html)
					{
						$('#table-history').html(html);
						$('#tab-history textarea[name=\'user_history[comment]\']').val('');
					}
				}
			});
	}

	function add_transaction()
	{
		$.ajax(
			{
				url: '<?php echo $this->config->item('admin').'user/user/add_transaction?user_id='.$user_id;?>',
				type: 'post',
				dataType: 'html',
				data: 'description=' + encodeURIComponent($('#tab-transaction input[name=\'transaction[description]\']').val())+'&amount=' + encodeURIComponent($('#tab-transaction input[name=\'transaction[amount]\']').val()),
				beforeSend: function()
				{
					NProgress.start();
				},
				complete: function()
				{
					NProgress.done();
				},
				success: function(html)
				{
					if(html)
					{
						$('#table-transaction').html(html);
						$('#tab-transaction input[name=\'transaction[description]\']').val('');
						$('#tab-transaction input[name=\'transaction[amount]\']').val('');
					}
				}
			});
	}

	function add_reward()
	{
		$.ajax(
			{
				url: '<?php echo $this->config->item('admin').'user/user/add_reward?user_id='.$user_id;?>',
				type: 'post',
				dataType: 'html',
				data: 'description=' + encodeURIComponent($('#tab-reward input[name=\'reward[description]\']').val())+'&points=' + encodeURIComponent($('#tab-reward input[name=\'reward[points]\']').val()),
				beforeSend: function()
				{
					NProgress.start();
				},
				complete: function()
				{
					NProgress.done();
				},
				success: function(html)
				{
					if(html)
					{
						$('#table-reward').html(html);
						$('#tab-reward input[name=\'reward[description]\']').val('');
						$('#tab-reward input[name=\'reward[points]\']').val('');
					}
				}
			});
	}

	function remove_address(cla,id)
	{
		$('.'+cla).remove();
		$('#'+id).remove();

		//清理active
		$("#tab-address ul .active").removeClass('active');
		$("#tab-address .address .active").removeClass('active');

		//添加active
		$("#tab-address ul li:first").addClass('active');
		$("#tab-address .address div:first").addClass('active');
	}
	
	$('#table-transaction a').click(function(e){
		e.preventDefault(e);
		$.ajax(
			{
				url: $(this).attr("href"),
				type: 'get',
				dataType: 'html',
				data: '',
				beforeSend: function()
				{
					NProgress.start();
				},
				complete: function()
				{
					NProgress.done();
				},
				success: function(html)
				{
					if(html)
					{
						$('#table-transaction').html(html);
					}
				}
			});
	});
	
	$('#table-history a').click(function(e){
		e.preventDefault(e);
		$.ajax(
			{
				url: $(this).attr("href"),
				type: 'get',
				dataType: 'html',
				data: '',
				beforeSend: function()
				{
					NProgress.start();
				},
				complete: function()
				{
					NProgress.done();
				},
				success: function(html)
				{
					if(html)
					{
						$('#table-history').html(html);
					}
				}
			});
	});
	
	$('#table-reward a').click(function(e){
		e.preventDefault(e);
		$.ajax(
			{
				url: $(this).attr("href"),
				type: 'get',
				dataType: 'html',
				data: '',
				beforeSend: function()
				{
					NProgress.start();
				},
				complete: function()
				{
					NProgress.done();
				},
				success: function(html)
				{
					if(html)
					{
						$('#table-reward').html(html);
					}
				}
			});
	});
	
</script>
<?php echo $footer;?>