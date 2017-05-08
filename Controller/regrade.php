<?php
require_once("support.php");
require '../PHPMailer-master/PHPMailerAutoload.php';

$body = <<<EOBODY
    <form action="{$_SERVER['PHP_SELF']}" method="post">
        <strong>Name: </strong><input type="text" name="name" /><br>
        <strong>Assignment #: </strong><input type="text" name="assignment" /><br>
        <strong>Specifications:
        <textarea name="specification"></textarea><br>
		<input type="submit" name="submit data" value="Submit Data"/> <br><br>
    </form>
    <a class="btn btn-default" href="main.html">Return to main menu</a><br>
EOBODY;

if(isset($_POST["submit_data"])) {
    $body = "<p>the following information has been submitted to your grader</p><br>";
    $body .= "<p>Name: " . $_POST["name"] . "</p>";
    $body .= "<p>Assignment number: " . $_POST["assignment"] . "</p>";
    $body .= "<p>Specifications: " . $_POST["specification"] . "</p>";


    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPSecure = 'ssl';
    $mail->SMTPAuth = true;
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 465;
    $mail->Username = 'stone.shanshiwang@gmail.com';
    $mail->Password = 'wss670130';
    $mail->setFrom('stone.shanshiwang@gmail.com');
//    $mail->addAddress('swang30@umd.edu');
    $mail->Subject = 'Your Regrade Request';
    $mail->Body = $body;
//send the message, check for errors
    if (!$mail->send()) {
        echo "ERROR: " . $mail->ErrorInfo;
    } else {
        $body .= "<p>You will receive a confirmation email soon</p>";
    }

}


echo generatePage($body);
?>