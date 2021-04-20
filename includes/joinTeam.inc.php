<?php
require 'dbconn.inc.php';

// Dacă a ajuns aici de la Join team button
if (isset($_POST['submit'])) {
    // verificăm dacă are deja o echipă
    $sql = "SELECT * FROM teammembers WHERE user_index=?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "<span class='red-text'>We are sorry! A database error has occured. Please try again later!</span>";
    } else {
        mysqli_stmt_bind_param($stmt, "i", $_SESSION['userID']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
        if ($row = mysqli_fetch_assoc($result)) {
            $hasTeam = true;
        } else {
            $hasTeam = false;
        }
    }

    if ($hasTeam) {
        echo "<span class='red-text'>Oops, how did you get here? You already have a team!</br>Please contact us at support@247.foryou</span>";
    } //Dacă nu are deja echipă...
    else {
        #variabile pt datele de logare
        $teamName = $_POST['teamName'];
        $teamCode = $_POST['teamCode'];

        #in caz ca vreun camp e gol
        if (empty($teamName) || empty($teamCode)) {
            echo "<span class='red-text'> Oops! You did not enter any code.</span>
        <script>document.getElementById('teamName').classList.add('invalid');
                document.getElementById('teamCode').classList.add('invalid');
        </script>";
        }

        #verificam daca baza de date e ok
        else {
            $sql = "SELECT * FROM teams WHERE team_name=?;";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                echo "<span class='red-text'>We are sorry! A database error has occured. Please try again later!</span>";

                #verificam daca datele sunt corecte
            } else {
                mysqli_stmt_bind_param($stmt, "s", $teamName);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if ($row = mysqli_fetch_assoc($result)) {
                    $codeCheck = password_verify($teamCode, $row['team_code']);

                    mysqli_stmt_close($stmt);

                    // verificăc dacă codul introdus e corect
                    if ($codeCheck === false) {
                        echo "<span class='red-text'>Uh-oh! The code is incorrect!</span>
                    <script>document.getElementById('teamCode').classList.add('invalid');</script>";
                    } else if ($codeCheck === true) {
                        // cream o sesiune pentru echipă
                        session_start();
                        $_SESSION['teamID'] = $row['team_index'];
                        $_SESSION['teamName'] = $row['team_name'];
                        $_SESSION['teamNick'] = $row['team_nickname'];

                        // adăugăm echipa în baza de date a userului
                        $sqlTeam = "INSERT INTO teammembers (user_index, team_index) VALUES (?, ?)";
                        $stmt = mysqli_stmt_init($conn);

                        #making sure the info is correct
                        if (!mysqli_stmt_prepare($stmt, $sqlTeam)) {
                            echo "We are sorry! A database error has occured. Please try again later!";
                        } else {
                            mysqli_stmt_bind_param($stmt, "ii", $_SESSION['userID'], $_SESSION['teamID']);
                            mysqli_stmt_execute($stmt);
                        }
                        mysqli_stmt_close($stmt);

                        echo "<script>location.reload();</script>";
                        exit();
                    } else {
                        echo "<span class='red-text'>Hmm! Looks like that's not your team's name and code.</span>
                    <script>document.getElementById('teamCode').classList.add('invalid');
                    document.getElementById('teamName').classList.add('invalid');
                    </script>";
                    }
                } else {
                    echo "<span class='red-text'>You way want to check the team name!</span>
                <script>document.getElementById('teamName').classList.add('invalid');</script>";
                }
            }
        }
    }
} else {
    echo "<span class='red-text'>You weren't trying to join a team, were you?</span>";
}
