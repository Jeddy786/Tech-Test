<!DOCTYPE html>
<html>

    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">

    <head>
        <meta charset="utf-8">
        <title>Registration</title>
    </head>
    <body>
        <?php
        require('Connections/db.php');

        error_reporting(0);

// If form submitted, insert values into the database.

        if (isset($_REQUEST)) {
            if ($_REQUEST['cPassword'] != $_REQUEST['cPassword']) {
//            echo "<script type='text/javascript'>alert(Both Passwords Don't Match. Please Try Again!);</script>";
                echo "Both Passwords Don't Match. Please Try Again!";
            } else {

                if (isset($_REQUEST['username'])) {
                    // removes backslashes
                    $username = stripslashes($_REQUEST['username']);
                    //escapes special characters in a string
                    $username = mysqli_real_escape_string($con, $username);
                    $email = stripslashes($_REQUEST['email']);
                    $email = mysqli_real_escape_string($con, $email);
                    $password = stripslashes($_REQUEST['password']);
                    $password = mysqli_real_escape_string($con, $password);
                    $trn_date = date("Y-m-d H:i:s");
                    $query = "INSERT into `users` (username, password, email)
            VALUES ('$username', '" . md5($password) . "', '$email')";
                    $result = mysqli_query($con, $query);
                    if ($result) {
                        echo "<div class='form'>
                        <h3>You are registered successfully.</h3>
                        <br/>Click here to <a href='login.php'>Login</a>
                     </div>";
                    }
                } else {
                    ?>

                    <div id="container" class="container">
                        <div class="row">
                            <div class="col-sm-10 offset-sm-1 text-center">
                                <h1>Registration</h1>
                                <form class="justify-content-center" name="registration" action="" method="post">
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input type="text" name="username" placeholder="Username" required />
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="email" placeholder="Email" required />
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" title="Password must be 8 characters including 1 uppercase letter, 1 lowercase letter and numeric characters" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" name="password" placeholder="Password" required />
                                    </div>
                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <input type="password" title="Password must be 8 characters including 1 uppercase letter, 1 lowercase letter and numeric characters" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" name="cPassword" placeholder="Password" required />
                                    </div>
                                    <input class="btn btn-success" type="submit" name="submit" value="Register" />
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
        }
        ?>
    </body>
</html>