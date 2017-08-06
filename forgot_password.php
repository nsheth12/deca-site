<?php
require("./includes/logged_in_redirect.inc.php");

$sent_password = false;
$error = false;
if (isset($_POST['forgot_password_email'])){
    $email = $_POST['forgot_password_email'];

    require_once("./includes/connection.inc.php");

    $conn = dbConnect('write');
    $sql = 'UPDATE users SET password = ? WHERE email = ? AND con_code IS NULL';
    $stmt = $conn->stmt_init();
    $stmt = $conn->prepare($sql);
    $new_password = md5(uniqid(rand()));
    $stmt->bind_param('ss', password_hash($new_password, PASSWORD_DEFAULT), $_POST['forgot_password_email']);
    $stmt->execute();
    if ($stmt->affected_rows == 1){
        $subject = "Your NEO Password";
        $message = "As you requested, your NEO password is: " . $new_password;
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
        <button type="submit" class="btn btn-success" name="frgPword" id="frgPword">Reset Password</button>
    </form>
<?php } else { ?>
    A temporary password has been sent to your email address. Please be patient as you wait for it to arrive. Once you get the password, you can log in and change it to a password of your preference.
<?php } ?>

<?php
require_once("./includes/template_end.inc.php");
?>
