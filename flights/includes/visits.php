<?php

if(!isset($_COOKIE['visits'])) {
    echo "Witaj pierwszy raz na stronie!";
    setcookie('visits', '1', time()+3600*365);
} else {


    setcookie('visits', ++$_COOKIE['visits'], time()+3600*365);
    echo "Witaj, odwiedziłeś nas ".($_COOKIE['visits'])." razy";

}