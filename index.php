<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<?php session_start(); ?>

<?php if(isset($_GET['logout'])){ 
    session_destroy();
    unset($_SESSION['username']);
    header('location:login.php');   
} ?>

<?php if ($_SESSION['username']) { ?>

    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">

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

    <html>
        <head>
            <meta charset="UTF-8">
            <title>iConvert Tech Test</title>
        </head>
        <body>
            Please use the navigation bar to either Insert, View or Remove Campaigns.
        </body>
    </html>

    <?php
} else {
    header('Location: login.php');
}
?>
