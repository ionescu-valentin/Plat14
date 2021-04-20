<?php
session_start();

require 'includes/dbconn.inc.php';

include 'components/tabsHeader.php';

?>

<div id="team-view">
    <!-- team view body -->
    <?php
    include 'components/teamInfo.php';
    ?>
    <div class="row">

        <div class="team-content col s10 push-s2">
            <?php
            include 'components/teamGeneral/general.parent.php'
            ?>

            <div id="workspace">
                aaaa
            </div>
            <div id="internal">
            </div>
        </div>
    </div>



</div>
</body>


<!-- index.js -->
<script src="js/index.js"></script>

</html>