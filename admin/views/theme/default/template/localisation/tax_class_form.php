<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<!-- /subnavbar -->
<div class="container">
  <div class="row">
    <div class="col-md-12 middle-flat-left">
      <div class="panel panel-default">
        <div class="panel-heading  row row-panel-heading bg-info">
	        <p class="navbar-left"><i class="glyphicon glyphicon-edit"></i>&nbsp;编辑税率组</p>
	    	<div class="navbar-right btn-group" style="margin-right: 0">
			  <button type="button" onclick="submit('form-tax_class')" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-floppy-save"></i></button>
			  <a href="<?php echo site_url('localisation/tax_class');?>" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-share-alt"></i></a>
			</div>
        </div>
        <!-- /widget-header -->
        <div class="panel-body page-tab">
          <form action="<?php echo $action;?>" method="post" enctype="multipart/form-data" id="form-tax_class" class="form-horizontal">
          	<div class="form-group" id="language">
				<label class="col-sm-2 control-label" for="name"><span style="color: red">*&nbsp;</span>税率组名称</label>
				<div class="col-sm-10">
				<?php foreach($languages as $language):?>
					<div class="input-group">
					  <span class="input-group-addon"><img width="16px" height="11px" class="lazy" data-original="public/flags/<?php echo $language['image']?>"></span>
					  <input type="text" name="description[<?php echo $language['language_id']?>][title]" class="form-control" placeholder="税率组名称" value="<?php echo isset($description[$language['language_id']]['title']) ? $description[$language['language_id']]['title'] : '';?>">
					</div>
					<?php if(isset($error_description[$language['language_id']]['error_title'])):?><label class="text-danger"><?php echo $error_description[$language['language_id']]['error_title'];?></label><?php endif;?>
				<?php endforeach;?>
				</div>
			</div>
			<div class="form-group" id="language">
				<label class="col-sm-2 control-label" for="name"><span style="color: red">*&nbsp;</span>税率组描述</label>
				<div class="col-sm-10">
				<?php foreach($languages as $language):?>
					<div class="input-group">
					  <span class="input-group-addon"><img width="16px" height="11px" class="lazy" data-original="public/flags/<?php echo $language['image']?>"></span>
					  <input type="text" name="description[<?php echo $language['language_id']?>][description]" class="form-control" placeholder="税率组描述" value="<?php echo isset($description[$language['language_id']]['description']) ? $description[$language['language_id']]['description'] : '';?>">
					</div>
					<?php if(isset($error_description[$language['language_id']]['error_title'])):?><label class="text-danger"><?php echo $error_description[$language['language_id']]['error_title'];?></label><?php endif;?>
				<?php endforeach;?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="sort_order">税率项</label>
				<div class="col-sm-10">
					<table class="table" id="tax-rule">
						<thead>
							<td>税率</td>
							<td>应用在</td>
							<td>优先级</td>
							<td class="text-right">操作</td>
						</thead>
						<tbody>
							<?php $tax_rule_row='0';?>
							<?php if(isset($tax_rules) && !empty($tax_rules)):?>
							<?php foreach($tax_rules as $tax_rule):?>
							<tr id="tax-rule-row<?php echo $tax_rule_row; ?>">
								<td>
									<select class="form-control" name="tax_rule[<?php echo $tax_rule_row; ?>][tax_rate_id]">
										<?php if(isset($tax_rates) && is_array($tax_rates)):?>
										<?php foreach($tax_rates as $tax_rate):?>
										<?php if($tax_rate['tax_rate_id'] == $tax_rule['tax_rate_id']):?>
										<option value="<?php echo $tax_rate['tax_rate_id'];?>" selected><?php echo $tax_rate['name'];?></option>
										<?php else:?>
										<option value="<?php echo $tax_rate['tax_rate_id'];?>"><?php echo $tax_rate['name'];?></option>
										<?php endif;?>
										<?php endforeach;?>
										<?php endif;?>
									</select>
								</td>
								<td>
									<select class="form-control" name="tax_rule[<?php echo $tax_rule_row; ?>][based]">
										<?php if($tax_rule['based'] == 'shipping'):?>
										<option value="shipping" selected>购物地址</option>
										<option value="payment">支付地址</option>
										<option value="store">商店地址</option>
										<?php elseif($tax_rule['based'] == 'payment'):?>
										<option value="shipping">购物地址</option>
										<option value="payment" selected>支付地址</option>
										<option value="store">商店地址</option>
										<?php else:?>
										<option value="shipping">购物地址</option>
										<option value="payment">支付地址</option>
										<option value="store" selected>商店地址</option>
										<?php endif;?>
									</select>
								</td>
								<td>
									<input type="text" name="tax_rule[<?php echo $tax_rule_row; ?>][priority]" class="form-control" placeholder="优先级" value="<?php echo isset($tax_rule['priority']) ? $tax_rule['priority'] : '1';?>">
								</td>
								<td class="text-right"><button type="button" onclick="$('#tax-rule-row<?php echo $tax_rule_row; ?>').remove();" data-toggle="tooltip" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-minus"></i></button></td>
							</tr>
							<?php $tax_rule_row++;?>
							<?php endforeach;?>
							<?php endif;?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="3"></td>
								<td class="text-right"><button type="button" onclick="addRule();" data-toggle="tooltip" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-plus"></i></button></td>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
          </form>
        </div>
        <!-- /widget-content --> 
      </div>
      <!-- /widget -->
    </div>
    <!-- /span6 --> 
  </div>
  <!-- /row --> 
</div>
<!-- /container -->

<script>
var tax_rule_row = <?php echo $tax_rule_row; ?>;
function addRule() {
	html  = '<tr id="tax-rule-row'+tax_rule_row+'"><td>';
	html +=	'<select class="form-control" name="tax_rule['+tax_rule_row+'][tax_rate_id]">';
	html += '<?php if(isset($tax_rates) && is_array($tax_rates)):?>';
	html +=	'<?php foreach($tax_rates as $tax_rate):?>';
	html += '<option value="<?php echo $tax_rate['tax_rate_id'];?>"><?php echo $tax_rate['name'];?></option>';
	html += '<?php endforeach;?>';
	html += '<?php endif;?>';
	html += '</select></td><td>';
	html += '<select class="form-control" name="tax_rule['+tax_rule_row+'][based]">';
	html += '<option value="shipping">购物地址</option><option value="payment">支付地址</option><option value="store">商店地址</option></select></td><td>';
	html += '<input type="text" name="tax_rule['+tax_rule_row+'][priority]" class="form-control" placeholder="优先级" value="1"></td>';
	html += '<td class="text-right"><button type="button" onclick="$(\'#tax-rule-row'+tax_rule_row+'\').remove();" data-toggle="tooltip" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-minus"></i></button></td></tr>';
	
	$('#tax-rule tbody').append(html);
	
	tax_rule_row++;
	
}
</script>
<?php echo $footer;//装载header?>