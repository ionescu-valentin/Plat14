<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Materialize CSS-->
    <link rel="stylesheet" href="style/materialize.css">

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Style CSS-->
    <link rel="stylesheet" href="style/style.css">

    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>

    <!-- Materialize JS -->
    <script src="js/materialize.js"></script>
    <title>mare proiect ce fac</title>
</head>

<body class="">
    <div class="navbar-fixed">
        <!-- Navigation BAR -->
        <nav class="tabs-nav">
            <div class=" nav-wrapper light-blue darken-4">
                <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                <a href="#" class="brand-logo center">Site smecher</a>
                <?php
                if (isset($_SESSION['username'])) {
                    echo '
                    <a href="userProfile.php" id="profile_view" class="right">
                        <div class="light-blue darken-3 z-depth-1">';
                    if (empty($_SESSION['avatar'])) {
                        echo '<i class="material-icons">person</i>';
                    } else {
                        echo '<img src="images/profile_icons/' . $_SESSION['avatar'] . '.png">';
                    }

                    echo '
                         <h6>' . $_SESSION['username'] . '</h6>
                        </div>
                    </a>';
                }
                ?>
                <ul id="nav-mobile" class="left hide-on-med-and-down">
                    <li><a href="./index.php">Home</a></li>
                    <?php
                    if (!isset($_SESSION['teamID'])) {
                        printf('<li><a class="modal-trigger" data-target="joinTeam-modal">Join a team</a></li>');
                    } else {
                        echo '<li><a href="teamView.php">My team</a></li>';
                    }
                    ?>
                    <li><a href="components/calendar.php">Calendar</a></li>
                </ul>
            </div>
            <!-- tabs on mobile -->
            <div id="browsing-tabs" class="deep-orange darken-4 nav-content">
                <ul class="tabs tabs-transparent">
                    <li class="tab"><a href="#general-view">General</a></li>
                    <li class="tab"><a href="#workspace">Workspace</a></li>
                    <li class="tab"><a href="#internal">Internal</a></li>
                </ul>
            </div>
        </nav>
    </div>
    <!-- Responsive sidenav trigger -->
    <ul class="sidenav" id="mobile-demo">
        <li><a href="./index.php">Home</a></li>
        <?php
        if (!isset($_SESSION['teamID'])) {
            printf('<li><a class="modal-trigger" data-target="joinTeam-modal">Join a team</a></li>');
        } else {
            echo '<li><a>My team</a></li>';
        }
        ?>
        <li><a href="components/calendar.php">Calendar</a></li>
    </ul>