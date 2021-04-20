<?php
require 'dbconn.inc.php';

if (isset($_POST['submit'])) {

    #variabile pt datele din form
    $projectName = $_POST['projectName'];
    $cardColor = $_POST['cardColor'];
    $startDateStr = $_POST['startDate'];
    $endDateStr = $_POST['endDate'];
    $responsible1 = $_POST['responsible1'];
    $responsible2 = $_POST['responsible2'];
    $teamID = $_POST['teamID'];

    $startDate = strtotime($startDateStr);
    $endDate = strtotime($endDateStr);
    $DBError = "We are sorry! A database error has occured. Please try again later!";

    #checking for empty fields
    if (empty($projectName) || empty($cardColor) || empty($startDateStr) || empty($endDateStr) || empty($responsible1) || empty($responsible2)) {
        echo "<span class='red-text'>All the required fields need to be filled in!</span>";
        if (empty($projectName)) {
            echo "<script> document.querySelector('#project_name').classList.add('invalid'); </script>";
        }
        if (empty($cardColor)) {
            echo "<script> document.querySelector('#card_color').classList.add('invalid'); </script>";
        }
        if (empty($startDateStr)) {
            echo "<script> document.querySelector('#project_start').classList.add('invalid'); </script>";
        }
        if (empty($endDateStr)) {
            echo "<script> document.querySelector('#project_end').classList.add('invalid'); </script>";
        }
        if (empty($responsible1)) {
            echo "<script> document.querySelector('#responsible1').classList.add('invalid'); </script>";
        }
        if (empty($responsible2)) {
            echo "<script> document.querySelector('#responsible2').classList.add('invalid'); </script>";
        }
    }

    #checking for correct dates
    else if ($startDate > $endDate) {
        echo "<span class='red-text'>Check the dates again!</span>
        <script>document.getElementById('project_start').classList.add('invalid');
            document.getElementById('project_end').classList.add('invalid');
            </script>";
    }


    #preparing the database for insertion
    else {
        $sql = "INSERT INTO projects (project_name, pstart_date, pend_date, respo1_index, respo2_index, team_index, card_color) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        #making sure the info is correct
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo $DBError;
        } else {
            #inserting the data into the database
            mysqli_stmt_bind_param($stmt, "sssiiis", $projectName, $startDateStr, $endDateStr, $responsible1, $responsible2, $teamID, $cardColor);
            mysqli_stmt_execute($stmt);
            #receiving the code
        }
        mysqli_stmt_close($stmt);
        echo "<script>location.reload();</script>";
        exit();
    }
}

#if no form submitted
else {
    echo "submit button not pressed";
    exit();
}
