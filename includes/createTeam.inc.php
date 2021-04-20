<?php
require 'dbconn.inc.php';

if (isset($_POST['submit'])) {

    #variabile pt datele din form
    $teamName = $_POST['teamName'];
    $teamNick = $_POST['teamNick'];
    $teamType = $_POST['teamType'];
    $startDateStr = $_POST['startDate'];
    $endDateStr = $_POST['endDate'];
    if (isset($_POST['submit'])) {
        $teamMotto = $_POST['teamMotto'];
    } else {
        $teamMotto = " ";
    }

    $startDate = strtotime($startDateStr);
    $endDate = strtotime($endDateStr);
    $teamCode = rand(10000, 99999);
    $DBError = "We are sorry! A database error has occured. Please try again later!";

    #checking for taken username/email
    $takenName = false;
    $takenCode = false;

    #TEAM NAME DATABASE SEARCH
    $sqlName = "SELECT team_name FROM teams WHERE team_name=?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sqlName)) {
        echo $DBError;
    } else {
        mysqli_stmt_bind_param($stmt, "s", $teamName);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $userResultCheck = mysqli_stmt_num_rows($stmt);

        if ($userResultCheck > 0) {
            $takenName = true;
        }
    }

    mysqli_stmt_close($stmt);

    #Team CODE DATABASE SEARCH
    $sqlCode = "SELECT team_code FROM teams WHERE team_code=?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sqlCode)) {
        echo $DBError;
    } else {
        while ($takenCode == true) {
            mysqli_stmt_bind_param($stmt, "i", $teamCode);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $userResultCheck = mysqli_stmt_num_rows($stmt);

            if ($userResultCheck > 0) {
                $takenCode = true;
            }

            $teamCode = rand(10000, 99999);
        }
    }

    mysqli_stmt_close($stmt);

    #checking for empty fields
    if (empty($teamName) || empty($teamNick) || empty($teamType) || empty($startDateStr) || empty($endDateStr)) {
        echo "<span class='red-text'>All the required fields need to be filled in!</span>";
        if (empty($teamName)) {
            echo "<script> document.querySelector('#team_name').classList.add('invalid'); </script>";
        }
        if (empty($teamNick)) {
            echo "<script> document.querySelector('#team_nick').classList.add('invalid'); </script>";
        }
        if (empty($teamType)) {
            echo "<script> document.querySelector('#team_type').classList.add('invalid'); </script>";
        }
        if (empty($startDateStr)) {
            echo "<script> document.querySelector('#start_date').classList.add('invalid'); </script>";
        }
        if (empty($endtDateStr)) {
            echo "<script> document.querySelector('#end_date').classList.add('invalid'); </script>";
        }
    }

    #checking for invalid username
    else if (!preg_match("/^[a-zA-Z0-9._]*$/", $teamName)) {
        echo "<span class='red-text'>The team name must contain only letters, numbers, '_', '.' and be at least 5 characters long!</span>";

        #checking for unmatching passwords
    } else if ($startDate > $endDate) {
        echo "<span class='red-text'>Check the dates again!</span>
        <script>document.getElementById('start_date').classList.add('invalid');
            document.getElementById('end_date').classList.add('invalid');
            </script>";

        #checking for taken username or email
    } else if ($takenName) {
        echo "<span class='red-text'>Your team's name must have a unique name! Use that thing called imagination ;) </span>
            <script>document.getElementById('team_name').classList.add('invalid');
            </script>";
    }


    #preparing the database for insertion
    else {
        $sql = "INSERT INTO teams (team_code, team_name, team_nickname, team_type, mandate_start, mandate_end, team_motto) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        #making sure the info is correct
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo $DBError;
        } else {
            #encrypting the code
            $hashedCode = password_hash($teamCode, PASSWORD_DEFAULT);
            #inserting the data into the database
            mysqli_stmt_bind_param($stmt, "sssssss", $hashedCode, $teamName, $teamNick, $teamType, $startDateStr, $endDateStr, $teamMotto);
            mysqli_stmt_execute($stmt);
            #removing the createTeam-form (the data must be outside the form)
            #receiving the code
            printf("<script>
                    document.getElementById('createTeam-form').remove();
                    </script>
            </br>
            <div class='center'><h5 class='green-text'>The team has been created successfully! </br></br>
                                Team Unique Code: <strong>" . $teamCode . "</strong></h5>
                                <span class='black-text'>Please do not share it with non-teammates!</span>
            </br></br>
            <a class='modal-close btn waves-effect blue darken-2' id='finish-createTeam'>Continue</a></div>");
            exit();
        }
        mysqli_stmt_close($stmt);
    }

    #closing the connection with the database
    mysqli_close($conn);
}

#if no form submitted
else {
    echo "submit button not pressed";
    exit();
}
