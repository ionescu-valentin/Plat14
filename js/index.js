// importing JQuery
var jqueryScript = document.createElement('script');
jqueryScript.src = 'https://code.jquery.com/jquery-3.4.1.min.js';
jqueryScript.type = 'text/javascript';
document.getElementsByTagName('head')[0].appendChild(jqueryScript);

// Variables HERE

// initializing materialize items with jquery
$(document).ready(function () {
  if ($('.tabs').length) {
    $('.tabs').tabs({swipeable: true});
  }

  $('.modal').modal();

  $('.sidenav').sidenav();

  $('select').formSelect();

  $('.datepicker').datepicker({ container: 'body'});

  $('.tooltipped').tooltip();

  $('.collapsible').collapsible();
});

  // elements
  var message = document.getElementById("message");
  var panel = document.getElementById("notifications");
  var warning = document.getElementById("warning");

  // cards list
  var notification = [];

  // cards ids
  var i = 0;

  // buttons ids
  var j = 100;

  // ###Functions###

  // Funtion to create notifications with message
  function a() {
    // check if there is any message
    if (message.value == "") {
      // copy the original notification template
    notification[i] = warning.cloneNode(true);
    // make the copy visible
    notification[i].classList.remove("hide");
    // change the copy's id
    notification[i].id = i;

    // get the notification message and the dismiss button
    let card = notification[i].children;
    let contents = card[0].children;
    let notifMessage = contents[0].children;
    let paragraph = notifMessage[1];
    let action = contents[1].children;
    let dismiss = action[0];

    // change the button's id
    dismiss.id = j;
    j++;
    // change the notification's message
    paragraph.innerHTML = "Default Notification: Spală-te la coaie!";
    // make the notification appear
    panel.appendChild(notification[i]);
    i++;
    }
    // Same thing but with custom message
    else {
    notification[i] = warning.cloneNode(true);
    notification[i].classList.remove("hide");
    notification[i].id = i;

    let card = notification[i].children;
    let contents = card[0].children;
    let notifMessage = contents[0].children;
    let paragraph = notifMessage[1];
    let action = contents[1].children;
    let dismiss = action[0];
    dismiss.id = j;
    j++;
    paragraph.innerHTML = message.value;
    message.value = "";
    panel.appendChild(notification[i]);
    i++;
    }

}

// Function to destroy the notification
let remNotif = (x) =>{
  // get the button's id
    var asta = document.getElementById(x);
    // remove the card that contains that button
   asta.parentElement.parentElement.parentElement.remove();
}

var prevPart = document.querySelector('#createTeam_part1');
var nextPart = document.querySelector('#createTeam_part2');

let switchTo2 = () => {
  prevPart.classList.add('hide');
  nextPart.classList.remove('hide');
}

let switchTo1 = () => {
  prevPart.classList.remove('hide');
  nextPart.classList.add('hide');
}

var showAddProject = document.querySelector('#show_addProject');
var hideAddProject = document.querySelector('#hide_addProject');
var addProject = document.querySelector('#addProject-form');
var addProjectInputs = document.querySelectorAll("form#addProject-form input");

let showAP = () => {
  showAddProject.classList.add('hide');
  addProject.classList.remove('hide');
}

let hideAP = () => {
  showAddProject.classList.remove('hide');
  addProject.classList.add('hide');
  addProjectInputs.forEach(input => {
    input.value = "";
    input.classList.remove('valid');
  });
}

// AJAX toys
$(document).ready(function () {
  // sending signup info to the php file
  $("#signup-form").submit(function (event) {
    event.preventDefault();
    var fullName = $("#full_name").val();
    var email = $("#email").val();
    var username = $("#user_name").val();
    var password = $("#password").val();
    var password2 = $("#password2").val();
    var submit = $("#send_signup").val();
    $("#signup-data").load("includes/signup.inc.php", {
      full_name: fullName,
        email: email,
        username: username,
        parola: password,
        parola2: password2,
        submit: submit
    });
  });

  // send login info into to the php file
  $("#login-form").submit(function (event) {
    event.preventDefault();
    var username = $("#username").val();
    var password = $("#parola").val();
    var submit = $("#send_login").val();
    $("#login-data").load("includes/login.inc.php", {
        username: username,
        parola: password,
        submit: submit
    });
  });

  // sending signup info to the php file
  $("#createTeam-form").submit(function (event) {
    event.preventDefault();
    var teamName = $("#team_name").val();
    var teamNick = $("#team_nick").val();
    var teamType = $("#team_type").val();
    var startDate = $("#start_date").val();
    var endDate = $("#end_date").val();
    var teamMotto = $("#team_motto").val();
    var submit = $("#send_createTeam").val();
    $("#createTeam-data").load("includes/createTeam.inc.php", {
      teamName: teamName,
      teamNick: teamNick,
      teamType: teamType,
      startDate: startDate,
      endDate: endDate,
      teamMotto: teamMotto,
      submit: submit
    });
  });

  // send joinTeam into to the php file
  $("#joinTeam-form").submit(function (event) {
    event.preventDefault();
    var teamName = $("#teamName").val();
    var teamCode = $("#teamCode").val();
    var submit = $("#send_joinTeam").val();
    $("#joinTeam-data").load("includes/joinTeam.inc.php", {
      teamName: teamName,
      teamCode: teamCode,
        submit: submit
    });
  });

    // sending add project info to the addProject.php file
    $("#addProject-form").submit(function (event) {
      event.preventDefault();
      var projectName = $("#project_name").val();
      var cardColor = $("#card_color").val();
      var startDate = $("#project_start").val();
      var endDate = $("#project_end").val();
      var responsible1 = $("#responsible_1").val();
      var responsible2 = $("#responsible_2").val();
      var teamID = $("#team_id").val();
      var submit = $("#send_addProject").val();
      $("#addProject-data").load("includes/addProject.inc.php", {
        projectName: projectName,
        cardColor: cardColor,
        startDate: startDate,
        endDate: endDate,
        responsible1: responsible1,
        responsible2: responsible2,
        teamID: teamID,
        submit: submit
      });
    });


});


