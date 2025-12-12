<!-- SKOR -->
<?php

$shoesRecommendation = "";

// Rain / wet conditions (rubber boots logic)
if ($precip > 1 && $temp >= 0) {

    if ($temp >= 7) {
        $shoesRecommendation = "Gummistövlar";
    } elseif ($temp >= 4) {
        $shoesRecommendation = "Gummistövlar. Fodrade eller med ullstrumpor i.";
    } else { // 0–3°C
        $shoesRecommendation = "Fodrade gummistövlar med ullstrumpor i.";
    }

}
// Dry conditions (temperature logic)
else {

    if ($temp >= 23) {
        $shoesRecommendation = "Svala skor, gärna sandaler. Idag är vi nog barfota en del.";
    } elseif ($temp >= 17) {
        $shoesRecommendation = "Gympaskor eller sandaler för tår som gärna vill spreta.";
    } elseif ($temp >= 10) {
        $shoesRecommendation = "Gympaskor.";
    } elseif ($temp >= 5) {
        $shoesRecommendation = "Kängor eller andra lite rejälare skor.";
    } elseif ($temp >= 3) {
        $shoesRecommendation = "Kängor eller vinterskor.";
    } elseif ($temp >= 0) {
        $shoesRecommendation = "Kängor eller vinterskor. Gärna ullstrumpor.";
    } elseif ($temp >= -5) {
        $shoesRecommendation = "Fodrade vinterskor och ullstrumpor.";
    } else { // Below -5
        $shoesRecommendation = "Fodrade vinterskor och dubbla ullstrumpor.";
    }

}


// KROPPEN
$innerWearRecommendation = "";
$outerWearRecommendation = "";

if ($precip <= 0) { // Dry conditions
    if ($temp >= 23) {
        $innerWearRecommendation = "Shorts och linne, eller liknande riktigt svala kläder.";
        $outerWearRecommendation = "";
    } elseif ($temp >= 20) {
        $innerWearRecommendation = "Shorts eller långbyxor, t-shirt eller linne.";
        $outerWearRecommendation = "";
    } elseif ($temp >= 17) {
        $innerWearRecommendation = "Långbyxor och kort- eller långärmad tröja.";
        $outerWearRecommendation = "";
    } elseif ($temp >= 14) {
        $innerWearRecommendation = "Långbyxor. T-shirt och skjorta eller collegetröja.";
        $outerWearRecommendation = "";
    } elseif ($temp >= 10) {
        $innerWearRecommendation = "Långbyxor. T-shirt och collegetröja eller skjorta.";
        $outerWearRecommendation = "Tunn jacka";
    } elseif ($temp >= 5) {
        $innerWearRecommendation = "Långbyxor eller underställsbyxor. Lager på lager på överkroppen, t.ex. underställströja och skjorta eller collegetröja.";
        $outerWearRecommendation = "Skaljacka och skalbyxor";
    } elseif ($temp >= 0) {
        $innerWearRecommendation = "Ullunderställ på under- och överkropp. Skjorta eller collegetröja.";
        $outerWearRecommendation = "Fodrad jacka. Skalbyxor eller fodrade.";
    } elseif ($temp >= -5) {
        $innerWearRecommendation = "Ullunderställ på under- och överkropp. Mellanlager, skjorta eller t-shirt. Därefter en varm tröja.";
        $outerWearRecommendation = "Fodrad jacka och täckbyxor";
    } else {
        $innerWearRecommendation = "Ullunderställ på under- och överkropp. Mellanlager, skjorta eller t-shirt. Därefter en ulltröja.";
        $outerWearRecommendation = "Fodrad jacka och täckbyxor";
    }
} 
else { // Wet conditions
    if ($temp >= 23) {
        $innerWearRecommendation = "Shorts och linne, eller liknande riktigt svala kläder.";
        $outerWearRecommendation = "Tunn regnjacka";
    } elseif ($temp >= 20) {
        $innerWearRecommendation = "Shorts eller långbyxor, t-shirt eller linne.";
        $outerWearRecommendation = "Regnjacka och regnbyxor";
    } elseif ($temp >= 17) {
        $innerWearRecommendation = "Långbyxor och kort- eller långärmad tröja.";
        $outerWearRecommendation = "Regnjacka och regnbyxor";
    } elseif ($temp >= 14) {
        $innerWearRecommendation = "Långbyxor. T-shirt och skjorta eller collegetröja.";
        $outerWearRecommendation = "Regnjacka och regnbyxor";
    } elseif ($temp >= 10) {
        $innerWearRecommendation = "Långbyxor. T-shirt och collegetröja eller skjorta.";
        $outerWearRecommendation = "Regnjacka och regnbyxor";
    } elseif ($temp >= 5) {
        $innerWearRecommendation = "Långbyxor eller underställsbyxor. Lager på lager på överkroppen, t.ex. underställströja och skjorta eller collegetröja.";
        $outerWearRecommendation = "Regnjacka och regnbyxor";
    } elseif ($temp >= 0) {
        $innerWearRecommendation = "Ullunderställ på under- och överkropp. Skjorta eller collegetröja.";
        $outerWearRecommendation = "Fodrat regnställ";
    } elseif ($temp >= -5) {
        $innerWearRecommendation = "Ullunderställ på under- och överkropp. Mellanlager, skjorta eller t-shirt. Därefter en varm tröja.";
        $outerWearRecommendation = "Fodrad jacka och täckbyxor. Gärna fodrat regnställ om risk för slaskväder";
    } else {
        $innerWearRecommendation = "Ullunderställ på under- och överkropp. Mellanlager, skjorta eller t-shirt. Därefter en ulltröja.";
        $outerWearRecommendation = "Fodrad jacka och täckbyxor";
    }
}


//Mössa och vantar
$headwearRecommendation = "";
$mittensRecommendation = "";

if ($temp < 10) {
    if ($precip >= 2) {
        if ($temp >= 5) {
            $mittensRecommendation = "Galonvantar.";
            $headwearRecommendation = "Sydväst.";
        } elseif ($temp >= 0) {
            $mittensRecommendation = "Fodrade galonvantar.";
            $headwearRecommendation = "Fleecefodrad sydväst.";
        } else {
            $mittensRecommendation = "Varma vintervantar, gärna ullfodrade.";
            $headwearRecommendation = "Varm mössa, gärna i ull.";
        }
    } elseif ($precip >= 1) {
        if ($temp >= 5) {
            $mittensRecommendation = "Vantar som tål lite väta.";
            $headwearRecommendation = "Sydväst eller vanlig mössa.";
        } elseif ($temp >= 0) {
            $mittensRecommendation = "Varma vantar som tål lite väta.";
            $headwearRecommendation = "Varm mössa.";
        } else {
            $mittensRecommendation = "Varma vintervantar, gärna ullfodrade.";
            $headwearRecommendation = "Varm mössa, gärna i ull.";
        }
    } else { // dry
        if ($temp >= 5) {
            $mittensRecommendation = "Fingervantar eller tunna vantar.";
            $headwearRecommendation = "Mössa.";
        } elseif ($temp >= 0) {
            $mittensRecommendation = "Fodrade vantar.";
            $headwearRecommendation = "Varm mössa.";
        } elseif ($temp >= -5) {
            $mittensRecommendation = "Varma vintervantar, gärna ullfodrade.";
            $headwearRecommendation = "Varm mössa, gärna i ull eller liknande.";
        } else {
            $mittensRecommendation = "Innervantar i ull + varma vintervantar ovanpå.";
            $headwearRecommendation = "Balaklava + varm mössa i ull.";
        }
    }
}