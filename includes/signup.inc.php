<?php
require "dbconn.inc.php";

if (isset($_POST["submit"])) {

    #variabile pt datele din form
    $username = $_POST["username"];
    $name = $_POST["full_name"];
    $email = $_POST["email"];
    $password = $_POST["parola"];
    $passwordRe = $_POST["parola2"];
    $avatar = "noAvatar";

    #checking for taken username/email
    $takenUsername = false;
    $takenEmail = false;

    #USERNAME DATABASE SEARCH
    $sqlUser = "SELECT username FROM users WHERE username=?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sqlUser)) {
        echo "We are sorry! A database error has occured. Please try again later!";
    } else {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $userResultCheck = mysqli_stmt_num_rows($stmt);

        if ($userResultCheck > 0) {
            $takenUsername = true;
        }
    }


    #EMAIL ADDRESS DATABASE SEARCH
    $sqlEmail = "SELECT email FROM users WHERE email=?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sqlEmail)) {
        echo "We are sorry! A database error has occured. Please try again later!";
    } else {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $emailResultCheck = mysqli_stmt_num_rows($stmt);

        if ($emailResultCheck > 0) {
            $takenEmail = true;
        }
    }

    mysqli_stmt_close($stmt);


    #checking for empty fields
    if (empty($name) || empty($username) || empty($email) || empty($password) || empty($passwordRe)) {
        echo '<span class="red-text">All fields need to be filled in!</span>';
    }
    #checking for invalid e-mail
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<span class="red-text">The e-mail address is not valid!</span>';

        #checking for invalid username
    } else if (!preg_match("/^[a-zA-Z0-9._]*$/", $username)) {
        echo '<span class="red-text">The username must contain only letters, numbers, "_", "." and be at least 5 characters long!</span>';

        #checking for unmatching passwords
    } else if ($password !== $passwordRe) {
        echo '<span class="red-text">The passwords do not match!</span>
        <script>document.getElementById("password").classList.add("invalid");
            document.getElementById("password2").classList.add("invalid");
            </script>';

        #checking for taken username or email
    } else if ($takenUsername || $takenEmail) {

        if ($takenUsername && $takenEmail) {
            echo '<span class="red-text">The e-mail address and username are already in use!</span>
            <script>document.getElementById("user_name").classList.add("invalid");
            document.getElementById("email").classList.add("invalid");
            </script>';
        } else if ($takenEmail) {
            echo '<span class="red-text">There is already an account which uses this e-mail address!</span>
            <script>document.getElementById("user_name").classList.add("valid");
            document.getElementById("email").classList.add("invalid");
            </script>';
        } else if ($takenUsername) {
            echo '<span class="red-text">The username is already taken!</span>
            <script>document.getElementById("user_name").classList.add("invalid");
            document.getElementById("email").classList.add("valid");
            </script>';
        }
    }

    #preparing the database for insertion
    else {
        $sql = "INSERT INTO users (full_name, username, email, parola, avatar) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        #making sure the info is correct
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "We are sorry! A database error has occured. Please try again later!";

            #encrypting the password
        } else {
            $hashedPass = password_hash($password, PASSWORD_DEFAULT);
            #inserting the data into the database
            mysqli_stmt_bind_param($stmt, "sssss", $name, $username, $email,  $hashedPass, $avatar);
            mysqli_stmt_execute($stmt);
            #removing the signup-form (the signup data must be outside the form)
            #filling the login info
            printf('
            <script src="js/addItem.js"></script>
            <script>
                freshUsername = document.querySelector("#user_name").value;
                freshPassword = document.querySelector("#password").value;
                document.querySelector("#username").value = freshUsername;
                document.querySelector("#parola").value = freshPassword;
                document.getElementById("signup-form").remove();
                document.getElementById("after_signup").classList.remove("hide");
            </script>');
            exit();
        }
        mysqli_stmt_close($stmt);
    }

    #adding the avatar pic name to the database
} else if (isset($_POST["avatarSet"])) {
    if ($_POST["avatarSet"] == "submitted") {
        $username = $_POST["username"];
        $avatarName = $_POST["avatarName"];

        if (empty($avatarName)) {
            echo "Select you fav and we're good to go!";
        } else {
            $sql = "UPDATE users SET avatar = '" . $avatarName . "' WHERE username = ?";
            $stmt = mysqli_prepare($conn, $sql);

            if (!$stmt) {
                echo "We are sorry! A database error has occured. Please try again later!";
            } else {
                mysqli_stmt_bind_param($stmt, "s", $username);
                mysqli_stmt_execute($stmt);
            }

            mysqli_stmt_close($stmt);
            #closing the connection with the database
            mysqli_close($conn);

            echo '
            <script>
                document.querySelector("#send_login").click();
            </script>';
        }
    } else {
        echo 'No avatar selected!';
    }
}

#if no form submitted
else {
    echo "submit button not pressed";
    exit();
}
