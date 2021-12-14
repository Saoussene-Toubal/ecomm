<?php

function getPrice($priceinDecimals){
    $price= floatval($priceinDecimals)/100;

        return number_format($price, 2, ',',' ').' ' .'DZ';
}


?>
