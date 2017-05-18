<?php
require_once("./includes/connection.inc.php");
$conn = dbConnect('read');

require_once('./includes/calc_stats.inc.php');

?>
<div id="uid" style="display: none;"><?php echo htmlspecialchars($uid); ?></div>
<h4 style="margin-top: 5px;">
<?php
if ($error){
	echo "<h1>No problems completed yet.</h1>";
}
else{ ?>
	<table class="table table-hover">
		<tr>
			<td style="border-top: none;">Total attempts</td>
			<td style="border-top: none;"><?php echo $totalAttempts; ?></td>
		</tr>
		<tr>
			<td># of distinct problems attempted</td>
			<td><?php echo $totalProblems; ?></td>
		</tr>
		<tr>
			<td># of problems correct</td>
			<td><?php echo $solved; ?></td>
		</tr>
		<tr>
			<td>% correct attempts</td>
			<td><?php echo $percentage . '%'; ?></td>
		</tr>
		<tr>
			<td>Average # of attempts to solve each problem</td>
			<td><?php echo $avgAttemptsPerCorrectSolution; ?></td>
		</tr>
	</table>

	<?php if ($solved > 0){ ?>
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>
		<script type="text/javascript">
			google.load('visualization', '1.0', {'packages':['corechart'], 'callback' : dataAjax});

			function dataAjax () {
				$.ajax({
					url : 'user_attempts_data.php',
					dataType : 'json',
					type : 'POST',
					data : {uid : $('#uid').text()},
					success : function(result2){
						drawChart(result2);
					},
					error : function(jqXHR, textStatus, errorThrown){
						alert("There was an error.");
					}
				});
			}

			// Creates and populates a data table,
			// instantiates the pie chart, passes in the data and
			// draws it.
			function drawChart(ar) {
				// Create the data table.
				var data = new google.visualization.DataTable(ar);

				// Set chart options
				var options = {'title':'Number of problems solved in given number of attempts',
							   'width':500,
							   'height':375};

				// Instantiate and draw our chart, passing in some options.
				var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
				chart.draw(data, options);
			}
		</script>
		<div id="chart_div"></div>
	<?php } ?>
<?php } ?>
</h4>
