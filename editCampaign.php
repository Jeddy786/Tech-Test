<!DOCTYPE html>
<html>

    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">

    <head>
        <meta charset="utf-8">
        <title>Edit Campaign</title>
    </head>
    <body>

        <?php
        require('Connections/db.php');

        session_start();

        if (isset($_GET['logout'])) {
            session_destroy();
            unset($_SESSION['username']);
            header('location:login.php');
        }

        if ($_SESSION['username']) {

            if (isset($_GET['id']) && $_GET['id'] != "") {
                $id = $_GET['id'];
                $query = "SELECT * FROM `campaigns` WHERE ID='$id'";
                $result = mysqli_query($con, $query);

                if (mysqli_query($con, $query)) {
                    
                } else {
                    echo "Error: " . $sql . "" . mysqli_error($con);
                }
            }

            if (isset($_POST["submit"]) && isset($_GET['id']) && $_GET['id'] != "") {

                if (!empty($_FILES["image"]["name"])) {
                    // Get file info 
                    $fileName = basename($_FILES["image"]["name"]);
                    $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

                    // Allow certain file formats 
                    $allowTypes = array('jpg', 'jpeg', 'png');

                    if (in_array($fileType, $allowTypes)) {
                        $image = $_FILES['image']['tmp_name'];
                        $imgContent = addslashes(file_get_contents($image));

                        $id = $_GET['id'];
                        $title = $_POST['title'];
                        $enabled = $_POST['enable'];
                        $start = date("Y-m-d H:i:s", strtotime($_POST["start"]));
                        $end = date("Y-m-d H:i:s", strtotime($_POST["end"]));
                        $voucher = $_POST['voucher'];

                        $sql = "UPDATE `campaigns` SET Title = '$title', Enabled = $enabled, `Start Date` = '$start',"
                                . " `End Date` = '$end', `Image` = '$imgContent',"
                                . " `Uploaded` = '" . date('Y/m/d H:i:s', strtotime("today")) . "', Voucher = '$voucher' WHERE ID =" . $id;

                        if (mysqli_query($con, $sql)) {
                            header("Location: viewCampaigns.php");
                        } else {
                            echo "Error: " . $sql . "" . mysqli_error($con);
                        }

                        $con->close();
                    }
                } else {
                    $id = $_GET['id'];
                    $title = $_POST['title'];
                    $enabled = $_POST['enable'];
                    $start = date("Y-m-d H:i:s", strtotime($_POST["start"]));
                    $end = date("Y-m-d H:i:s", strtotime($_POST["end"]));
                    $voucher = $_POST['voucher'];

                    $sql = "UPDATE `campaigns` SET Title = '$title', Enabled = $enabled, `Start Date` = '$start', `End Date` = '$end', `Image` = NULL, `Uploaded` = NULL, Voucher = '$voucher' WHERE ID =" . $id;

                    if (mysqli_query($con, $sql)) {
                        header("Location: viewCampaigns.php");
                    } else {
                        echo "Error: " . $sql . "" . mysqli_error($con);
                    }

                    $con->close();
                }
            }
            ?>

            <nav class="navbar navbar-expand-md bg-dark navbar-dark sticky-top">
                <a class="navbar-brand" href="#">iConvert</a>
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navb" aria-expanded="true">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div id="navb" class="navbar-collapse collapse hide">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="insertCampaign.php">Insert Campaign</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="campaignSearch.php">Search Campaigns</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="viewCampaigns.php">View Campaigns</a>
                        </li>
                    </ul>

                    <ul class="nav navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="createUser.php"><span class="fas fa-user"></span> Sign Up</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php"><span class="fas fa-sign-in-alt"></span> Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?logout"><span class="fas fa-sign-in-alt"></span> Logout</a>
                        </li>
                    </ul>
                </div>
            </nav>

            <div id="container" class="container">
                <div class="row">
                    <div class="col-sm-10 offset-sm-1 text-center">
                        <h1>Edit Campaign</h1>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <br />
                            <?php while ($row = mysqli_fetch_array($result)) { ?>
                                <label>Title:</label>
                                <input type="text" name="title" value="<?php echo $row["Title"]; ?>" required/>
                                <br />
                                <label>Enable Campaign:</label>
                                <select name="enable" id="enable">
                                    <?php if ($row["Enabled"] == 1) { ?>
                                        <option value="1" selected>1</option>
                                        <option value="0">0</option>
                                    <?php } else { ?>
                                        <option value="0"selected>0</option>
                                        <option value="1">1</option>
                                    <?php } ?>
                                </select>
                                <br />
                                <label>Start Date:</label>
                                <input type="date" name="start" value="<?php echo date("Y-m-d", strtotime($row["Start Date"])); ?>" required/>
                                <br />
                                <label>End Date:</label>
                                <input type="date" name="end" value="<?php echo date("Y-m-d", strtotime($row["End Date"])); ?>" required/>
                                <br />
                                <label>Select Image File:</label>
                                <input type="file" name="image" accept="image/*">
                                <br />
                                <label>Voucher:</label>
                                <input type="text" name="voucher" value="<?php echo $row["Voucher"]; ?>"/>
                                <br /><br />
                            <?php } ?>
                                <button class="btn btn-success" type="submit" name="submit">Submit</button>
                        </form>
                    </div>
                </div>
            </div>

            <?php
        } else {
            header('Location: login.php');
        }
        ?>

    </body>
</html>