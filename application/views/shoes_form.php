		<h2><?php echo $title; ?></h2>

		<form id="shoes_form" action="<?php echo base_url($form_action)?>" method="post">
		<div class="row">		
			<div class="col-md-6">
				<div class="form-group">
					<?php
						if(form_error('make_id')){
							echo form_error('make_id');
						}
					?>
					<label class="required" for="make_id">Make</label>
					<?php echo form_dropdown('make_id',$makes,set_value('make_id',($shoe->getMakeID()) ? $shoe->getMakeID() : ''),'id="make_id" class="form-control"'); ?>
				</div>
			</div>			
		</div>
		
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<?php 
						if(form_error('model')){
							echo form_error('model');
						}
					?>
					<label class="required" for="model">Model</label>
					<input type="text" class="form-control" id="model" name="model" value="<?php echo set_value('model', ($shoe->getModel()) ? $shoe->getModel() : ''); ?>">
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<?php 
						if(form_error('purchase_date')){
							echo form_error('purchase_date');
						}
					?>
					<label class="required" for="purchase_date">Purchase Date</label>
					<input type="text" data-provide="datepicker" class="form-control datepicker" id="purchase_date" name="purchase_date" value="<?php echo set_value('purchase_date', ($shoe->getPurchaseDate()) ? $shoe->getPurchaseDate() : ''); ?>">
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<?php 
						if(form_error('price')){
							echo form_error('price');
						}
					?>
					<label class="required" for="price">Price</label>
					<input type="text" class="form-control" id="price" name="price" value="<?php echo set_value('price', ($shoe->getPrice()) ? $shoe->getPrice() : ''); ?>">
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<div class="checkbox">
						<?php 
							if(form_error('retired')){
								echo form_error('retired');
							}
						?>
						<label class="required" for="retired">
							<?php echo form_checkbox('retired','1',set_value('retired',($shoe->getRetired()) ? true : false),'id="retired"'); ?>
							Retired
						</label>
					</div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-6">
				<input type="hidden" name="action" value="submit">
				<button type="submit" class="btn btn-default">Submit</button>
			</div>
		</div>
		</form>