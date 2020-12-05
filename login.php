<html>

    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <body>
        <?php
        require('Connections/db.php');
        session_start();
        if (isset($_POST['username'])) {
            // removes backslashes
            $username = stripslashes($_REQUEST['username']);
            //escapes special characters in a string
            $username = mysqli_real_escape_string($con, $username);
            $password = stripslashes($_REQUEST['password']);
            $password = mysqli_real_escape_string($con, $password);
            //Checking is user existing in the database or not
            $query = "SELECT * FROM `users` WHERE Username='$username' and Password='" . md5($password) . "'";
            echo " Query: " . $query;
            $result = mysqli_query($con, $query) or die(mysql_error());
            $rows = mysqli_num_rows($result);
            if ($rows == 1) {
                $_SESSION['username'] = $username;
                // Redirect user to index.php
                header("Location: index.php");
            } else {
                echo "<div class='form'>
                    <h3>Username or password is incorrect!</h3>
                    <br/>Click here to try again <a href='login.php'>Login</a>
                  </div>";
            }
        } else {
            ?>
            <div id="container" class="container">
                <div class="row">
                    <div class="col-sm-10 offset-sm-1 text-center">
                        <h1 class="display-3">Login</h1>
                        <div class="info-form">
                            <form action="" method="post" name="login" class="justify-content-center">
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" name="username" placeholder="Username" required />
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" name="password" placeholder="Password" required />
                                </div>
                                <input class="btn btn-success" name="submit" type="submit" value="Login" />
                            </form>
                            <p>Not registered yet? <a href='createUser.php'>Register Here</a></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </body>
</html>