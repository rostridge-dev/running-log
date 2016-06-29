		<h2><?php echo $title; ?></h2>
		
		<div class="row">

			<div class="col-md-12">
				<table class="table table-responsive table-striped table-hover">
					<thead>
						<tr>
							<td><small class="text-muted">Date</small></td>
							<td><small class="text-muted">Route</small></td>
							<td><small class="text-muted">Type</small></td>
							<td><small class="text-muted">Distance</small></td>
							<td><small class="text-muted">Time</small></td>
							<td><small class="text-muted">Pace</small></td>
							<td>&nbsp;</td>
						</tr>
					</thead>
					<tbody id="entries-list">
						<tr>
							<td colspan="7"><p class="text-center">...loading entries...</p></td>
						</tr>
					
<?
if ($count <= 0) {
?>				
	
						<tr>
							<td colspan="7"><p class="text-center">There are no entries entered into the system. Please add at least one entry.</p></td>
						</tr>
<?	
}
?>
					</tbody>
				</table>
			</div>
		</div>