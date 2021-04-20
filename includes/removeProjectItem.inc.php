<?php
require 'dbconn.inc.php';

if (isset($_POST['itemID'])) {

    #variabile pt datele din form
    $itemID = (int)$_POST['itemID'];
    $projectsCount = (int)$_POST['projectsCount'];

    $DBError = "We are sorry! A database error has occured. Please try again later!";

    #preparing the database for insertion

    $sql = "DELETE FROM project_items WHERE pitem_index=?";
    $stmt = mysqli_stmt_init($conn);
    #making sure the info is correct
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo $DBError;
    } else {
        #inserting the data into the database
        mysqli_stmt_bind_param($stmt, "i", $itemID);
        mysqli_stmt_execute($stmt);
        #receiving the code
    }
    mysqli_stmt_close($stmt);

    echo '<script>';

    for ($i = 0; $i < ($projectsCount * 4); $i++) {
        echo '$("#project_itemsBlock' . $i . '").load(location.href + " #project_itemsBlock' . $i . '" + ">*","");
        ';
    }

    for ($i = 0; $i < ($projectsCount); $i++) {
        echo '$("#card_info' . $i . '").load(location.href + " #card_info' . $i . '" + ">*","");
        ';
    }

    echo '
            // $(".projectCard .card-action").load(location.href + " .projectCard .card-action" + ">*","");

            $(document).on("click", ".remove_item", function () {
                for (let i = 0; i < document.querySelectorAll(".remove_item").length; i++){
                    if(document.querySelectorAll(".remove_item")[i] == this){
                        removeItem(document.querySelectorAll(".remove_item")[i].parentElement.parentElement.id);
                    }
                }
            });
            </script>';
}

#if no form submitted
else {
    echo "Internal error!";
    exit();
}
