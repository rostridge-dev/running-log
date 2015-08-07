<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title><?php echo $title; ?>: Running Log Classic</title>

		<link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>css/bootstrap.spacelab.min.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>css/bootstrap.running-log.css" rel="stylesheet">
		
	</head>

	<body>
	
		<div id="navbar-user">
			<div class="container">
				<ul class="list-inline pull-right">
					<li><a href="<?php echo base_url(); ?>profile"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> <?php echo $this->session->userdata('firstname'); ?> <?php echo $this->session->userdata('lastname'); ?></a></li>
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
						<li><a href="<?php echo base_url(); ?>entries">Entries</a></li>
						<li><a href="<?php echo base_url(); ?>routes">Routes</a></li>
						<li><a href="<?php echo base_url(); ?>shoes">Shoes</a></li>
						<li><a href="<?php echo base_url(); ?>records">Records</a></li>
						<li><form action="<?php echo base_url(); ?>entries/add" method="get"><button class="btn btn-default navbar-btn" type="submit">Add New Entry</button></form></li>
					</ul>
				</div><!--/.navbar-collapse -->
			</div>
		</nav>

		<div class="container">