<?php
session_start();

include 'components/header.php';
?>

<!-- JoinTeam modal -->
<div class="modal" id="joinTeam-modal" style="width: 25rem; max-height: 40rem ">
    <div class="modal-content blue-text text-darken-2">
        <h5 class="modal-header center">Join a team by code</h5><br>
        <div class=""><?php include 'forms/joinTeam.form.php' ?></div>
    </div>
</div>

<!-- CreateTeam modal -->
<div class="modal" id="createTeam-modal" style="width: 25rem; max-height: 45rem ">
    <div class="modal-content blue-text text-darken-2">
        <h5 class="modal-header center">Start a team!</h5>
        <div class=""><?php include 'forms/createTeam.form.php' ?></div>
    </div>
</div>

<!-- profile body -->
<br>
<div class="container">
    <div class="row">
        <div class="col s8">
            <h5 class="blue-text text-darken-2">
                <?php
                printf($_SESSION['username'] . '\'s awesome profile');
                ?>
            </h5>
        </div>
        <div class="col s8">
            <?php echo '<img class="profile-pic" src="images/profile_icons/' . $_SESSION['avatar'] . '.png" alt="poza cu tine, bro">'; ?>
        </div>
        <div class="col s8">
            <h4 class="amber-text text-darken-2">Achievements:</h4>
            <ul class="icons_list">
                <li>
                    <a href="#" class="blue-text text-darken-3">
                        <i class="material-icons">extension</i>
                        Coreteamer
                    </a>
                </li>
                <li>
                    <a href="#" class="light-green-text">
                        <i class="material-icons">airline_seat_individual_suite
                        </i>
                        WeeklyMeetings-goer
                    </a>
                </li>
            </ul>
        </div>
        <div class="col s8">
            <h5 class="blue-text text-darken-2">
                Are echipă?
            </h5>
            <?php
            if (!isset($_SESSION['teamName'])) {
                printf('<h6>N-are echipă</h6>');
            } else {
                echo '<h6>Are echipă</h6>';
            }
            ?>

        </div>
    </div>

</div>



</body>


<!-- index.js -->
<script src="js/index.js"></script>

</html>