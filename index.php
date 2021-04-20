<?php
session_start();

include 'components/header.php';
?>

<!-- login modal -->
<div class="modal" id="login-modal" style="width: 30rem; max-height: 40rem ">
  <div class="modal-content blue-text text-darken-2">
    <h4 class="modal-header center">Log in</h4>
    <br>
    <div class=""><?php include 'forms/login.form.php' ?></div>
  </div>
</div>

<!-- signup modal -->
<div class="modal" id="signup-modal" style="width: 38rem; max-height: 40rem ">
  <div class="modal-content blue-text text-darken-2">
    <h4 class="modal-header center">Sign up</h4>
    <div class=""><?php include 'forms/signup.form.php' ?></div>
  </div>
</div>

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

<!-- index body -->
<br>
<div class="container">

  <!-- Notifications Stuff -->
  <div class="notificari hide">
    <h4 class="green-text text-darken-4">Notificationssss</h4>
    <div id="notifications" class="row ">


      <div class="col s12 m6 hide " id="warning">
        <div class="card blue-grey darken-3">
          <div class="card-content white-text">
            <span class="card-title">Warinng</span>
            <p>Spala-te la coaie !!!</p>
          </div>
          <div class="card-action">
            <a id="remnot" class="btn red" onclick="remNotif(this.id)">Dismiss</a>
          </div>
        </div>
      </div>
    </div>

    <!-- notification message form -->
    <div class="row">
      <form onsubmit="event.preventDefault()" action="" class="col s12">
        <div class="row">
          <div class="input-field col s6 m4">
            <input id="message" type="text" class="validate">
            <label for="message">Notification message</label>
          </div>
          <div class="col s12">
            <button type="submit" class="blue btn" onclick=a()>Click pt notif</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <!-- login/logout buttons -->
  <?php
  if (!isset($_SESSION['username'])) {
    echo '<a id="" data-target="login-modal" class="modal-trigger blue btn">Log in</a>';
  }
  ?>
  <?php
  if (isset($_SESSION['username'])) {
    echo '<a href="includes/logout.inc.php" class="blue btn">Log out</a>';
  }
  ?>

</div>


</body>


<!-- index.js -->
<script src="js/index.js"></script>

</html>