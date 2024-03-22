<!doctype html>
<html lang="nl">

<head>
    <title>StoringApp / Meldingen / Aanpassen</title>
    <?php require_once '../components/head.php'; ?>
</head>

<body>
    <?php

    if(!isset($_GET['id'])){
        echo "Geef in je aanpaslink op de index.php het id van betreffende item mee achter de URL in je a-element om deze pagina werkend te krijgen na invoer van je vijfstappenplan";
        exit;

    }
    ?>
    <?php
        require_once '../components/header.php'; ?>

    <div class="container">
        <h1>Melding aanpassen</h1>

        <?php
        //Haal het id uit de URL:
        $id = $_GET['id'];

        //1. Haal de verbinding erbij
        require_once'../../../config/conn.php';

        //2. Query, vul deze aan met een WHERE zodat je alleen de melding met dit id ophaalt
        $query = "SELECT * FROM meldingen WHERE id = :id";

        //3. Van query naar statement
        $statement = $conn->prepare($query);

        //4. Voer de query uit, voeg hier nog de placeholder toe
        $statement->execute([
            ":id" => $id
        ]);

        //5. Ophalen gegevens, tip: gebruik hier fetch().
        $meldingen = $statement->fetch(PDO::FETCH_ASSOC);
        // print_r($meldingen);
        // exit();
        ?>

        <form action="<?php echo $base_url; ?>/app/Http/Controllers/meldingenController.php" method="POST">
            <input type="hidden" name ="action" value="update">
            <input type="hidden"name ="id" value="<?php echo $id;?>">
            <!-- (voeg hier opdracht 7 toe) -->

            <div class="form-group">
                <label>Naam attractie:</label>
                <input type="text" name="attractie" id="attractie" class="form-input"
                value="<?php echo $meldingen['attractie']; ?>"> 
            </div>

            <!-- Zorg dat het type wordt getoond, net als de naam hierboven -->
            <div class="form-group">
                <label for="capaciteit">Capaciteit p/uur:</label>
                <input type="number" min="0" name="capaciteit" id="capaciteit" class="form-input"
                value="<?php echo $meldingen['capaciteit']; ?>">
            </div>
            <div class="form-group">
                <label for="prioriteit">prioriteit</label>
                <!-- Let op: de checkbox blijft nu altijd uit, pas dit nog aan -->
                <label for="prioriteit">Melding met prioriteit</label>
                <input type="checkbox" name="prioriteit" id="prioriteit"<?php if($meldingen['prioriteit']) echo 'checked';?>>
                
            </div>
            <div class="form-group">
                <label for="melder">Naam melder:</label>
                <!-- Voeg hieronder nog een value-attribuut toe, zoals bij capaciteit -->
                <input type="text" name="melder" id="melder" class="form-input"
                value="<?php echo $meldingen['capaciteit']; ?>">
            </div>
            <div class="form-group">
                <label for="overig">Overige info:</label>
                <textarea name="overig" id="overig" class="form-input" rows="4"><?php echo $meldingen['overige_info'];?></textarea>
            </div>
            <input type="submit" value="Melding opslaan">
        </form>
    </div>

</body>

</html>
