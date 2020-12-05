<!-- CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

<?php
require('Connections/db.php');

session_start();

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header('location:login.php');
}

if ($_SESSION['username']) {

    $campaigns = mysqli_query($con, "SELECT * FROM campaigns WHERE Enabled = 1");

    if (isset($_GET["removeID"])) {

        $sql = "UPDATE `campaigns` " . "SET Enabled = 0 " . "WHERE id =" . $_GET["removeID"];

        if (mysqli_query($con, $sql)) {
            //echo "Campaign has been removed!";
            header("Location: viewCampaigns.php");
        } else {
            echo "Error: " . $sql . "" . mysqli_error($con);
        }
        $con->close();
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

    <div class="table-responsive">
        <table class="table" border="1">
            <tr>
                <th>Title</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Image</th>
                <th>Uploaded</th>
                <th>Voucher</th>
                <th></th>
                <th></th>
            </tr>
            <?php while ($row = mysqli_fetch_array($campaigns)) { ?>
                <tr>
                    <td><?php echo $row["Title"]; ?></td>
                    <td><?php echo date("d-m-Y", strtotime($row["Start Date"])); ?></td>
                    <td><?php echo date("d-m-Y", strtotime($row["End Date"])); ?></td>
                    <?php if (!empty($row['Image'])) { ?>
                        <td><img src="data:image/jpeg;base64,<?php echo base64_encode($row['Image']); ?>" width="125px" height="125px" /></td>
                    <?php } else { ?>
                        <td></td>
                    <?php } ?>
                    <?php if (date("d-m-Y", strtotime($row["Uploaded"])) != "01-01-1970") { ?>
                        <td><?php echo date("d-m-Y", strtotime($row["Uploaded"])); ?></td>
                    <?php } else { ?>
                        <td></td>
                    <?php } ?>
                    <td><?php echo $row["Voucher"]; ?></td>
                    <td><a href="editCampaign.php?id=<?php echo $row["ID"]; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
                    <td><a href="#removeModal" class="removeCampaign" data-id="<?php echo $row['ID']; ?>" role="button" data-toggle="modal"><i class="fa fa-trash-o"></i></a></td>
                </tr>
            <?php } ?>
        </table>
    </div>

    <!-- Remove Campaign Modal -->
    <div id="removeModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button style="padding: 0!important; margin: 0!important;" type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 style="margin: auto;" class="modal-title">Remove Campaign Confirmation</h4>
                </div>
                <div class="modal-body">
                    <p class="error-text"><i class="fa fa-warning modal-icon"></i> Are you sure you want to delete this campaign?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <a href="#" class="btn btn-danger" id="modalRemove">Remove</a>
                </div>
            </div>

        </div>
    </div>

    <!-- jQuery and JS bundle w/ Popper.js -->
    <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
    <!--<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $('.removeCampaign').click(function () {
            var id = $(this).data('id');
            $('#modalRemove').attr('href', 'viewCampaigns.php?removeID=' + id);
        });
    </script>

    <?php
} else {
    header('Location: login.php');
}
?>