<?php

session_start();

$performer_name = "Kelvin Hart";
$height = "5 Inches Tall";
$location = "Dubai";

$user_age = 16;
$min_age = 18;
$max_age = 49;

$comedy_show = array(
    "performer" => $performer_name,
    "performer_height" => $height,
    "location" => $location
);

function allowed_user($age) {
    if ($age >= 18 && $age <= 49) {
        echo "✅ You are between 18 and 49 and can attend the show.<br><br>";
    } elseif ($age >= 50) {
        echo "🚗 You are 50 or older. Please wait in the car.<br><br>";
    } else {
        echo "🚫 You are under 18. Wait outside with your parents.<br><br>";
    }
}

allowed_user($user_age);

echo "Performer Height: " . $comedy_show['performer_height'];

?>
