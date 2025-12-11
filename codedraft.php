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

echo $shoesRecommendation;

// KROPPEN
$bodyRecommendation = "";

if ($precip <= 0) {
    if ($temp >= 23) {
        $bodyRecommendation = "Shorts och linne, eller liknande riktigt svala kläder.";
    } elseif ($temp >= 20) {
        $bodyRecommendation = "Shorts eller långbyxor, t-shirt eller linne.";
    } elseif ($temp >= 17) {
        $bodyRecommendation = "Långbyxor och kort- eller långärmad tröja.";
    } elseif ($temp >= 14) {
        $bodyRecommendation = "Långbyxor. T-shirt och skjorta eller collegetröja.";
    } elseif ($temp >= 10) {
        $bodyRecommendation = "Långbyxor. T-shirt och collegetröja eller skjorta. Tunn jacka.";
    } elseif ($temp >= 5) {
        $bodyRecommendation = "Långbyxor eller underställsbyxor. Lager på lager på överkroppen, t.ex. underställströja och skjorta eller collegetröja. Skaljacka och skalbyxor.";
    } elseif ($temp >= 0) {
        $bodyRecommendation = "Ullunderställ på under- och överkropp. Skjorta eller collegetröja. Fodrad jacka. Skalbyxor eller fodrade.";
    } elseif ($temp >= -5) {
        $bodyRecommendation = "Ullunderställ på under- och överkropp. Mellanlager, skjorta eller t-shirt. Därefter en varm tröja, fodrad jacka och täckbyxor.";
    } else {
        $bodyRecommendation = "Ullunderställ på under- och överkropp. Mellanlager, skjorta eller t-shirt. Därefter en ulltröja, fodrad jacka och täckbyxor.";
    }
}

//Wet conditions

else {
        if ($temp >= 23) {
        $bodyRecommendation = "Shorts och linne, eller liknande riktigt svala kläder. Tunn regnjacka.";
    } elseif ($temp >= 20) {
        $bodyRecommendation = "Shorts eller långbyxor, t-shirt eller linne. Regnjacka och regnbyxor.";
    } elseif ($temp >= 17) {
        $bodyRecommendation = "Långbyxor och kort- eller långärmad tröja. Regnjacka och regnbyxor.";
    } elseif ($temp >= 14) {
        $bodyRecommendation = "Långbyxor. T-shirt och skjorta eller collegetröja. Regnjacka och regnbyxor.";
    } elseif ($temp >= 10) {
        $bodyRecommendation = "Långbyxor. T-shirt och collegetröja eller skjorta. Regnjacka och regnbyxor.";
    } elseif ($temp >= 5) {
        $bodyRecommendation = "Långbyxor eller underställsbyxor. Lager på lager på överkroppen, t.ex. underställströja och skjorta eller collegetröja. Regnjacka och regnbyxor.";
    } elseif ($temp >= 0) {
        $bodyRecommendation = "Ullunderställ på under- och överkropp. Skjorta eller collegetröja. Fodrat regnställ.";
    } elseif ($temp >= -5) {
        $bodyRecommendation = "Ullunderställ på under- och överkropp. Mellanlager, skjorta eller t-shirt. Därefter en varm tröja, fodrad jacka och täckbyxor. Gärna fordrat rengställ om det finns risk för slaskväder.";
    } else {
        $bodyRecommendation = "Ullunderställ på under- och överkropp. Mellanlager, skjorta eller t-shirt. Därefter en ulltröja, fodrad jacka och täckbyxor.";
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


