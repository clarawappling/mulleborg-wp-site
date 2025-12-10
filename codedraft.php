<?php

$shoes = "";

// Rain / wet conditions (rubber boots logic)
if ($precip > 1 && $temp >= 0) {

    if ($temp >= 7) {
        $shoes = "Gummistövlar";
    } elseif ($temp >= 4) {
        $shoes = "Gummistövlar. Fodrade eller med ullstrumpor i.";
    } else { // 0–3°C
        $shoes = "Fodrade gummistövlar med ullstrumpor i.";
    }

}
// Dry conditions (temperature logic)
else {

    if ($temp >= 23) {
        $shoes = "Svala skor, gärna sandaler. Idag är vi nog barfota en del.";
    } elseif ($temp >= 17) {
        $shoes = "Gympaskor eller sandaler för tår som gärna vill spreta.";
    } elseif ($temp >= 10) {
        $shoes = "Gympaskor.";
    } elseif ($temp >= 5) {
        $shoes = "Kängor eller andra lite rejälare skor.";
    } elseif ($temp >= 3) {
        $shoes = "Kängor eller vinterskor.";
    } elseif ($temp >= 0) {
        $shoes = "Kängor eller vinterskor. Gärna ullstrumpor.";
    } elseif ($temp >= -5) {
        $shoes = "Fodrade vinterskor och ullstrumpor.";
    } else { // Below -5
        $shoes = "Fodrade vinterskor och dubbla ullstrumpor.";
    }

}

echo $shoes;
