<?php
if (isset($_SESSION['username'])) {
    printf('<form action="#" class="has_icons" method="post" id="joinTeam-form">
        <div class="row">
            <div class="input-field col s10 push-s1">
                <i class="material-icons prefix">star</i>
                <input type="text" class="validate" name="teamName" id="teamName">
                <label for="teamName">Team name</label>
            </div>
        </div>
        <div class="row">
                <div class="input-field col s10 push-s1">
                    <i class="material-icons prefix">star</i>
                    <input type="text" class="validate" name="teamCode" id="teamCode">
                    <label for="teamCode">Team code</label>
                </div>
            </div>
            <div class="row">
                <div class="col s4">
                    <button class="blue darken-2 btn waves-effect waves-light " type="submit" name="submit" id="send_joinTeam">Join</button>
                </div>
                <div class="col s2">
                    <h6 class="blue-text">or</h6>
                </div>
                <div class="col s6">
                    <a data-target="createTeam-modal" class="modal-trigger blue lighten-4 btn blue-text text-darken-2">Create a Team</a>
                </div>
            </div>
        </form>
        <p id="joinTeam-data"></p>');
} else {
    printf('<br>
    <div class="row">
        <h5 class="red-text text-darken-2 center">No account detected!</h5>
        <p class="blue-text center">In order to be part of a Team, you need to have a Site-smecher account.</p>
    </div>
    <div class="row">
        <div class="col s6 push-s4">
            <a id="" data-target="login-modal" class="modal-trigger blue btn center">Log in</a>
        </div>
    </div>');
}
