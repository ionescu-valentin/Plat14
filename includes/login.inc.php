<?php
require 'dbconn.inc.php';

if (isset($_POST['submit'])) {

    #variabile pt datele de logare
    $username = $_POST['username'];
    $password = $_POST['parola'];

    $DBError = "We are sorry! A database error has occured. Please try again later!";

    #in caz ca vreun camp e gol
    if (empty($username) || empty($password)) {
        echo "<span class='red-text'>All fields need to be filled in!</span>
        <script>document.getElementById('parola').classList.add('invalid');
                    document.getElementById('username').classList.add('invalid');
                    </script>";
    }

    #verificam daca baza de date e ok
    else {
        $sql = "SELECT * FROM users WHERE username=?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo $DBError;

            #verificam daca datele sunt corecte
        } else {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {
                $passcheck = password_verify($password, $row['parola']);
                if ($passcheck === false) {
                    echo "<span class='red-text'>Incorrect password!</span>
                    <script>document.getElementById('parola').classList.add('invalid');</script>";
                } else if ($passcheck === true) {
                    session_start();
                    $_SESSION['userID'] = $row['user_index'];
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['name'] = $row['full_name'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['avatar'] = $row['avatar'];
                    $_SESSION['dbError'] = $DBError;

                    mysqli_stmt_close($stmt);

                    $sql = "SELECT * FROM teammembers WHERE user_index=?;";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        echo "<span class='red-text'>We are sorry! A database error has occured. Please try again later!</span>";
                    } else {
                        mysqli_stmt_bind_param($stmt, "i", $_SESSION['userID']);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        if ($row = mysqli_fetch_assoc($result)) {
                            $_SESSION['teamID'] = $row['team_index'];
                        }
                    }

                    mysqli_stmt_close($stmt);

                    $sql = "SELECT * FROM teams WHERE team_index=?;";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        echo $DBError;
                    } else {
                        mysqli_stmt_bind_param($stmt, "i", $_SESSION['teamID']);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        if ($row = mysqli_fetch_assoc($result)) {
                            $_SESSION['teamName'] = $row['team_name'];
                            $_SESSION['teamNick'] = $row['team_nickname'];
                        }
                    }
                    echo "<script>location.reload();</script>";
                    exit();
                } else {
                    echo "<span class='red-text'>Incorrect username and password!</span>
                    <script>document.getElementById('parola').classList.add('invalid');
                    document.getElementById('username').classList.add('invalid');
                    </script>";
                }
            } else {
                echo "<span class='red-text'>Incorrect username!</span>
                <script>document.getElementById('username').classList.add('invalid');</script>";
            }
        }
    }
} else {
    echo "<span class='red-text'>No log in attempt detected!</span>";
}
