<?php
require('./includes/not_logged_in_redirect.inc.php');
require_once("./includes/connection.inc.php");
require_once("./includes/cluster_utilities.inc.php");

$conn = dbConnect('write');
$sql = 'SELECT * FROM users WHERE user_id = ' . $_SESSION['user_id'];
$result = $conn->query($sql);
$user = $result->fetch_assoc();

$title = "Profile | NEO";
require_once("./includes/template_begin.inc.php");
?>

<script type="text/javascript">
function cycleChange () {
    $.ajax({
        url : 'update_test_cycle.php',
        type : 'POST',
        data : {new_cycle : parseInt($('#cycle').val())-1},
        success : function(){
            alert("Your test cycle was successfully changed.");
        },
        error : function(jqXHR, textStatus, errorThrown){
            alert("There was an error.");
        }
    });
}
</script>

<h4><strong>Name:</strong> <?php echo ucfirst($user['first_name']) . ' ' . ucfirst($user['last_name']); ?></h4>
<h4><strong>Email:</strong> <?php echo $user['email']; ?></h4>
<h4><strong>Cluster:</strong> <?php echo getClusterName($user['cluster_id']); ?></h4>
<?php if ($user['max_cycle'] > 0) {
    $current_cycle = $user['current_cycle']+1;
    ?>

    <h4 style="display: inline-block; margin-top: 0px; margin-bottom: 0px;"><strong>Test Cycle:</strong></h4>
    <select style="display: inline-block;" id="cycle" onchange="cycleChange();">

        <?php for ($i = 1; $i <= $user['max_cycle'] + 1; $i++){ ?>
            <option <?php if ($i == $current_cycle) echo 'selected="selected"'?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
        <?php } ?>
    </select><br>
<?php } ?>
<h4><strong>Password:</strong> <?php for ($i = 0; $i < strlen($user['password']); $i++) echo '*'; ?></h4>
<button id="changePassword" class="btn btn-default" onclick="window.open('change_password.php')">Change Password</button>

<?php
require_once("./includes/template_end.inc.php");
?>
