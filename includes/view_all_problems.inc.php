<?php if (!$error) { ?>
    <script type="text/javascript">
		function submitForm (vpi){
			$('#vpiField').val(vpi);
			$('#vpiForm').submit();
		}
	</script>
	<form action="view_problem_full_report.php" method="post" id="vpiForm">
		<input type="hidden" name="vpi" id="vpiField" value="">
	</form>
    <table class="table tablesorter" id="problemsTable">
        <thead>
            <tr>
                <th>Problem</th>
                <th>Cluster</th>
                <th>% Attempts Correct</th>
                <th># Students who Have Seen This Problem</th>
                <th data-sorter="false"></th>
            </tr>
        </thead>
        <tbody>
            <?php while ($problem = $resultProblems->fetch_assoc()){ ?>
                <tr>
                    <td>
                        <div style="width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            <?php echo $problem['problem_statement']; ?>
                        </div>
                    </td>
                    <td>
                        <div style="width: 140px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            <?php echo getClusterName($problem['cluster_id']); ?>
                        </div>
                    </td>
                    <?php if (isset($problemDataTable[(int)$problem['problem_id']])){ ?>
                        <td>
                            <?php echo strval(round(100 * $problemDataTable[(int)$problem['problem_id']]['solved'] / $problemDataTable[(int)$problem['problem_id']]['total_attempts'])) . '%'; ?>
                        </td>
                        <td><?php echo $problemDataTable[(int)$problem['problem_id']]['num_students']; ?></td>
                    <?php } else { ?>
                        <td>N/A</td>
                        <td>0</td>
                    <?php } ?>
                    <td><a href="javascript: submitForm(<?php echo $problem['problem_id']; ?>)">Details</a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <div id="pager" class="pager" style="margin-bottom: 0px;">
        <form>
            <img src="./assets/first.png" class="first"/>
            <img src="./assets/prev.png" class="prev"/>
            <input type="text" class="pagedisplay"/>
            <img src="./assets/next.png" class="next"/>
            <img src="./assets/last.png" class="last"/>
            <select class="pagesize">
                <option selected="selected"  value="10">10</option>
                <option value="20">20</option>
                <option value="30">30</option>
                <option  value="40">40</option>
            </select>
        </form>
    </div>
<?php } else {
    echo '<h2>There was an error.</h2>';
}
