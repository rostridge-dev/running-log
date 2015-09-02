		<h2><?php echo $title; ?></h2>

		<div class="row">
		
			<div class="col-md-12">
				<form action="<?php echo base_url(); ?>routes/add" method="get"><button class="btn btn-default pull-right" type="submit">Add New Route</button></form>
			</div>
			
		</div>
		
		<hr>
		
		<div class="row">

			<div class="col-md-12">
				<table class="table table-responsive table-striped table-hover">
					<thead>
						<tr>
							<td><small class="text-muted">Name</small></td>
							<td><small class="text-muted">Distance</small></td>
							<td><small class="text-muted">Surface</small></td>
							<td><small class="text-muted">Type</small></td>
							<td>&nbsp;</td>
						</tr>
					</thead>
					<tbody>
<?
if (!empty($routes)) {
	foreach($routes as $id=>$route) {
?>
						<tr>
							<td><p><a href="<?php echo base_url("routes/edit/".$route->getID()); ?>"><?php echo $route->getName(); ?></a></p></td>
							<td><p><?php echo $route->getDistance(); ?> km</p></td>
							<td><p><?php echo $route_surface_types[$route->getSurfaceID()]; ?></p></td>
							<td><p><?php echo $route_types[$route->getTypeID()]; ?></p></td>
							<td><p class="text-right"><a class="text-danger" href="<?php echo base_url("routes/delete/".$route->getID()); ?>"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</a></p></td>
						</tr>
<?
	}
} else {
?>
						<tr>
							<td colspan="6"><p class="text-center">There are no routes entered into the system. Please add at least one route.</p></td>
						</tr>
<?	
}
?>
					</tbody>
				</table>
			</div>
		</div>