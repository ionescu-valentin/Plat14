<?php
// variable to check if there are any projects created
$noProjects = false;

// căutăm proiectele care au team_index $_SESSION['teamID'] pasul 1
$sql = "SELECT * FROM projects WHERE team_index=?;";
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sql)) {
    echo $_SESSION['dbError'];
} else {
    // căutăm mebrii, pasul 2
    mysqli_stmt_bind_param($stmt, "i", $_SESSION['teamID']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $resultCheck = mysqli_num_rows($result);

    // dacă există proiecte
    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // stocăm rezultatele găsite într-un array
            $projects[] = $row;
        }
    } else {
        // dacă nu există proiecte
        echo 'No projects yet. Wanna add a new one?';
        $noProjects = true;
    }
    mysqli_stmt_close($stmt);
}

// dacă există proiecte
if (!$noProjects) {
    // pentru fiecare rezultat găsit, luăm proiectul din tabelul projects
    for ($i = 0; $i < count($projects); $i++) {
        $projectReminders = [];
        $projectWarnings = [];
        $projectKTAs = [];
        $projectOthers = [];
        $responsibles = [];
        // add the first element to the empty array
        if ($emptyArr) {
            $projectIDS[] = $projects[$i]['project_index'];
            $emptyArr = false;
        } else {
            // if the array is not empty
            array_push($projectIDS, $projects[$i]['project_index']);
        }
        // căutăm responsabilii in tebelul users
        $sql = "SELECT * FROM users WHERE user_index=?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo $_SESSION['dbError'];
        } else {
            // căutăm responsabilul 1
            mysqli_stmt_bind_param($stmt, "i", $projects[$i]['respo1_index']);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $resultCheck = mysqli_num_rows($result);

            // dacă am găsit vreun rezultat,
            if ($resultCheck > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    // stocăm rezultatele găsite într-un array
                    $responsible1 = $row;
                }
            } else {
                echo $_SESSION['dbError'];
            }
            // căutăm responsabilul 2
            mysqli_stmt_bind_param($stmt, "i", $projects[$i]['respo2_index']);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $resultCheck = mysqli_num_rows($result);

            // dacă am găsit vreun rezultat,
            if ($resultCheck > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    // stocăm rezultatele găsite în același array
                    $responsible2 = $row;
                }
            } else {
                echo $_SESSION['dbError'];
            }

            mysqli_stmt_close($stmt);
        }

        $sql = "SELECT * FROM project_items WHERE parent_index=?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo $_SESSION['dbError'];
        } else {
            // căutăm responsabilul 1
            mysqli_stmt_bind_param($stmt, "i", $projects[$i]['project_index']);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $resultCheck = mysqli_num_rows($result);

            if ($resultCheck > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    if ($row['pitem_type'] == "reminder") {
                        $projectReminders[] = $row;
                    } else if ($row['pitem_type'] == "warning") {
                        $projectWarnings[] = $row;
                    } else if ($row['pitem_type'] == "advice") {
                        $projectKTAs[] = $row;
                    } else if ($row['pitem_type'] == "other") {
                        $projectOthers[] = $row;
                    }
                }
            }
            mysqli_stmt_close($stmt);
        }

        // the project card
        echo '<div class="card ' . $projects[$i]['card_color'] . ' projectCard modal-trigger" data-target="modal-project' . $i . '" id="project_card' . $i . '">
    <div class="card-content white-text">
        <div class="row">
            <div class="col s8">
                <span class="card-title">' . $projects[$i]['project_name'] . '</span>
            </div>
            <div class="col s4 ">
                <div class="row respo-members" id="respo-members' . $i . '">
                    <div class="col s6">
                        <div class="respo-member z-depth-2 right tooltipped" data-position="top" data-tooltip="' . $responsible1['username'] . '">';
        if ($responsible1['avatar'] == 'noAvatar') {
            echo '<i class="material-icons">person</i>';
        } else {
            echo '<img src="images/profile_icons/' . $responsible1['avatar'] . '.png">';
        }
        echo '</div>
                    </div>
                    <div class="col s6">
                        <div class="respo-member z-depth-2 left tooltipped" data-position="top" data-tooltip="' . $responsible2['username'] . '">';
        if ($responsible2['avatar'] == 'noAvatar') {
            echo '<i class="material-icons">person</i>';
        } else {
            echo '<img src="images/profile_icons/' . $responsible2['avatar'] . '.png">';
        }
        echo '</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="progressBar tooltipped" data-position="bottom">
            <div class="progress white z-depth-1">
                <div class="determinate blue darken-4" id=""></div>
            </div>
        </div>
    </div>
    <div class="card-action" id="card_info' . $i . '">
        <span class="transparent">ghost</span>
        <span class="new badge pink darken-2 z-depth-1" data-badge-caption="KT Advice">' . count($projectKTAs) . '</span>
        <span class="new badge blue darken-3 z-depth-1" data-badge-caption="reminder(s)">' . count($projectReminders) . '</span>
        <span class="new badge yellow darken-4 z-depth-1 " data-badge-caption="issue(s)">' . count($projectWarnings) . '</span>
    </div>
</div>
<script>';

        if ($i == (count($projects) - 1)) {
            echo '
        // the filling of the progress bar
        const progress = document.querySelectorAll(".determinate");
        const progressBar = document.querySelectorAll(".progressBar");

        let startDate = new Date("' . $projects[0]['pstart_date'] . '");
        let endDate = new Date("' . $projects[0]['pend_date'] . '");
        let today = new Date();
        // interval between start date and end date
        let timeIntervalMins = (endDate.getTime() - startDate.getTime())/(1000 * 60);
        // the progress since start date in minutes
        let progressMins = (today.getTime() - startDate.getTime())/(1000 * 60);
        // the percentage of the progressBar that is filled
        let percentage = Math.round((progressMins * 100)/timeIntervalMins);
        // number of days left
        let daysLeft = Math.round((endDate.getTime() - today.getTime()) / (1000 * 60 * 60 * 24));
        if (daysLeft < 1) daysLeft = 1;
        // number of days until the projects begins
        let daysTilStart = Math.round(Math.abs(progressMins/60/24));
        // number of days since the project ended
        let daysSinceEnd = Math.round(Math.abs((today.getTime() - endDate.getTime())/(1000 * 60 * 60 * 24) - 1));
        ';

            for ($v = 0; $v < count($projects); $v++) {
                echo '
            // if start date did not pass yet
            if(progressMins <= 0){
                progress[' . $v . '].style.textAlign = "left";
                progress[' . $v . '].style.width = "100%";
                progress[' . $v . '].innerHTML = "0%";
                progress[' . $v . '].classList.remove("darken-4");
                progress[' . $v . '].classList.remove("blue");
                progress[' . $v . '].classList.add("white");
                progress[' . $v . '].classList.add("blue-text");
                progressBar[' . $v . '].setAttribute("data-tooltip", daysTilStart + " day(s) until we start!");
            } else if(percentage <= 10){
                progress[' . $v . '].style.width = "10%";
                progress[' . $v . '].innerHTML = percentage + "%";
                progressBar[' . $v . '].setAttribute("data-tooltip", daysLeft + " day(s) left!");
            } else if(percentage > 100){
                // if the end date has passed
                progress[' . $v . '].style.width = "100%";
                progress[' . $v . '].innerHTML = "100%";
                progressBar[' . $v . '].setAttribute("data-tooltip", daysSinceEnd + " day(s) since finished!");
            } else {
                progress[' . $v . '].style.width = percentage + "%";
                progress[' . $v . '].innerHTML = percentage + "%";
                progressBar[' . $v . '].setAttribute("data-tooltip", daysLeft + " day(s) left!");
            }';
                if ($v !== (count($projects) - 1)) {
                    echo '
            startDate = new Date("' . $projects[($v + 1)]['pstart_date'] . '");
            endDate = new Date("' . $projects[($v + 1)]['pend_date'] . '");
            timeIntervalMins = (endDate.getTime() - startDate.getTime())/(1000 * 60);
            progressMins = (today.getTime() - startDate.getTime())/(1000 * 60);
            percentage = Math.round((progressMins * 100)/timeIntervalMins);
            daysLeft = Math.round((endDate.getTime() - today.getTime()) / (1000 * 60 * 60 * 24));
            if (daysLeft < 1) daysLeft = 1;
            daysTilStart = Math.round(Math.abs(progressMins/60/24));
            daysSinceEnd = Math.round(Math.abs((today.getTime() - endDate.getTime())/(1000 * 60 * 60 * 24) - 1));
            ';
                }
            }
        }
        echo '
</script>';
    }
}
