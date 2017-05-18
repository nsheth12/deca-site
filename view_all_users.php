<?php
require_once('./includes/admin_redirect.inc.php');
require_once('./includes/connection.inc.php');
require_once('./includes/cluster_utilities.inc.php');

$conn = dbConnect('read');

$sql = 'SELECT * FROM users WHERE con_code IS NULL ORDER BY first_name';
$result = $conn->query($sql);

$title = "View All Students | NEO";
require_once('./includes/template_begin.inc.php');

if ($result !== false && $result->num_rows != 0){ ?>
    <table class="table tablesorter" id="usersTable">
        <thead>
            <tr>
                <th style="border-top: none;">First Name</th>
                <th style="border-top: none;">Last Name</th>
                <th style="border-top: none;"># Attempts</th>
                <th style="border-top: none;"># Correct</th>
                <th style="border-top: none;">% Correct</th>
                <th style="border-top: none;">Cluster</th>
                <th style="border-top: none;"></th>
                <th style="border-top: none;"></th>
            </tr>
        </thead>
        <tbody>
        <?php while ($user = $result->fetch_assoc()) {
            $uid = $user['user_id'];
            $admin = true;
            require('./includes/calc_stats.inc.php');
            ?>
            <tr>
                <td><?php echo ucfirst($user['first_name']); ?></td>
                <td><?php echo ucfirst($user['last_name']); ?></td>
                <td><?php if ($error) echo 'N/A';
                else {
                    echo htmlspecialchars($totalAttempts);
                } ?></td>
                <td><?php if ($error) echo 'N/A';
                else {
                    echo htmlspecialchars($solved);
                } ?></td>
                <td><?php if ($error) echo 'N/A';
                else {
                    echo htmlspecialchars($percentage) . '%';
                } ?></td>
                <td style="white-space: nowrap;"><?php echo getClusterName($user['cluster_id']); ?></td>
                <td><a href="<?php echo 'view_user.php?firstName=' . urlencode($user['first_name']) . '&lastName=' . urlencode($user['last_name']) . '&dataType=report';?>">Details</a></td>
                <td style="white-space: nowrap;"><a href="<?php echo 'view_user.php?firstName=' . urlencode($user['first_name']) . '&lastName=' . urlencode($user['last_name']) . '&dataType=problem_hist';?>">Problem History</a></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <script>
        $(document).ready(function()
            {
                $("#usersTable").tablesorter({theme: 'default', sortList: [[0, 0]]});
            }
        );
    </script>
<?php }
require_once('./includes/template_end.inc.php');
?>
