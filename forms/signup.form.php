<?php
printf('
    <form action="#" class="has_icons" method="post" id="signup-form">
        <div class="row">
            <div class="input-field col s12 m6 push-m3">
                <i class="material-icons prefix">account_circle</i>
                <input type="text" class="validate" name="username" id="user_name">
                <label for="user_name">Username</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m6">
                <i class="material-icons prefix">person</i>
                <input type="text" class="validate" name="full_name" id="full_name">
                <label for="full_name">Full Name</label>
            </div>
            <div class="input-field col s12 m6">
                <i class="material-icons prefix">email</i>
                <input type="email" class="validate" name="email" id="email">
                <label for="email">Email</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m6">
                <i class="material-icons prefix">lock</i>
                <input type="password" class="validate" name="parola" id="password">
                <label for="password">Password</label>
            </div>
            <div class="input-field col s12 m6">
                <i class="material-icons prefix">lock_outline</i>
                <input type="password" class="validate" name="parola2" id="password2">
                <label for="password2">Confirm Password</label>
            </div>
        </div>

        <div class="row">
            <div class="s6 center">
                <button class="blue btn waves-effect waves-light" type="submit" name="submit" id="send_signup">Create account!
                    <i class="material-icons right">send</i>
                </button>
            </div>
        </div>
    </form>

    <div id="avatars_container" class="hide">
        <div class="row">
        <div class="col s2"><img src="images/profile_icons/bodybuilder.png" alt=""></div>
        <div class="col s2"><img src="images/profile_icons/business.png" alt=""></div>
        <div class="col s2"><img src="images/profile_icons/dealer.png" alt=""></div>
        <div class="col s2"><img src="images/profile_icons/dentist.png" alt=""></div>
        <div class="col s2"><img src="images/profile_icons/detective.png" alt=""></div>
        <div class="col s2"><img src="images/profile_icons/driver.png" alt=""></div>
        </div>
        <div class="row">
        <div class="col s2"><img src="images/profile_icons/engineer.png" alt=""></div>
        <div class="col s2"><img src="images/profile_icons/firefighter.png" alt=""></div>
        <div class="col s2"><img src="images/profile_icons/guard.png" alt=""></div>
        <div class="col s2"><img src="images/profile_icons/man.png" alt=""></div>
        <div class="col s2"><img src="images/profile_icons/man2.png" alt=""></div>
        <div class="col s2"><img src="images/profile_icons/monk.png" alt=""></div>
        </div>
        <div class="row">
        <div class="col s2"><img src="images/profile_icons/nurse.png" alt=""></div>
        <div class="col s2"><img src="images/profile_icons/sailor.png" alt=""></div>
        <div class="col s2"><img src="images/profile_icons/student.png" alt=""></div>
        <div class="col s2"><img src="images/profile_icons/surgeon.png" alt=""></div>
        <div class="col s2"><img src="images/profile_icons/swat.png" alt=""></div>
        <div class="col s2"><img src="images/profile_icons/voice.png" alt=""></div>
        </div>
        <div class="row">
        <div class="col s2"><img src="images/profile_icons/wander.png" alt=""></div>
        <div class="col s2"><img src="images/profile_icons/woman.png" alt=""></div>
        <div class="col s2"><img src="images/profile_icons/woman2.png" alt=""></div>
        <div class="col s2"><img src="images/profile_icons/woman3.png" alt=""></div>
        <div class="col s2"><img src="images/profile_icons/woman4.png" alt=""></div>
        <div class="col s2"><img src="images/profile_icons/woman5.png" alt=""></div>
        </div>
        <div class="row">
        <div class="col s2"><img src="images/profile_icons/woman6.png" alt=""></div>
        <div class="col s2"><img src="images/profile_icons/woman7.png" alt=""></div>
        <!-- <div class="col s2"><img src="images/profile_icons/woman2.png" alt=""></div>
        <div class="col s2"><img src="images/profile_icons/woman3.png" alt=""></div>
        <div class="col s2"><img src="images/profile_icons/woman4.png" alt=""></div>
        <div class="col s2"><img src="images/profile_icons/woman5.png" alt=""></div> -->
        </div>
  </div>

<div id="after_signup" class="hide">
    </br>
    <input type="text" class="hide" id="ghost_avatarName">
    <input type="text" class="hide" id="ghost_submit">
    <div class="center" id="success_message">
        <h5 class="green-text">The account has been created successfully!</h5>
        <h6 class="">You can personalize your account by choosing a profile avatar!</h6>
        </br>
    </div>
    <div class="row">
        <div class="col s6 push-s1">
            <a class="btn waves-effect blue darken-2" id="choose_avatar" onclick="personalize()">Personalize</a>
        </div>
        <div class="col s6 pull-s1">
        <a class="modal-close btn waves-effect blue darken-2" id="finish-signup" onclick="fillLogin()">Later</a>
        </div>
    </div>
</div>

    <p class="center" id="signup-data"></p>

<script>
    let avatarPics = document.querySelectorAll("#avatars_container img");
    let avatarName = document.querySelector("#ghost_avatarName");
    let avatarSelected = document.querySelector("#ghost_submit");
    let wantsAvatar = false;

    let personalize = () =>{
        document.getElementById("avatars_container").classList.remove("hide");
        document.getElementById("success_message").classList.add("hide");
        document.getElementById("finish-signup").innerHTML = "Done";
        wantsAvatar = true;
        document.getElementById("signup-modal").style.width = "45rem";
        document.getElementById("choose_avatar").parentElement.remove();
        document.getElementById("finish-signup").parentElement.classList.remove("pull-s1");
        document.getElementById("finish-signup").parentElement.classList.add("push-s3");
    }

    let selectAvatar = (x) =>{
        for(let i = 0; i < avatarPics.length; i++){
            if(i == x){
                avatarPics[i].parentElement.classList.add("orange", "lighten-2");
                imageCode = avatarPics[i].parentElement.innerHTML;
                endPoint = imageCode.indexOf(".php");
                avatarName.value = "";
                avatarName.value = imageCode.slice(31, endPoint);
            } else {
                avatarPics[i].parentElement.classList.remove("orange", "lighten-2");
            }
        }
    }

    let fillLogin = () =>{
        if(!wantsAvatar){
            document.querySelector("#send_login").click();
        } else {
            avatarSelected.value = "submitted";
            addAvatar();
        }
    }

    for(let i = 0; i < avatarPics.length; i++){
        avatarPics[i].parentElement.addEventListener("click", function(){selectAvatar(i);});
    }
</script>

    ');
