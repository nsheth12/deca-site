<?php require_once('admin_validation.inc.php'); ?>

<div class="container">
	<div class="header clearfix">
		<nav>
		  <ul class="nav nav-pills pull-right">
			<li <?php if ($title == "Get Problem | NEO") {echo 'class="active"';} ?> role="presentation"><a href="get_problem.php">Get Problem</a></li>
			<li <?php if ($title == "Report | NEO") {echo 'class="active"';} ?> role="presentation"><a href="report.php">Report</a></li>
			<li <?php if ($title == "Problem History | NEO") {echo 'class="active"';} ?> role="presentation"><a href="past_problems.php">Problem History</a></li>
			<li <?php if ($title == "Profile | NEO") {echo 'class="active"';} ?> role="presentation"><a href="profile.php">Profile</a></li>
			<?php if (isAdmin($_SESSION['user_id'])) {?>
				<li <?php if ($title == "Administrator Report | NEO") {echo 'class="active"';} ?> role="presentation"><a href="admin_report.php">Admin Report</a></li>
			<?php } ?>
			<li role="presentation"><a href="logout.php">Log out</a></li>
		  </ul>
		</nav>
		<h3 class="text-muted"><a href="index.php" class="disabled-link">NEO</a></h3>
	</div>
</div>
