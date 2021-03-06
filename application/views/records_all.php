		<h2><?php echo $title; ?></h2>
		
		<div class="row">

			<div class="col-md-12">
				<table class="table table-responsive table-striped table-hover">
					<thead>
						<tr>
							<td><small class="text-muted">Date</small></td>
							<td><small class="text-muted">Route</small></td>
							<td><small class="text-muted">Distance</small></td>
							<td><small class="text-muted">Time</small></td>
							<td><small class="text-muted">Pace</small></td>
						</tr>
					</thead>
					<tbody>
<?
if (!empty($entries)) {
	foreach($entries as $id=>$entry) {
?>
						<tr>
							<td><p><a href="<?php echo base_url("entries/edit/".$entry->getID()); ?>"><?php echo $entry->getDate(); ?></a></p></td>
<?
						if (isset($routes[$entry->getRouteID()])) {
?>
							<td><p><?php echo $routes[$entry->getRouteID()]->getName(); ?></p></td>
<?
						} else {
?>
							<td><p class="text-muted">Unknown route</p></td>
<?
						}
?>
							<td><p><?php echo $entry->getDistance(); ?> km</p></td>
							<td><p><?php echo $entry->getTime(); ?></p></td>
							<td><p><?php echo $entry->getPace(); ?></p></td>
							</tr>
<?
	}
} else {
?>
						<tr>
							<td colspan="6"><p class="text-center">There are no races entered into the system. Please add at least one race to see it as a record.</p></td>
						</tr>
<?	
}
?>
					</tbody>
				</table>
			</div>
		</div>