<!-- <h3>Problem:</h3>
<h4><?php echo $problemRow['problem_statement']; ?></h4>
<h3>Choices:</h3>
<ol type="A">
	<li><?php echo htmlentities($problemRow['choice_1'], ENT_COMPAT, 'UTF-8'); ?></li>
	<li><?php echo htmlentities($problemRow['choice_2'], ENT_COMPAT, 'UTF-8'); ?></li>
	<li><?php echo htmlentities($problemRow['choice_3'], ENT_COMPAT, 'UTF-8'); ?></li>
	<li><?php echo htmlentities($problemRow['choice_4'], ENT_COMPAT, 'UTF-8'); ?></li>
</ol>
<?php
if ($solved){ ?>
    <h3>Solution:</h3>
    <p><?php echo $problemRow['solution']; ?></p>
<?php } ?> -->

<div class="custom-jumbotron" style="padding-left: 4px; padding-right: 10px; padding-top: 1px; margin-bottom: 10px;">
	<h4 style="margin-top: 8px; margin-bottom: 0px; font-weight: bold;">Problem:</h4>
	<?php echo $problemRow['problem_statement']; ?><br>
	<ol type="A">
		<li><?php echo htmlentities($problemRow['choice_1'], ENT_COMPAT, 'UTF-8'); ?></li>
		<li><?php echo htmlentities($problemRow['choice_2'], ENT_COMPAT, 'UTF-8'); ?></li>
		<li><?php echo htmlentities($problemRow['choice_3'], ENT_COMPAT, 'UTF-8'); ?></li>
		<li><?php echo htmlentities($problemRow['choice_4'], ENT_COMPAT, 'UTF-8'); ?></li>
	</ol>
	<?php if ($solved){ ?>
		<h4 style="margin-top: 15px; margin-bottom: 0px; font-weight: bold;">Solution:</h4>
		<p style="margin-bottom: 6px;"><?php echo $problemRow['solution']; ?></p>
	<?php } ?>
</div>
