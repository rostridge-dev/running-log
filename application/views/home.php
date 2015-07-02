<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Running Log Classic</title>

		<link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>css/bootstrap.spacelab.min.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>css/bootstrap.running-log.css" rel="stylesheet">
		
	</head>

	<body>
	
		<div id="navbar-user">
			<div class="container">
				<ul class="list-inline pull-right">
					<li><a href="<?php echo base_url(); ?>profile"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> <?php echo $firstname; ?> <?php echo $lastname; ?></a></li>
					<li><a href="<?php echo base_url(); ?>logout"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Logout</a></li>
				</ul>
			</div>
		</div>

		<nav class="navbar navbar-inverse">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="<?php echo base_url(); ?>home">Running Log Classic</a>
				</div>
				<div id="navbar" class="navbar-collapse collapse">
					<ul class="nav navbar-nav navbar-right">
						<li><a href="<?php echo base_url(); ?>home">Summary</a></li>
						<li><a href="<?php echo base_url(); ?>workouts">Workouts</a></li>
						<li><a href="<?php echo base_url(); ?>routes">Routes</a></li>
						<li><a href="<?php echo base_url(); ?>shoes">Shoes</a></li>
						<li><a href="<?php echo base_url(); ?>records">Records</a></li>
						<li><form action="<?php echo base_url(); ?>entry/add" method="get"><button class="btn btn-default navbar-btn" type="submit">Add New Entry</button></form></li>
					</ul>
				</div><!--/.navbar-collapse -->
			</div>
		</nav>

		<div class="container">
		
			<div class="row">
			
				<div class="col-md-4">	
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Weekly Distances</h3>
						</div>
						<table class="table">
							<tbody>
								<tr>
									<td><strong>Apr 20, 2015 - Apr 26, 2015:</strong></td>
									<td>33 km</td>
									<td>2:40:05</td>
								</tr>
								<tr>
									<td><strong>Apr 20, 2015 - Apr 26, 2015:</strong></td>
									<td>55 km</td>
									<td>1:34:05</td>
								</tr>
								<tr>
									<td><strong>Apr 20, 2015 - Apr 26, 2015:</strong></td>
									<td>12 km</td>
									<td>2:06:05</td>
								</tr>
								<tr>
									<td><strong>Apr 20, 2015 - Apr 26, 2015:</strong></td>
									<td>33 km</td>
									<td>2:40:05</td>
								</tr>
								<tr>
									<td><strong>Apr 20, 2015 - Apr 26, 2015:</strong></td>
									<td>55 km</td>
									<td>1:34:05</td>
								</tr>
								<tr>
									<td><strong>Apr 20, 2015 - Apr 26, 2015:</strong></td>
									<td>12 km</td>
									<td>2:06:05</td>
								</tr>
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
								<tr>
									<td><strong>Apr 2015:</strong></td>
									<td>33 km</td>
									<td>2:40:05</td>
								</tr>
								<tr>
									<td><strong>Mar 2015:</strong></td>
									<td>55 km</td>
									<td>1:34:05</td>
								</tr>
								<tr>
									<td><strong>Feb 2015:</strong></td>
									<td>12 km</td>
									<td>2:06:05</td>
								</tr>
								<tr>
									<td><strong>Jan 2015:</strong></td>
									<td>33 km</td>
									<td>2:40:05</td>
								</tr>
								<tr>
									<td><strong>Dec 2014:</strong></td>
									<td>55 km</td>
									<td>1:34:05</td>
								</tr>
								<tr>
									<td><strong>Nov 2015:</strong></td>
									<td>12 km</td>
									<td>2:06:05</td>
								</tr>
							</tbody>
						</table>
					</div>	
				</div>
				
				<div class="col-md-4">	
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">2015 Statistics</h3>
						</div>
						<table class="table">
							<tbody>
								<tr>
									<td><strong>Distance:</strong></td>
									<td>300 km</td>
								</tr>
								<tr>
									<td><strong>Time:</strong></td>
									<td>1:34:05</td>
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
									<td>300 km</td>
								</tr>
								<tr>
									<td><strong>Time:</strong></td>
									<td>1:34:05</td>
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
							<div id="placeholder" style="width:100%;height:500px;"></div>
						</div>
					</div>
				</div>
				
			</div>
				
		</div>
	
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script src="<?php echo base_url(); ?>js/jquery.flot.min.js"></script>
		<script src="<?php echo base_url(); ?>js/jquery.flot.categories.min.js"></script>
		<script src="<?php echo base_url(); ?>js/jquery.flot.time.min.js"></script>
		<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
		<script type="text/javascript">
			$(function() {
				// When using dates, must subtract one from the month; also need to add a padding day on either side of the x-axis
				var dataEasy = [[(new Date(2015,06,01)).getTime(),5], [(new Date(2015,06,03)).getTime(),13]];
				var dataLong = [[(new Date(2015,06,02)).getTime(),8], [(new Date(2015,06,05)).getTime(),5]];
				var dataTempo = [[(new Date(2015,06,04)).getTime(),5], [(new Date(2015,06,06)).getTime(),8]];
				var dataRace = [[(new Date(2015,06,07)).getTime(),5], [(new Date(2015,06,08)).getTime(),8]];
				var dataInterval = [[(new Date(2015,06,09)).getTime(),6], [(new Date(2015,06,10)).getTime(),11]];
				var dataFartlek = [[(new Date(2015,06,11)).getTime(),3], [(new Date(2015,06,12)).getTime(),8]];
				
				$.plot("#placeholder",
					[
						{label: "&nbsp;Easy", color: "#85e685", data: dataEasy, bars: {show: true, barWidth: 40000000, align: "center"}},
						{label: "&nbsp;Long", color: "#f28504", data: dataLong, bars: {show: true, barWidth: 40000000, align: "center"}},
						{label: "&nbsp;Tempo", color: "#6dcff6", data: dataTempo, bars: {show: true, barWidth: 40000000, align: "center"}},
						{label: "&nbsp;Race", color: "#ed1c24", data: dataRace, bars: {show: true, barWidth: 40000000, align: "center"}},
						{label: "&nbsp;Interval", color: "#b658b7", data: dataInterval, bars: {show: true, barWidth: 40000000, align: "center"}},
						{label: "&nbsp;Fartlek", color: "#dfd455", data: dataFartlek, bars: {show: true, barWidth: 40000000, align: "center"}}
					], {
					xaxis: {
						mode: "time",
						minTickSize: [1, "day"],
						min: (new Date(2015,05,30)).getTime(),
						max: (new Date(2015,06,15)).getTime(),
						timeformat: "%Y/%m/%d"
					}
				});
			});
		</script>
	</body>
</html>