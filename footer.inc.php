<?php
        include_once('classes/Nudge.php');

        $nudges = new Nudge();
        
        $nudges->setUserId2($_SESSION['id']);
        $nudgeCount = $nudges->unreadNudges();
?>
<footer>
    <div class="middle">
        <a href="map.php"><img src="images/map.svg" alt="map button" class="mapbtn"></a>
        <div class="line"></div>
    </div>
    <nav>
        <a href="index.php"><img src="images/home.svg" alt="home icon"></a>
        <a href="allMyCommunities.php"><img src="images/list.svg" alt="list icon"></a>
        <div>
            <?php  if ($nudgeCount['COUNT(*)'] > 0):?>
            <div class="test"></div>
            <?php endif; ?>
            <a href="?nudge=true"><img src="images/notification.svg" alt="notification icon"></a>
        </div>
        <a href="profile.php"><img src="images/profile.svg" alt="profile icon"></a>
    </nav>
</footer>