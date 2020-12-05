<?php  
    header("Content-Type:application/json");

    if (isset($_POST['title']) && $_POST['title'] != "") {
        require('Connections/db.php');
        $title = $_POST['title'];
        $query = "SELECT * FROM `campaigns` WHERE Title='$title'";
        $result = mysqli_query($con, $query);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            $startDate = $row['Start Date'];
            $endDate = $row['End Date'];
            $voucher = $row['Voucher'];
            response($title, $startDate, $endDate, $voucher);
            mysqli_close($con);
        } else {
            response(NULL, NULL, NULL, NULL, "No Record Found");
        }
    } else {
        response(NULL, NULL, NULL, NULL, "Invalid Request");
    }

    function response($title, $startDate, $endDate, $voucher) {
        $response['title'] = $title;
        $response['startDate'] = $startDate;
        $response['endDate'] = $endDate;
        $response['voucher'] = $voucher;

        $json_response = json_encode($response, JSON_PRETTY_PRINT);
//        echo $json_response;
        
         /* sanity check */
        if (json_decode($json_response) != null)
        {
          $file = fopen('JSON/'.$title.'.json','w+');
          fwrite($file, json_encode($response, JSON_PRETTY_PRINT));
          fclose($file);
          header('Location: index.php');
        }
                
        // Check Contents on page
//        $json = file_get_contents("JSON/campaign.json");
//        $json_data = json_decode($json);
//        print_r($json_data);
    }
?>