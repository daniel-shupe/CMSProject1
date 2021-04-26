<?php
/*
    variables.php
    Daniel Shupe
    CSIS 410
    This script contrains variables for the menu.
*/
    $logo = "<img src=\"../images/logo.png\" alt=\"logo\" />";
    $banner = "<div class=\"logo\">".$logo."Orange Ninja Productions".$logo."</div>";
    $site_nav = array(
        "../index.php"=>"Home",
        "../news.php"=>"News",
        "../upcoming.php"=>"Upcoming",
        "tof/overview.php"=>"Trials of Faith",
        "../about.php"=>"About Us",
        "../mission.php"=>"Our Mission",
        "../faq.php"=>"FAQ",
        "../biography.php"=>"Biography",
        "../shop.php"=>"Shop"
    );
    $dropdown_nav = array(
        "../tof/overview.php"=>"Overview",
        "../tof/morality.php"=>"Morality",
        "../tof/classes.php"=>"Classes",
        "../tof/ability.php"=>"Abilities"
    );