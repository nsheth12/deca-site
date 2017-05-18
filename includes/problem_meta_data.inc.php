<?php
$statsSql = 'SELECT * FROM attempts WHERE problem_id = ' . $problemRow['problem_id'];
$statsResult = $conn->query($statsSql);
$display = false;
$total_attempts = 0;
$num_solved = 0;
$num_students = 0;
$attempts_for_solved = 0;

if ($statsResult !== false){
    $display = true;
    while ($row = $statsResult->fetch_assoc()){
        $total_attempts += (int)$row['number_attempts'];
        $num_solved += (int)$row['solved'];
        $num_students += 1;
        if ((int)$row['solved'] == 1){
            $attempts_for_solved += (int)$row['number_attempts'];
        }
    }
}
?>

<div class="text-center">
    <h3><strong>Cluster:</strong> <?php echo getClusterName($problemRow['cluster_id']); ?></h3>
</div>
<?php if ($display) { ?>
    <h4 style="margin-bottom: 0px;">
    <table class="table table-hover">
        <tr>
            <td style="border-top: none;">Total # of attempts on this problem</td>
            <td style="border-top: none;"><?php echo $total_attempts; ?></td>
        </tr>
        <tr>
            <td># of students who have seen this problem</td>
            <td><?php echo $num_students; ?></td>
        </tr>
        <tr>
            <td># of students who have solved this problem</td>
            <td><?php echo $num_solved; ?></td>
        </tr>
        <tr>
            <td>% of attempts correct</td>
            <td>
                <?php if ($total_attempts == 0){
                    echo 'N/A';
                }
                else{
                    echo strval(round(100 * $num_solved / $total_attempts)) . '%';
                } ?>
            </td>
        </tr>
        <tr>
            <td>Average # of attempts taken to solve this problem</td>
            <td>
                <?php if ($num_solved == 0){
                    echo 'N/A';
                }
                else{
                    echo strval(round($attempts_for_solved / $num_solved, 2));
                } ?>
            </td>
        </tr>
    </table>
    </h4>
<?php } ?>
