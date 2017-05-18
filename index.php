<?php
session_start();

$title = "Home | NEO";
require_once("./includes/template_begin.inc.php");
?>
<div class="jumbotron">
	<h1>Welcome to NEO</h1>
	<h2>The WA DECA Training Site</h2>
</div>
<div class="row marketing">
	<div class="col-lg-6">
		<h4>If you a WA DECA member:</h4>
		<p>If you have not yet signed up up for NEO, please register. If you have
		already registered, log in and start training!</p>
	</div>
	<div class="col-lg-6">
		<h4>If you are not part of WA DECA:</h4>
		<p>There's not much for you here :(</p>
	</div>
</div>
<?php
require_once("./includes/template_end.inc.php");
?>