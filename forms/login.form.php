<?php
printf('
<form action="#" class="center has_icons" method="post" id="login-form">
    <div class="row">
        <div class="input-field col s10 push-s1">
            <i class="material-icons prefix">person</i>
            <input type="text" class="validate" placeholder="Username" name="username" id="username">
        </div>
    </div>
    <div class="row">
        <div class="input-field col s10 push-s1">
            <i class="material-icons prefix">lock</i>
            <input type="password" class="validate" placeholder="Password" name="parola" id="parola">
        </div>
    </div>
    <p id="login-data"></p>
    <div class="row">
        <div class="col s4">
            <button class="blue darken-2 btn waves-effect waves-light " type="submit" name="submit" id="send_login">Sign in</button>
        </div>
        <div class="col s2">
            <h6 class="blue-text">or</h6>
        </div>
        <div class="col s6 ">
            <a data-target="signup-modal" class="modal-trigger blue lighten-4 btn blue-text text-darken-2">Create Account</a>
        </div>
    </div>
</form>');
