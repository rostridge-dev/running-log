		<h2><?php echo $title; ?></h2>

		<div class="row">
		
			<div class="col-md-12">
				<form action="<?php echo base_url(); ?>shoes/add" method="get"><button class="btn btn-default pull-right" type="submit">Add New Shoe</button></form>
			</div>
			
		</div>
		
		<hr>
		
		<div class="row">

			<div class="col-md-12">
				<table class="table table-responsive table-striped table-hover">
					<thead>
						<tr>
							<td><small class="text-muted">Shoe</small></td>
							<td><small class="text-muted">Price</small></td>
							<td><small class="text-muted">Mileage</small></td>
							<td><small class="text-muted">Cost / km</small></td>
							<td><small class="text-muted">Status</small></td>
							<td>&nbsp;</td>
						</tr>
					</thead>
					<tbody>
<?
if (!empty($shoes)) {
	foreach($shoes as $id=>$shoe) {
?>
						<tr>
							<td><p><a href="<?php echo base_url("shoes/edit/".$shoe->getID()); ?>"><?php echo $manufacturers[$shoe->getMakeID()]." ".$shoe->getModel(); ?></a></p></td>
							<td><p>$<?php echo number_format((float)$shoe->getPrice(),2,'.',''); ?></p></td>
							<td><p><?php echo $shoe->getMileage(); ?> km</p></td>
<?
		if ($shoe->getMileage() > 0) {
			$cost = $shoe->getPrice() / $shoe->getMileage();
			$cost = "$".number_format((float)$cost,2,'.','')." / km";
		} else {
			$cost = " -- ";
		}
?>
							<td><p><?php echo $cost; ?></p></td>
<?
		$retired = "Retired";
		if ($shoe->getRetired() == false) {
			$retired = "Active";
		}
?>
							<td><p><?php echo $retired; ?></p></td>
							<td><p class="text-right"><a class="text-danger" href="<?php echo base_url("shoes/delete/".$shoe->getID()); ?>"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</a></p></td>
						</tr>
<?
	}
} else {
?>
						<tr>
							<td colspan="6"><p class="text-center">There are no shoes entered into the system. Please add at least one pair.</p></td>
						</tr>
<?	
}
?>
					</tbody>
				</table>
			</div>
		</div>