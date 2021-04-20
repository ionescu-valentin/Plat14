<!-- form to add a new project in the team view -->
<p id="addProject-data"></p>
<form action="#" class="hide" method="post" id="addProject-form">
    <!-- the team index from the database in a hidden form -->
    <input type="text" class="hide" name="team_id" id="team_id" value="<?php printf($_SESSION['teamID']); ?>">
    <div class="row">
        <div class=" col s12">
            <div class="row">
                <div class="input-field col s6">
                    <input type="text" class="validate" name="project_name" id="project_name">
                    <label for="project_name">Project Name</label>
                </div>
                <div class="input-field col s6">
                    <select id="card_color" class="selectList">
                        <option value="" id="emptyColor" disabled selected>Not me, pls</option>
                        <option value="red lighten-3">Red</option>
                        <option value="light-blue">Blue</option>
                        <option value="green lighten-2">Green</option>
                    </select>
                    <label>Card color</label>
                </div>
            </div>
        </div>
        <!-- the dates between start and end of the project -->
        <div class=" col s12">
            <div class="row">
                <div class="input-field col s6">
                    <input type="text" name="project_start" class="datepicker" placeholder="Click me to pick a date!" id="project_start">
                    <label for="project_start">Project starts on...</label>
                </div>
                <div class="input-field col s6">
                    <input type="text" name="project_end" class="datepicker" placeholder="Pick another date here!" id="project_end">
                    <label for="project_end">Project ends on...</label>
                </div>
            </div>
        </div>
        <div class=" col s12">
            <div class="row">
                <!-- the responsibles (from users table) -->
                <div class="input-field col s6">
                    <select id="responsible_1" class="selectList">
                        <option value="" disabled selected>Not me, pls</option>
                        <?php
                        for ($i = 0; $i < count($team_members); ++$i) {
                            printf('<option value="' . $team_members[$i]['user_index'] . '">' . $team_members[$i]['username'] . '</option>');
                        }
                        ?>
                    </select>
                    <label>Responsible 1</label>
                </div>
                <div class="input-field col s6">
                    <select id="responsible_2" class="selectList">
                        <option value="" disabled selected>Mee! PICK ME!</option>
                        <?php
                        for ($i = 0; $i < count($team_members); ++$i) {
                            printf('<option value="' . $team_members[$i]['user_index'] . '">' . $team_members[$i]['username'] . '</option>');
                        }
                        ?>
                    </select>
                    <label>Responsible 2</label>
                </div>
            </div>
        </div>
        <!-- submit button -->
        <div class=" col s12">
            <div class="row">
                <div class=" col s6 push-s2">
                    <button class="regButton blue darken-3 btn waves-effect waves-light" type="submit" name="submit" id="send_addProject">add
                    </button>
                </div>
                <div class=" col s6">
                    <button class="regButton red darken-3 btn waves-effect waves-light" type="button" name="cancel" id="hide_addProject" onclick="hideAP()">cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>