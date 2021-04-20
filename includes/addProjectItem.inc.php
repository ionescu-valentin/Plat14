<?php
session_start();
require 'dbconn.inc.php';

if (isset($_POST['submit'])) {

    #variabile pt datele din form
    $itemType = $_POST['itemType'];
    $itemText = $_POST['itemText'];
    $projectID = $_POST['projectID'];
    $projectsCount = (int)$_POST['projectsCount'];

    $DBError = "We are sorry! A database error has occured. Please try again later!";

    #preparing the database for insertion

    if (empty($itemText)) {
        echo '<script>
                document.querySelector("#add_projectItem").classList.add("invalid");
        </script>';
    } else {
        $sql = "INSERT INTO project_items (pitem_type, pitem_text, parent_index) VALUES (?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        #making sure the info is correct
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo $DBError;
        } else {
            #inserting the data into the database
            mysqli_stmt_bind_param($stmt, "ssi", $itemType, $itemText, $projectID);
            mysqli_stmt_execute($stmt);
            #receiving the code
        }
        mysqli_stmt_close($stmt);

        echo '<script>
            $("#hide_textbox").click();';

        for ($i = 0; $i < ($projectsCount * 4); $i++) {
            echo '$("#project_itemsBlock' . $i . '").load(location.href + " #project_itemsBlock' . $i . '" + ">*","");
            ';
        }

        for ($i = 0; $i < ($projectsCount); $i++) {
            echo '$("#card_info' . $i . '").load(location.href + " #card_info' . $i . '" + ">*","");
            ';
        }

        echo '
            $(document).on("click", ".remove_item", function () {
                for (let i = 0; i < document.querySelectorAll(".remove_item").length; i++){
                    if(document.querySelectorAll(".remove_item")[i] == this){
                        removeItem(document.querySelectorAll(".remove_item")[i].parentElement.parentElement.id);
                    }
                }
            });
            </script>';
    }
}

#if no form submitted
else {
    echo "Internal error!";
    exit();
}
