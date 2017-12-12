<html>
<head>
    <title>Podsumowanie</title>
</head>
<body>
<?php
require ('includes/airports.php');
require('vendor/autoload.php');
require_once __DIR__ . '/vendor/autoload.php';


use NumberToWords\NumberToWords;
$tz1 = null;
$tz2 = null;
$flightTime = null;
$airport1 = null;
$airport2 = null;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //sprawdzenie czy uzytkownik nie wybral dwoch takich samych lotnisk

    if(isset($_POST['from']) && (isset($_POST['to']))) {
        if ($_POST['from'] === $_POST['to']) {
            echo "Błąd! Wybrałeś te same lotniska!";
            die();

        } else {
//            var_dump($_POST);
            $airport1 = $_POST['from'];
            $airport2 = $_POST['to'];


        }
    }

    //sprawdzenie czy data i czas lotu została podana

    if(!isset($_POST['departureTime']) or strlen($_POST['departureTime'])<1) {
        echo "Wypełnij pole Czas wylotu!";
        die();

    } else {
        $departureTime = $_POST['departureTime'];
//        var_dump($_POST['departureTime']);

    }

    if(!isset($_POST['flightTime']) or strlen($_POST['flightTime']<=0)) {
            echo "Wypełnij pole Długość lotu!";
            die();
    } else {
            $flightTime = $_POST['flightTime'];
//            var_dump($flightTime);
    }

    //sprawdzenie czy cena jest prawidłowa

    if(!isset($_POST['price']) and $_POST['price']<=0) {
        echo "Wypełnij pole Długość lotu!";
        die();
    } else {
        $price = $_POST['price'];
//        var_dump($price);
    }

    //Sprawdzenie w jakiej strefie czasowej jest lotnisko wylotu
    if(isset($_POST['from'])) {
        $tz1Index = $_POST['from'];
        $tz1 = $airports[$tz1Index];
        $tz1 = $tz1['timezone'];
        $tz1 = new DateTimeZone($tz1);
//        var_dump($tz1);
    }

    //Sprawdzenie w jakiej sterefie czasowej jest lotnisko przylotu
    if(isset($_POST['to'])) {
        $tz2Index = $_POST['to'];
        $tz2 = $airports[$tz2Index];
        $tz2 = $tz2['timezone'];
        $tz2 = new DateTimeZone($tz2);
//        var_dump($tz2);
    }

    //Tworzenie obiektu DateTime i przypisanie strefy czasowej

    $departureTimeObject = new DateTime();
    $departureTimeObject ->setTimezone($tz1);
    $departureTimeObject->modify($departureTime);
//    var_dump($departureTimeObject);

    //Dodanie do czasu wylotu czasu lotu oraz zmiana strefy czasowej dla czasu przylotu

    $departureTimeObject->modify("+".$flightTime." hour");
//    var_dump($departureTimeObject);
    $departureTimeObjectResult = $departureTimeObject->setTimezone($tz2);
//    var_dump($departureTimeObjectResult);


}
?>

<?php
$airport1Name = $airports[$airport1];
$airport1Name = $airport1Name['name'];

$airport1Code = $airports[$airport1];
$airport1Code = $airport1Code['code'];

$airport2Name = $airports[$airport2];
$airport2Name = $airport2Name['name'];

$airport2Code = $airports[$airport2];
$airport2Code = $airport2Code['code'];

$departureTimeObject2 = $departureTimeObject->format('H:i');

$numberToWords = new NumberToWords();
$numberTransformer = $numberToWords->getNumberTransformer('pl');
$priceInWords = $numberTransformer->toWords($price).' złotych';

$faker = Faker\Factory::create();
$fakerName = $faker->name;

?>

<h1>Podsumowanie</h1>
<?php
$table = "<table border = '1'>
    <tr>
        <td>
            
            
             $airport1Name
           
        </td>
        <td>
            
             $departureTime;
            
        </td>
        <td>
            
            
             $airport1Code;
            
        </td>
    </tr>
    <tr>
        <td>
            
            
             $airport2Name;
            
        </td>
        <td>
            
             $departureTimeObject2;
            
        </td>
        <td>
            
            $airport2Code;
            
        </td>
    </tr>
    <tr>
        <td>
            Czas lotu
        </td>
        <td>
            
             $flightTime;
            
        </td>
    </tr>
    <tr>
        <td>
            Cena
        </td>
        <td>
            
             $price;
            
        </td>
        <td>
            

            
             $priceInWords;

            
        </td>
    </tr>
    <tr>
        <td>
            Imię i Nazwisko Pasażera:
        </td>
        <td>
            
            
             $fakerName;

            
        </td>
    </tr>
</table>";

?>
<?php


$mpdf = new \Mpdf\Mpdf(['tempDir' => __DIR__ . '/tmp']);
$mpdf->WriteHTML($table);
$mpdf->Output();
?>
</body>
</html>