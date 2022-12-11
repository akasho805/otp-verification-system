<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require "./PHPMailer-master/src/Exception.php";
	require "./PHPMailer-master/src/PHPMailer.php";
	require "./PHPMailer-master/src/SMTP.php";

	if(isset($_POST['register']))
	{
        $name=$_POST["name"];
		$email = $_POST['email'];
        $password = $_POST['password'];

                $mail = new PHPMailer(true);                             
			    try {
			        //Server settings
			        $mail->isSMTP();                                     
			        $mail->Host = 'smtp.gmail.com';                      
			        $mail->SMTPAuth = true;                               
			        $mail->Username = 'care.scribble@gmail.com';     
			        $mail->Password = 'njxxaylcgmbqslfe';                    
			        $mail->SMTPOptions = array(
			            'ssl' => array(
			            'verify_peer' => false,
			            'verify_peer_name' => false,
			            'allow_self_signed' => true
			            )
			        );                         
			        $mail->SMTPSecure = 'ssl';                           
			        $mail->Port = 465;                                   

			        $mail->setFrom('care.scribble@gmail.com');
			        
			        //Recipients
			        $mail->addAddress($email);              
			        $mail->addReplyTo('care.scribble@gmail.com');
			       
			        //Content
                    $verification_code=random_int(100000,999999);
			        $mail->isHTML(true);                                  
			        $mail->Subject = 'Email verification';
                    $message = '
					<p>Verification code for '. $email .': <b style="font-size:30px;">' .$verification_code.'</b></p>
				';
			        $mail->Body    = $message;

			        $mail->send();
				
                    $pass = password_hash($password,PASSWORD_DEFAULT);

                    $conn = mysqli_connect("localhost","root","","otp");
                    $sql ="insert into users(name, email, password,verification_code,verified_at) VALUES ('".$name."','".$email."','".$pass."','".$verification_code."',
                    NULL)";

                    mysqli_query($conn,$sql);

                    header("Location:email-verification.php?email=".$email);
                    exit();
                }
			    catch (Exception $e) {
			        $_SESSION['error'] = 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo;
			    }
			}		
?>

<form method="POST">
    <input type="text" name="name" placeholder="Enter name" required>
    <input type="email" name="email" placeholder="Enter Email" required>
    <input type="password" name="password" placeholder="Enter password" required>

    <input type="submit" name="register" value="Register">
</form>