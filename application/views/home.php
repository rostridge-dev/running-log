		
			<div class="row">
			
				<div class="col-md-4">	
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Weekly Distances</h3>
						</div>
						<table class="table">
							<tbody>
<?php
	foreach ($data_last_six_weeks as $label => $weeks_data) {
?>
								<tr>
									<td><strong><?php echo $label ?>:</strong></td>
									<td><?php echo $weeks_data['distance'] ?> km</td>
									<td><?php echo $weeks_data['time'] ?></td>
								</tr>
<?php
	}
?>
							</tbody>
						</table>
					</div>
				</div>
				
				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Monthly Distances</h3>
						</div>
						<table class="table">
							<tbody>
<?php
	foreach ($data_last_six_months as $label => $months_data) {
?>
								<tr>
									<td><strong><?php echo $label ?>:</strong></td>
									<td><?php echo $months_data['distance'] ?> km</td>
									<td><?php echo $months_data['time'] ?></td>
								</tr>
<?php
	}
?>
							</tbody>
						</table>
					</div>	
				</div>
				
				<div class="col-md-4">	
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title"><?php echo date("Y"); ?> Statistics</h3>
						</div>
						<table class="table">
							<tbody>
								<tr>
									<td><strong>Distance:</strong></td>
									<td><?php echo $distance_overall_year; ?> km</td>
								</tr>
								<tr>
									<td><strong>Time:</strong></td>
									<td><?php echo $time_overall_year; ?></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Overall Totals</h3>
						</div>
						<table class="table">
							<tbody>
								<tr>
									<td><strong>Distance:</strong></td>
									<td><?php echo $distance_overall_total; ?> km</td>
								</tr>
								<tr>
									<td><strong>Time:</strong></td>
									<td><?php echo $time_overall_total; ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				
			</div>
			
			<div class="row">

				<div class="col-md-12">	
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Last Two Weeks at a Glance</h3>
						</div>
						<div class="panel-body">
							<div id="placeholder" style="width:100%;height:375px;"></div>
						</div>
					</div>
				</div>
				
			</div>
				
		</div>
