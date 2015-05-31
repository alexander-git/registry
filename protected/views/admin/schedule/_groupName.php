<?php 
    $groupName = $g->name;
    if ($groupName === $lastGroupName) {
        echo '&nbsp;';
    } else {
        echo $groupName;
    }
    $lastGroupName = $groupName;

