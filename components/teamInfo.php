<div id='team-info' class='hide-on-med-and-down blue lighten-4 blue-text text-darken-4 z-depth-2'>

    <!-- Profile panel -->
    <div class="row">

        <?php
        if (isset($_SESSION['teamID'])) {
            printf('<h5 class="col s12 center">' . $_SESSION['teamName'] . '</h5></br><h6 class="col s12 center"> aka ' . $_SESSION['teamNick'] . '</h6>');
        }
        ?>

    </div>
    <div class="divider blue darken-4"></div>
    <div class="row">
        <div class="col s12">
            <h5 class="center">Members:</h5>
            <ul class="icons_list">
                <?php
                // căutăm toți membrii care au team_index $_SESSION['teamID'] pasul 1
                $sql = "SELECT * FROM teammembers WHERE team_index=?;";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    echo $_SESSION['dbError'];
                } else {
                    // căutăm mebrii, pasul 2
                    mysqli_stmt_bind_param($stmt, "i", $_SESSION['teamID']);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    $resultCheck = mysqli_num_rows($result);

                    // dacă am găsit vreun rezultat,
                    if ($resultCheck > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            // stocăm rezultatele găsite într-un array
                            $team_membersIDS[] = $row;
                        }
                    } else {
                        echo $_SESSION['dbError'];
                    }
                    mysqli_stmt_close($stmt);
                }
                // pentru fiecare rezultat găsit, luăm username din tabelul users
                foreach ($team_membersIDS as $memberID) {
                    $sql = "SELECT * FROM users WHERE user_index=?;";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        echo $_SESSION['dbError'];
                    } else {
                        mysqli_stmt_bind_param($stmt, "i", $memberID['user_index']);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        $resultCheck = mysqli_num_rows($result);

                        if ($resultCheck > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                // stocăm username-urile într-un array
                                $team_members[] = $row;
                            }

                            mysqli_stmt_close($stmt);
                        }
                    }
                }
                // afișăm pe ecran username-ul fiecărui membru din echipă
                foreach ($team_members as $member) {
                    printf('
                        <li>
                            <a href="#" class="blue-text text-darken-4">
                                <i class="material-icons">person</i>'
                        . $member['username'] . '
                            </a>
                        </li>
                    ');
                }
                ?>
            </ul>
        </div>
    </div>

</div>