<?php 
    date_default_timezone_set('Asia/Singapore');
    $currTime = new DateTime();
    $lunchTimeOut = new DateTime();
    $lunchTimeOut->setTime(12,30);
    $lunchTimeIn = new DateTime();
    $lunchTimeIn->setTime(14,30);
    $setlunch = $lunchTimeIn->format('H:i:s');

    echo $setlunch."</br>";
    echo $currTime->format('H:i:s');
    if($currTime>$lunchTimeIn && $currTime<$lunchTimeOut){
        echo "</br>Lunch Time at: ".$lunchTimeIn."</br>";
    } else {
        echo "</br>Not Lunch Time";
    }
?>