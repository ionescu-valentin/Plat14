</br>
<form action="#" class="has_icons" method="post" id="createTeam-form">
    <div id="createTeam_part1">
        <div class="row">
            <div class="input-field col s12">
                <i class="material-icons prefix">star</i>
                <input type="text" class="validate" name="team_name" id="team_name">
                <label for="team_name">Team name</label>
            </div>
            <div class="input-field col s12">
                <i class="material-icons prefix">star</i>
                <input type="text" class="validate" name="team_nick" id="team_nick">
                <label for="team_nick">Team nickname</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <i class="material-icons prefix">menu</i>
                <select id="team_type">
                    <option value="" disabled selected>You are not my type, sorry</option>
                    <option value="board">Board</option>
                    <option value="management">Management</option>
                    <option value="coreteam">Event Core Team</option>
                    <option value="project-team">Project Team</option>
                    <option value="department">Department</option>
                    <option value="other">Other..</option>
                </select>
                <label>Team type</label>
            </div>
        </div>
        <div class="row">
            <div class=" col s6 push-s4">
                <button class="blue darken-2 btn waves-effect waves-light" type="button" id="goTo_part2" onclick="switchTo2()"><span>Next</span>
                    <i class="material-icons right">chevron_right</i>
                </button>
            </div>
        </div>
    </div>
    <div id="createTeam_part2" class="hide">
        <div class="row">
            <div class="input-field col s12">
                <i class="material-icons prefix">menu</i>
                <input type="text" name="start_date" class="datepicker" placeholder="Click me to pick a date!" id="start_date">
                <label for="start_date">Mandate starts on...</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <i class="material-icons prefix">menu</i>
                <input type="text" name="end_date" class="datepicker" placeholder="Click me to pick another date!" id="end_date">
                <label for="start_date">Mandate ends on...</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <i class="material-icons prefix">star</i>
                <input type="text" class="validate" name="team_motto" id="team_motto">
                <label for="team_motto">Team motto</label>
            </div>
        </div>
        <div class="row">
            <div class=" col s12">
                <div class="row">
                    <div class=" col s6">
                        <button class="blue darken-2 btn waves-effect waves-light" type="button" id="goTo_part1" onclick="switchTo1()"><span>Back</span>
                            <i class="material-icons left">chevron_left</i>
                        </button>
                    </div>
                    <div class=" col s5 push-s1">
                        <button class="blue darken-2 btn waves-effect waves-light" type="submit" name="submit" id="send_createTeam">Finish
                            <i class="material-icons left">done</i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<p id="createTeam-data"></p>

<script>
    // get the start date & the end date in miliseconds
    let endTime = Date.parse(document.getElementById("end_date").value);
    let startTime = Date.parse(document.getElementById("start_date").value);

    // get the difference btw the 2 dates in days
    let periodInDays = ((((endTime - startTime) / 1000) / 60) / 60) / 24;
</script>