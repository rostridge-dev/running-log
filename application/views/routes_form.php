		<h2><?php echo $title; ?></h2>

		<form id="shoes_form" action="<?php echo base_url($form_action)?>" method="post">
		
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<?php 
						if(form_error('name')){
							echo form_error('name');
						}
					?>
					<label class="required" for="name">Name</label>
					<input type="text" class="form-control" id="name" name="name" value="<?php echo set_value('name', ($route->getName()) ? $route->getName() : ''); ?>">
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<?php 
						if(form_error('distance')){
							echo form_error('distance');
						}
					?>
					<label class="required" for="distance">Distance</label>
					<input type="text" class="form-control" id="distance" name="distance" value="<?php echo set_value('distance', ($route->getDistance()) ? $route->getDistance() : ''); ?>">
				</div>
			</div>
		</div>
		
		<div class="row">		
			<div class="col-md-6">
				<div class="form-group">
					<?php
						if(form_error('surface_id')){
							echo form_error('surface_id');
						}
					?>
					<label class="required" for="surface_id">Surface</label>
					<?php echo form_dropdown('surface_id',$route_surface_types,set_value('surface_id',($route->getSurfaceID()) ? $route->getSurfaceID() : ''),'id="surface_id" class="form-control"'); ?>
				</div>
			</div>			
		</div>
		
		<div class="row">		
			<div class="col-md-6">
				<div class="form-group">
					<?php
						if(form_error('type_id')){
							echo form_error('type_id');
						}
					?>
					<label class="required" for="type_id">Type</label>
					<?php echo form_dropdown('type_id',$route_types,set_value('type_id',($route->getTypeID()) ? $route->getTypeID() : ''),'id="type_id" class="form-control"'); ?>
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