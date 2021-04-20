<?php
// empty the arrays so their count starts from 0 (to not mess up with ProjectCard)
$projectReminders = array();
$projectWarnings = array();
$projectKTAs = array();
$projectOthers = array();
$respo1 = array();
$respo2 = array();

// some counter that was almost useful
$j = 0;

$addItem_block = '<form action="#" method="post" id="addItem-form">
                    <div class="row">
                        <div class="col s9">
                            <input type="text" id="add_projectItem">
                        </div>
                        <div class="col s3">
                            <div class="row">
                                <div class="col s6">
                                    <button class="btn btn-small blue darken-2" type="submit" id="send_addProjectItem"><i class="material-icons white-text">add</i></button>
                                </div>
                                <div class="col s6">
                                    <button class="btn btn-small red darken-2" type="button" id="hide_textbox"><i class="material-icons white-text">clear</i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>';

$addItem_block = '<form action="#" method="post" id="addItem-form"><div class="row"><div class="col s9"><input type="text" id="add_projectItem"></div><div class="col s3"><div class="row"><div class="col s6"><button class="btn btn-small blue darken-2" type="submit" name="submit" id="send_addProjectItem"><i class="material-icons white-text">add</i></button></div><div class="col s6"><button type="button" class="btn btn-small red darken-2 " id="hide_textbox"><i class="material-icons white-text">clear</i></button></div></div></div></div></form>';

echo '<input type="text" id="ghost_itemID" class="hide">
<input type="text" id="ghost_projectsCount" class="hide">
<input type="text" id="ghost_itemType" class="hide">
<input type="text" id="ghost_ProjectID" class="hide">
<input type="text" id="ghost_ModalID" class="hide">
<p id="addItem_data"></p>
';
// OE = option edit
echo '
<input type="text" id="ghost_optionValue" class="hide">
<input type="text" id="ghost_optionName" class="hide">
<div id="modal-optionEdit" class="modal" style="width: 30rem; max-height: 40rem; height: fit-content; top: 10rem !important;">
    <div class="modal-content">
        <a id="close-OE-modal" class="hide modal-close btn blue">Save</a>
        <div class="row">
            <div class="col s12">
                <h5 id="option-name" class="center"></h5>
            </div>
            <div class="col s8" id="">
                <input type="text" id="text-option-value" class="hide">
                <input type="text" id="date-option-value" class="datepicker">
                <div id="respo1-option-holder" class="hide">
                    <select id="respo1-option-value" class="selectList hide">
                    <option value="" selected disabled>pick</option>';
for ($k = 0; $k < count($team_members); ++$k) {
    printf('<option value="' . $team_members[$k]['user_index'] . '">' . $team_members[$k]['username'] . '</option>');
}
echo '
                     </select>
                </div>
                <div id="respo2-option-holder" class="hide">
                    <select id="respo2-option-value" class="selectList">
                            <option value="" selected disabled>pick</option>';
for ($k = 0; $k < count($team_members); ++$k) {
    printf('<option value="' . $team_members[$k]['user_index'] . '">' . $team_members[$k]['username'] . '</option>');
}
echo '
                    </select>
                </div>
                <div id="color-option-holder" class="input-field hide">
                    <select id="color-option-value" class="selectList">
                        <option value="" disabled selected>pick</option>
                        <option value="red lighten-3">Red</option>
                        <option value="light-blue">Blue</option>
                        <option value="green lighten-2">Green</option>
                    </select>
                </div>

            </div>
            <div class="col s4">
                <div class="center">
                    <a id="save-option-value" class="btn blue">Save</a>
                </div>
            </div>
            <div class="col s12">
                <div class="center">
                    <p id="edit-option-data" class=""></p>
                </div>
            </div>
        </div>
    </div>
</div>
';

for ($i = 0; $i < count($projectIDS); $i++) {
    $projectReminders = [];
    $projectWarnings = [];
    $projectKTAs = [];
    $projectOthers = [];
    $projectCards = [];

    // căutăm proiectele care au team_index $_SESSION['teamID'] pasul 1
    $sql = "SELECT * FROM projects WHERE project_index=?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo $_SESSION['dbError'];
    } else {
        // căutăm mebrii, pasul 2
        mysqli_stmt_bind_param($stmt, "i", $projectIDS[$i]);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $resultCheck = mysqli_num_rows($result);

        // dacă am găsit vreun rezultat,
        if ($resultCheck > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                // stocăm rezultatele găsite într-un array
                $projectCards[] = $row;
            }
        } else {
            echo $_SESSION['dbError'];
        }
        mysqli_stmt_close($stmt);
    }
    $respo1Index = $projectCards[0]['respo1_index'];
    $respo2Index = $projectCards[0]['respo2_index'];
    $sql = "SELECT * FROM users WHERE user_index=?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo $_SESSION['dbError'];
    } else {
        // get the project respos from the users table for each project
        mysqli_stmt_bind_param($stmt, "i", $respo1Index);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $respo1 = $row;
            }
        }

        mysqli_stmt_bind_param($stmt, "i", $respo2Index);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $respo2 = $row;
            }
        }
    }
    mysqli_stmt_close($stmt);


    foreach ($projectCards as $project) {
        // căutăm proiectele care au team_index $_SESSION['teamID'] pasul 1
        $sql = "SELECT * FROM project_items WHERE parent_index=?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo $_SESSION['dbError'];
        } else {
            // căutăm mebrii, pasul 2
            mysqli_stmt_bind_param($stmt, "i", $project['project_index']);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $resultCheck = mysqli_num_rows($result);

            // dacă am găsit vreun rezultat,
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
    }



    echo '<!-- modal projects -->
    <div id="modal-project' . $i . '" class="modal projectModal" style="width: 40rem; max-height: 40rem; min-height: 30rem; height: fit-content; ">
        <div class="modal-content">
        <div class="row">
            <div class="col s6" id="project-name' . $i . '">
                <h4 class="left" >' . $project['project_name'] . '</h4>
            </div>
            <div class="col s6">
            <a href="#!" class="modal-close right waves-effect waves-green btn-flat">Close</a>
            <a href="#!" class="project_options right waves-effect waves-green btn-flat">Options</a>
            </div>
        </div>


            <div class="row modal_collections">
            <div class="col s12">
            <ul class="collection with-header z-depth-1">
                <li class="collection-header blue darken-1 pseudo_collapsible">
                    <div class="white-text"><span class="headerLabel">Reminders</span> <span class="showAll_text">show all</span><a href="#!" class="secondary-content add_itemBtn" ><i class="material-icons white-text">add</i></a></div>
                </li>
                <li class="add_itemBlock collection-item hide add_itemBlock"></li>
                <div id="project_itemsBlock' . ($i + $j) . '" class="hide">';
    if (!empty($projectReminders)) {
        foreach ($projectReminders as $reminder) {
            echo '<li class="collection-item" id="' . $reminder['pitem_index'] . '">
            <div><i class="material-icons left blue-text text-darken-2">alarm</i>' . $reminder['pitem_text'] . '<a class="secondary-content remove_item"><i class="material-icons">check</i></a></div>
        </li>';
        }
    }
    echo '
    </div>
            </ul>
            </div>
            <div class="col s12">
            <ul class="collection with-header z-depth-1">
                <li class="collection-header yellow darken-3 pseudo_collapsible">
                    <div class="white-text"><span class="headerLabel">Issues</span> <span class="showAll_text">show all</span><a href="#!" class="secondary-content add_itemBtn"><i class="material-icons white-text">add</i></a></div>
                </li>
                <li class="add_itemBlock collection-item hide add_itemBlock" ></li>
                <div id="project_itemsBlock' . ($i + $j + 1) . '" class="hide">';
    if (!empty($projectWarnings)) {
        foreach ($projectWarnings as $warning) {
            echo '<li class="collection-item" id="' . $warning['pitem_index'] . '">
                        <div><i class="material-icons left yellow-text text-darken-3">warning</i>' . $warning['pitem_text'] . '<a href="#!" class="secondary-content remove_item"><i class="material-icons">check</i></a></div>
                    </li>';
        }
    }
    echo ' </div>
            </ul>
            </div>

            <div class="col s12">

            <ul class="collection with-header z-depth-1">
                <li class="collection-header pink darken-2 pseudo_collapsible">
                    <div class="white-text"><span class="headerLabel">KT Advice</span> <span class="showAll_text">show all</span><a href="#!" class="secondary-content add_itemBtn"><i class="material-icons white-text">add</i></a></div>
                </li>
                <li class="add_itemBlock collection-item hide add_itemBlock"></li>
                <div id="project_itemsBlock' . ($i + $j + 2) . '" class="hide">';
    if (!empty($projectKTAs)) {
        foreach ($projectKTAs as $KTadvice) {
            echo '<li class="collection-item" id="' . $KTadvice['pitem_index'] . '">
                        <div><i class="material-icons left pink-text text-darken-2">star</i>' . $KTadvice['pitem_text'] . '<a href="#!" class="secondary-content remove_item"><i class="material-icons">remove</i></a></div>
                    </li>';
        }
    }
    echo '  </div>
            </ul>
            </div>
            <div class="col s12">
            <ul class="collection with-header z-depth-1">
                <li class="collection-header green darken-1 pseudo_collapsible">
                    <div class="white-text"><span class="headerLabel">Other Stuff</span> <span class="showAll_text">show all</span><a href="#!" class="secondary-content add_itemBtn"><i class="material-icons white-text">add</i></a></div>
                </li>
                <li class="add_itemBlock collection-item hide add_itemBlock">
            </li>
            <div id="project_itemsBlock' . ($i + $j + 3) . '" class="hide">';
    if (!empty($projectOthers)) {
        foreach ($projectOthers as $otherStuff) {
            echo '<li class="collection-item" id="' . $otherStuff['pitem_index'] . '">
                        <div><i class="material-icons left green-text text-darken-1">forward</i>' . $otherStuff['pitem_text'] . '<a href="#!" class="secondary-content remove_item"><i class="material-icons">clear</i></a></div>
                    </li>';
        }
    }
    echo '
            </div>
            </ul>
            </div>

            </div>

            <div class="modal_options hide" id="modal-options' . $i . '">

                <div class="row">
                    <div class="col s4">
                        <div class="collection options_names">
                            <h6 href="#!" class="collection-item">Project Name:</h6>
                            <h6 href="#!" class="collection-item">Since:</h6>
                            <h6 href="#!" class="collection-item">Until:</h6>
                            <h6 href="#!" class="collection-item">Responsible 1:</h6>
                            <h6 href="#!" class="collection-item">Responsible 2:</h6>
                            <h6 href="#!" class="collection-item">Color & shade:</h6>
                        </div>
                    </div>
                    <div class="col s8">
                        <div class="collection options_values">
                            <a href="#!" class="collection-item modal-trigger" data-target="modal-optionEdit">' . $project['project_name'] . '</a>
                            <a href="#!" class="collection-item modal-trigger" data-target="modal-optionEdit">' . $project['pstart_date'] . '</a>
                            <a href="#!" class="collection-item modal-trigger" data-target="modal-optionEdit">' . $project['pend_date'] . '</a>
                            <a href="#!" class="collection-item modal-trigger" data-target="modal-optionEdit">' . $respo1['username'] . '</a>
                            <a href="#!" class="collection-item modal-trigger" data-target="modal-optionEdit">' . $respo2['username'] . '</a>
                            <a href="#!" class="collection-item modal-trigger" data-target="modal-optionEdit">' . $project['card_color'] . '</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>';

    if ($i == (count($projectIDS) - 1)) {
        echo '<script src="js/addItem.js"></script>';
    }

    // JavaScript HERE
    echo '<script>';

    if ($i == 0) {
        echo 'let projectIDs = [];
        let currentProject = null;
        let ghostProjectID = document.querySelector("#ghost_ProjectID");
        let projectsCount = document.querySelector("#ghost_projectsCount");
        let optionValue = document.querySelector("#ghost_optionValue");
        let optionName = document.querySelector("#ghost_optionName");
        let optionIndex = 0;
        let saveEditBtn = document.querySelector("#save-option-value");
        let closeEditBtn = document.querySelector("#close-OE-modal");
        let modalOptionTitle = document.querySelector("#option-name");
        ';
    }

    echo 'projectIDs.push(' . $projectIDS[$i] . ');
        document.querySelector("#project_card' . $i . '").addEventListener("click", function(){currentProject = this.id.slice(-1);
            ghostProjectID.value = projectIDs[currentProject];});

        ';

    if ($i == (count($projectIDS) - 1)) {
        echo '
        // Options button
        let optionsButtons = document.querySelectorAll(".project_options");
        // modals collections
        let modalCollections = document.querySelectorAll(".modal_collections");
        // modals options menu
        let modalOptionsMenu = document.querySelectorAll(".modal_options");
        // modals options names
        let modalOptionsNames = document.querySelectorAll(".options_names");
        // modals options menu values
        let modalOptionsValues = document.querySelectorAll(".options_values");
        // collection headers
        let headerCollapsibles = document.querySelectorAll(".pseudo_collapsible");
        // show all items text
        let showAllText = document.querySelectorAll(".showAll_text");
        // add item button
        let addItemBtn = document.querySelectorAll(".add_itemBtn");
        // textbox holder li
        let addItemBlock = document.querySelectorAll(".add_itemBlock");
        // the buttons that remove the items
        let removeItemBtn = document.querySelectorAll(".remove_item");
        // the add item textbox (not existent yet)
        let addItemForm = null;
        let hideItemBtn = null;
        // number of items blocks to be refreshed
        projectsCount.value = ' . count($projectIDS) . ';
        // input for item type
        let ghostItemType = document.querySelector("#ghost_itemType");

        // function to show the options menu
        let showOptionsMenu = (x) => {
            for(let i = 0; i < optionsButtons.length; i++){
                if (i == x){
                    modalCollections[i].classList.toggle("hide");
                    modalOptionsMenu[i].classList.toggle("hide");
                    if (optionsButtons[i].textContent == "Options"){
                        optionsButtons[i].textContent = "Back";
                    } else {
                        optionsButtons[i].textContent = "Options";
                    }
                }
            }
        }

        // function to set the correct info on the Edit modal
        let setModalOptionData = (x, y) => {
            document.querySelector("#text-option-value").classList.add("hide");
            document.querySelector("#text-option-value").value = "";
            document.querySelector("#date-option-value").classList.add("hide");
            document.querySelector("#respo1-option-holder").classList.add("hide");
            document.querySelector("#respo2-option-holder").classList.add("hide");
            document.querySelector("#color-option-holder").classList.add("hide");
            for(let i = 0; i < modalOptionsValues.length; i++) {
                for(let j = 1; j < 12; j+=2){
                    if (j==x && i==y){
                        modalOptionTitle.innerHTML = modalOptionsNames[i].childNodes[j].innerHTML;
                        if(j == 1){
                            document.querySelector("#text-option-value").classList.remove("hide");
                            document.querySelector("#text-option-value").value = modalOptionsValues[i].childNodes[j].innerHTML;
                        }
                        else if (j == 3){
                            document.querySelector("#date-option-value").classList.remove("hide");
                            document.querySelector("#date-option-value").value = modalOptionsValues[i].childNodes[j].innerHTML;
                        }
                        else if (j == 5){
                            document.querySelector("#date-option-value").classList.remove("hide");
                            document.querySelector("#date-option-value").value = modalOptionsValues[i].childNodes[j].innerHTML;
                         }
                        else if (j == 7){
                            document.querySelector("#respo1-option-holder").classList.remove("hide");
                        }
                        else if (j == 9){
                            document.querySelector("#respo2-option-holder").classList.remove("hide");
                        }
                        else if (j == 11){
                            document.querySelector("#color-option-holder").classList.remove("hide");
                        }
                        optionIndex = j;
                    }
                }
            }
        }

        // function to finish editing the option
        editOptionData = () => {
            if(optionIndex == 1){
                optionName.value = "name";
                optionValue.value = document.querySelector("#text-option-value").value;
            }
            else if (optionIndex == 3){
                 optionName.value = "since";
                optionValue.value = document.querySelector("#date-option-value").value;
            }
            else if (optionIndex == 5){
                optionName.value = "until";
                optionValue.value = document.querySelector("#date-option-value").value;
            }
            else if (optionIndex == 7){
                optionName.value = "respo1";
                optionValue.value = document.querySelector("#respo1-option-value").value;
            }
            else if (optionIndex == 9){
                optionName.value = "respo2";
                optionValue.value = document.querySelector("#respo2-option-value").value;
            }
            else if (optionIndex == 11){
                optionName.value = "color";
                optionValue.value = document.querySelector("#color-option-value").value;
            }
            editOption();
        }

        // function to activate the collapsible in collections
        let showItems = (x, fromListener) => {
            for(let i = 0; i < headerCollapsibles.length; i++){
                itemsBlock = headerCollapsibles[i].parentElement.childNodes[5];
                if (i == x){
                    if (fromListener){
                        itemsBlock.classList.toggle("hide");
                    } else {
                        itemsBlock.classList.remove("hide");
                    }
                    if(itemsBlock.classList.contains("hide")){
                        showAllText[i].innerHTML = "show all";
                    } else{
                        showAllText[i].innerHTML = "hide all";
                    }

                } else {
                    itemsBlock.classList.add("hide");
                    showAllText[i].innerHTML = "show all";
                }
            }
        }

        // function to display the Show All Text
        let displayShowAllText = (x) => {
            for(let i = 0; i < headerCollapsibles.length; i++){
                if (i == x){
                    showAllText[i].style.opacity = "0.6";
                }
            }
        }

        // function to hide the Show All Text
        let hideShowAllText = (x) => {
            for(let i = 0; i < headerCollapsibles.length; i++){
                if (i == x){
                    showAllText[i].style.opacity = "0";
                }
            }
        }

        // function to remove the textbox and its content
        let hideTextbox = (x) => {
            addItemBlock[x].innerHTML = "";
            addItemBlock[x].classList.add("hide");
            addItemBtn[x].classList.remove("hide");
        }

        // function to make the text box existent
        let showTextbox = (x) => {
            for(let i = 0; i < addItemBlock.length; i++) {
                if(i == x){
                    addItemBlock[x].innerHTML += \'' . $addItem_block . '\';
                    addItemBlock[x].classList.remove("hide");
                    addItemForm = document.querySelector("#addItem-form");
                    addItemInput = document.querySelector("#add_projectItem");
                    addItemInput.focus();
                    hideItemBtn = document.querySelector("#hide_textbox");
                    addItemForm.addEventListener("submit", addItem);
                    hideItemBtn.addEventListener("click", function(){hideTextbox(i)});
                    addItemBtn[x].classList.add("hide");
                    showItems(i, false);

                    if((i % 4) == 0){
                        ghostItemType.value = "reminder";
                    }
                    if((i % 4) == 1){
                        ghostItemType.value = "warning";
                    }
                    if((i % 4) == 2){
                        ghostItemType.value = "advice";
                    }
                    if((i % 4) == 3){
                        ghostItemType.value = "other";
                    }
                } else {
                    addItemBlock[i].innerHTML = "";
                    addItemBlock[i].classList.add("hide");
                    addItemBtn[i].classList.remove("hide");
                }
            }
        }

        // event listener to show the options menu in modal
        for(let i = 0; i < optionsButtons.length; i++) {
            optionsButtons[i].addEventListener("click", function(){showOptionsMenu(i)});
        }

        // event listener to show the option data edit modal
        for(let i = 0; i < modalOptionsValues.length; i++) {
            for(let j = 1; j < 12; j+=2){
                modalOptionsValues[i].childNodes[j].addEventListener("click", function(){setModalOptionData(j, i)});
            }
        }

        // event listener to save the option edit value to the db
        saveEditBtn.addEventListener("click", function(){
            editOptionData();
        });

        // event listener to show the items on click
        for(let i = 0; i < headerCollapsibles.length; i++) {
            showAllText[i].addEventListener("click", function(){showItems(i, true)});
        }

        // event listener to show the show All text on hover
        for(let i = 0; i < headerCollapsibles.length; i++) {
            showAllText[i].addEventListener("mouseover", function(){displayShowAllText(i)});
        }

        // event listener to hide the show All text on hover
        for(let i = 0; i < headerCollapsibles.length; i++) {
            showAllText[i].addEventListener("mouseout", function(){hideShowAllText(i)});
        }

        // event listener to show the textbox onclick
        for(let i = 0; i < addItemBlock.length; i++) {
            addItemBtn[i].addEventListener("click", function(){showTextbox(i)});
        }

        // // event listener to remove the item onclick
        for(let i = 0; i < removeItemBtn.length; i++) {
            removeItemBtn[i].addEventListener("click", function(){
                removeItem(removeItemBtn[i].parentElement.parentElement.id)
            });
         }';
    }

    echo '</script>';
    $j += 3;
}
