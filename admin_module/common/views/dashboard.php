<div class="row">
<div class="col">

<h2>Monitor <span class="fw-bold">strategy</span> of your Business</h2>
<p class="lead">Select any list to continue</p>

<div class="row row-cols-1 row-cols-md-2 g-4 mt-1">
	<div class="col text-center">
		<div class="card dashboard-card">
			<div class="card-body">		
			<i class="las la-user-tie"></i>			 
				<!--<img src="<?php echo base_url('storage/uploads/images/employee.png'); ?>" class="img-fluid w-25" />-->

				<a class="text-decoration-none text-dark d-block fs-6 fw-bold stretched-link mt-2" href="<?=admin_url("users")?>">Employees</a>

				<p>Active Employees: <?php echo $active_employees_text; ?></p>
				<!--<p class="text-muted small">Last Update: Oct 13, 2023 10:31</p>-->
			</div>
		</div>
	</div>

	<div class="col text-center">
		<div class="card dashboard-card">
			<div class="card-body">	
			<i class="las la-calendar-day"></i>				 
				<!--<img src="<?php echo base_url('storage/uploads/images/schedule.png'); ?>" class="img-fluid w-25" />-->

				<a class="text-decoration-none text-dark d-block fs-6 fw-bold stretched-link mt-2" href="<?=admin_url("schedule")?>">Schedule</a>
				<p>Last Updated Week: <?php echo (int)$max_week_number.', '.$max_year_number; ?></p>
			</div>
		</div>
	</div>

	<div class="col text-center">
		<div class="card dashboard-card">
			<div class="card-body">			
			<i class="las la-poll-h"></i>		 
				<!--<img src="<?php echo base_url('storage/uploads/images/scoreboard.png'); ?>" class="img-fluid w-25" />-->

				<a class="text-decoration-none text-dark d-block fs-6 fw-bold stretched-link mt-2" href="<?=admin_url("users/scorecards")?>">Scorecards</a>
				<p>Overall FICO Rate: <?php echo round($overall_fico_rate, 2); ?></p>
			</div>
		</div>
	</div>

	<div class="col text-center">
		<div class="card dashboard-card">
			<div class="card-body">		
			<i class="las la-truck"></i>			 
				<!--<img src="<?php echo base_url('storage/uploads/images/trucks.png'); ?>" class="img-fluid w-25" />-->

				<a class="text-decoration-none text-dark d-block fs-6 fw-bold stretched-link mt-2" href="<?=admin_url("fleet")?>">Fleet</a>
				<p>In-Transit Fleet: <?php echo $issued_fleet; ?></p>
			</div>
		</div>
	</div>


</div>

</div><!--col ends-->
<div class="col-4">

<div class="card right-dashboard-card bg-dark text-white">
	<div class="card-body">
	<h5>Week <?php echo (int)$max_week_number; ?> at a glance</h5>
	<ul class="list-group">
		<li class="list-group-item"><span class="badge text-bg-primary"><?php echo $Fantastic; ?></span>Fantastic</li>
		<li class="list-group-item"><span class="badge text-bg-success"><?php echo $Great; ?></span>Great</li>
		<li class="list-group-item"><span class="badge text-bg-warning"><?php echo $Fair; ?></span>Fair</li>
		<li class="list-group-item"><span class="badge text-bg-danger"><?php echo $Poor; ?></span>Poor</li>
	</ul>

		
	</div>
</div>

<div class="card mt-4 right-dashboard-card bg-success text-white">
	<div class="card-body">
	<h5>Fleet at a glance</h5>
	<ul class="list-group">
		<li class="list-group-item"><span class="badge text-success"><?php echo $available_fleet; ?></span>Available</li>
		<li class="list-group-item"><span class="badge text-warning"><?php echo $not_available_fleet; ?></span>Maintenance</li>
		<li class="list-group-item"><span class="badge text-danger"><?php echo $issued_fleet; ?></span>Issued</li>
	</ul>

		
	</div>
</div>

</div><!--col ends-->
</div>


