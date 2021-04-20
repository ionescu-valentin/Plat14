<?php
$projectIDS = array();
$projectReminders = array();
$projectWarnings = array();
$projectKTAs = array();
$projectOthers = array();
$emptyArr = true;
?>

<div class="" id="general-view">
    <div class="row">
        <div class="col s4">
            <!-- aici punem cardurile cu projects -->
            <h5 class="blue-text">Projects we're working on:</h5>
            <a href="#" class="btn-flat waves-effect waves-teal" id="show_addProject" onclick="showAP()">
                <i class="material-icons left">add</i>add
            </a> </br></br>
            <?php include 'addProject.comp.php'; ?>

            <!-- project cards -->
            <?php include 'projectCard.comp.php'; ?>
        </div>
    </div>
</div>
<!--project modal -->
<?php include 'projectModal.comp.php'; ?>