<?php
require 'dbconn.inc.php';

if (isset($_POST['optionValue'])) {

    #variabile pt datele din form
    $optionValue = $_POST['optionValue'];
    $optionName = $_POST['optionName'];
    $projectID = $_POST['projectID'];
    $projectsCount = $_POST['projectsCount'];

    $DBError = "We are sorry! A database error has occured. Please try again later!";
    // echo $optionName . " " . $optionValue;
    #preparing the database for insertion
    if ($optionName == "name") {
        $sql = "UPDATE projects SET project_name = '" . $optionValue . "' WHERE project_index = ?";
    } else if ($optionName == "since") {
        $sql = "UPDATE projects SET pstart_date = '" . $optionValue . "' WHERE project_index = ?";
    } else if ($optionName == "until") {
        $sql = "UPDATE projects SET pend_date = '" . $optionValue . "' WHERE project_index = ?";
    } else if ($optionName == "respo1") {
        $sql = "UPDATE projects SET respo1_index = '" . $optionValue . "' WHERE project_index = ?";
    } else if ($optionName == "respo2") {
        $sql = "UPDATE projects SET respo2_index = '" . $optionValue . "' WHERE project_index = ?";
    } else if ($optionName == "color") {
        $sql = "UPDATE projects SET card_color = '" . $optionValue . "' WHERE project_index = ?";
    } else {
        echo 'wtf';
    }

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        echo "We are sorry! A database error has occured. Please try again later!";
    } else {
        mysqli_stmt_bind_param($stmt, "i", $projectID);
        mysqli_stmt_execute($stmt);
    }

    mysqli_stmt_close($stmt);
    #closing the connection with the database
    mysqli_close($conn);

    echo '
            <script>
                document.querySelector("#close-OE-modal").click();
                ';
    for ($i = 0; $i < ($projectsCount); $i++) {
        echo '$("#modal-options' . $i . '").load(location.href + " #modal-options' . $i . '" + ">*","");
        ';
        if ($optionName == "name") {
            echo '$("#project-name' . $i . '").load(location.href + " #project-name' . $i . '" + ">*","");';
        }
        if ($optionName == "respo1" || $optionName == "respo2") {
            echo '$("#respo-members' . $i . '").load(location.href + " #respo-members' . $i . '" + ">*","");';
        }
    }

    echo '
    // setModalOptionData(j, i);
            // event listener to show the option data edit modal
        $(document).on("click", "a", function () {
            for(let i = 0; i < document.querySelectorAll(".options_values").length; i++) {
                for(let j = 1; j < 12; j+=2){
                    if(document.querySelectorAll(".options_values")[i].childNodes[j] == this){
                        setModalOptionData(j, i);
                    }
                }
            }
        });
            </script>';
}

#if no edit intended
else {
    echo "Internal error!";
    exit();
}
