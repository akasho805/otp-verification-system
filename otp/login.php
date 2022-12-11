<?php
    if(isset($_POST['login']))
    {
		$email = $_POST['email'];
        $password = $_POST['password'];

        $conn = mysqli_connect("localhost","root","","otp");
        $sql ="select * from users where email ='".$email."'";
        $result=mysqli_query($conn,$sql);

        if(mysqli_num_rows($result)==0)
        {
            die("Email not found.");
        }

        $user = mysqli_fetch_object($result);

        if(!password_verify($password,$user->password))
        {
            die("Password is incorrect.");
        }


        if($user->verified_at == null)
        {
            die("Please verify your email <a href='email-verification.php?email=".$email."'>from here</a>");
        }

        echo "<p>Your login logic here</p>";
        exit();
    }
?>

<form method="POST">
    <input type="email" name="email" placeholder="Enter Email" required>
    <input type="password" name="password" placeholder="Enter password" required>

    <input type="submit" name="login" value="Login">

</form>