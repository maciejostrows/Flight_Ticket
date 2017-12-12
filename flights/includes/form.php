<html>
<body>


<form action="pdf.php" method="post">

    <!--Formularz wylotów-->

    <h3>Wylot / Departure</h3>
    <select name="from">
    <?php

    require("airports.php");


    foreach($airports as $key => $airport){

        echo "<option value = '$key'>".$airport['name']."</option>";

    }


    ?>
    </select>

    <!--Formularz przylotów-->

    <h3>Przylot / Arrival</h3>
    <select name="to">
        <?php

        require("airports.php");


        foreach($airports as $key => $airport){

            echo "<option value = '$key'>".$airport['name']."</option>";

        }


        ?>
    </select>
    <br>

    <!--Input z godziną wylotu*-->
    <h3>Godzina wylotu</h3>

    <input type="datetime-local" name="departureTime">

    <!--Input z czasem lotu w godzinach-->
    <h3>Czas lotu</h3>

    <input type="number" min  ="0" step = "1" name="flightTime">

    <!--Input z ceną -->
    <h3>Cena lotu</h3>

    <input type="number" min = "0" step = "0.01" name="price">

    <br><br>

    <!--Przycisk do wysłania danych-->

    <input type="submit" value="Send">


</form>




</body>
</html>