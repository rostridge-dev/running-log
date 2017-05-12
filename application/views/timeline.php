			<h2><?php echo $title; ?></h2>
			
<?php
	foreach ($badges as $year => $group) {
?>	
			
			<div class="row">
			
				<div class="col-md-12">	
					<div class="panel panel-default">
						<div class="panel-heading">
							<h1 class="panel-title text-center">Your Highlights for <?php echo $year; ?></h1>
						</div>
						<div class="panel-body">
						
<?php
		if (empty($group)) {
?>
							<div class="row">
								<div class="col-md-12">
									<p class="text-center">There are running entries for this year, but not enough to show any neato badges (we need at least 30). Check out a different year!</p>
								</div>
							</div>
<?php
		} else {
?>
						
							<div class="row">
								<div class="col-md-5">
									<div class="row">
<?php
			foreach ($group['large'] as $index => $badge) {
?>	
										<div class="col-md-12">								
											<div class="well well-sm well-no-bg">
												<div class="col-md-4">
													<h1 class="badge-icon-large text-success"><span class="glyphicon <?php echo $badge['icon']; ?>" aria-hidden="true"></span></h1>
												</div>
												<div class="col-md-8">
													<h2><?php echo $badge['title']; ?></h2>
													<p><?php echo $badge['content']; ?></p>
												</div>
												<div class="clearfix"></div>
											</div>
										</div>
<?php
			}
?>
									</div>
								</div>
								<div class="col-md-7">
								
									<div class="row">									
<?php
			foreach ($group['small'] as $index => $badge) {
?>
										<div class="col-md-6">
								
											<div class="well well-sm well-no-bg">
												<div class="col-md-3">
													<h1 class="text-warning"><span class="glyphicon <?php echo $badge['icon']; ?>" aria-hidden="true"></span></h1>
												</div>
												<div class="col-md-9">
													<h4><?php echo $badge['title']; ?></h4>
													<p><?php echo $badge['content']; ?></p>
												</div>
												<div class="clearfix"></div>
											</div>
										</div>
										
<?php
			}
?>
										
									</div>
								</div>
							
							</div>
						</div>
<?php
		}
?>
					</div>
				</div>
			</div>
<?php
	}
?>