		<h2><?php echo $title; ?></h2>

		<form id="entries_form" action="<?php echo base_url($form_action)?>" method="post">

		<div class="row">
		
			<div class="col-md-12">
			
				<div id="report-data" class="panel panel-default">
				
					<div class="panel-heading">
						<h3 class="panel-title">Find Specific Running Entries</h3>
					</div>
					
					<div class="panel-body">
	
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<?php 
										if(form_error('start_date')){
											echo form_error('start_date');
										}
									?>
									<label for="start_date">Start Date</label>
									<input type="text" data-provide="datepicker" class="form-control datepicker" id="start_date" name="start_date" value="<?php echo set_value('start_date', ($report->getStartDate()) ? $report->getStartDate() : ''); ?>">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<?php 
										if(form_error('end_date')){
											echo form_error('end_date');
										}
									?>
									<label for="end_date">End Date</label>
									<input type="text" data-provide="datepicker" class="form-control datepicker" id="end_date" name="end_date" value="<?php echo set_value('end_date', ($report->getEndDate()) ? $report->getEndDate() : ''); ?>">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<?php
										if(form_error('type_id')){
											echo form_error('type_id');
										}
									?>
									<label for="type_id">Run Type</label>
									<?php echo form_dropdown('type_id',$run_types,set_value('type_id',($report->getTypeID()) ? $report->getTypeID() : ''),'id="type_id" class="form-control"'); ?>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-12">
								<input type="hidden" name="action" value="submit">						
								<button type="submit" class="btn btn-default">Submit</button>
							</div>
						</div>
						
					</div>
					
				</div>

			</div>
			
		</div>
		
		</form>
		
		<div class="row">
		
			<div class="col-md-12">
<?php
if (isset($results)) {
?>

				<h4 class="text-center">Total Entries: <?php echo $results['count']; ?> &nbsp;<span class="text-muted">|</span>&nbsp; Total Distance: <?php echo $results['distance']; ?> km &nbsp;<span class="text-muted">|</span>&nbsp; Total Time: <?php echo $results['time']; ?></h4>
				<table class="table table-responsive table-striped table-hover">
					<thead>
						<tr>
							<td><small class="text-muted">Date</small></td>
							<td><small class="text-muted">Route</small></td>
							<td><small class="text-muted">Type</small></td>
							<td><small class="text-muted">Distance</small></td>
							<td><small class="text-muted">Time</small></td>
							<td><small class="text-muted">Pace</small></td>
						</tr>
					</thead>
					<tbody>
<?
if (!empty($results['entries'])) {
	foreach($results['entries'] as $id=>$entry) {
?>
						<tr>
							<td><p><a target="entry-window" href="<?php echo base_url("entries/edit/".$entry->getID()); ?>"><span class="glyphicon glyphicon-new-window" aria-hidden="true"></span> <?php echo $entry->getDate(); ?></a></p></td>
							<td><p><?php echo $routes[$entry->getRouteID()]->getName(); ?></p></td>
							<td><p><?php echo $run_types[$entry->getTypeID()]; ?></p></td>
							<td><p><?php echo $entry->getDistance(); ?> km</p></td>
							<td><p><?php echo $entry->getTime(); ?></p></td>
							<td><p><?php echo $entry->getPace(); ?></p></td>
						</tr>
<?
	}
} else {
?>
						<tr>
							<td colspan="6"><p class="text-center">There are no entries that match your search criteria.</p></td>
						</tr>
<?	
}
?>
					</tbody>
				</table>
<?php
}
?>
			</div>
		</div>