<?php
require("./includes/logged_in_redirect.inc.php");

$sent_password = false;
$error = false;
if (isset($_POST['forgot_password_email'])){
    $email = $_POST['forgot_password_email'];

    require_once("./includes/connection.inc.php");

    $conn = dbConnect('read');
    $sql = 'SELECT password FROM users WHERE email = ? AND con_code IS NULL';
    $stmt = $conn->stmt_init();
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $_POST['forgot_password_email']);
    $stmt->bind_result($pword);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows == 1){
        $stmt->fetch();

        $subject = "Your NEO Password";
        $message = "As you requested, your NEO password is: " . $pword;
        $sentmail = mail($email, $subject, $message);

        $sent_password = true;
    }
    else{
        $error = true;
    }
}

$title = "Forgot Password | NEO";
require_once("./includes/template_begin.inc.php");
?>

<?php if (!$sent_password) { ?>
    <?php if ($error) echo "The email you entered is invalid. Please try again."; ?>
    <form action="" method="post" id="frgPword" style="width: 300px; margin-top: 10px;">
        <div class="form-group">
            <label for="email">Email Address Used to Sign Up for NEO:</label>
            <input type="email" name="forgot_password_email" id="email" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success" name="frgPword" id="frgPword">Recover Password</button>
    </form>
<?php } else { ?>
    Your password has been sent to your email address. Please be patient as you wait for it to arrive.
<?php } ?>

<?php
require_once("./includes/template_end.inc.php");
?>
