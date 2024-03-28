<?php


$action = $_POST['action'];

if ($action == 'create'){
//Variabelen vullen
$attractie = $_POST['attractie'];
if(empty($attractie))
{
    $errors[]="Vul de attractie-naam in.";
}

$capaciteit = $_POST['capaciteit'];
if(!is_numeric($capaciteit))
{
    $errors[]="Vul voor capaciteit een geldig getal in.";
}

$melder = $_POST['melder'];
if(empty($melder))
{
    $errors[]="Vul uw naam in.";
}

$type = $_POST['Type'];
if(empty($type))
{
    $errors[]="kies iets uit de lijst.";
}

$overig = $_POST['overig'];

if (isset($_POST['prioriteit']))
{
    $prioriteit = 1;
}
else
{
    $prioriteit = 0;
}


if(isset($errors))
{
    var_dump($errors);
    die();
}
//1. Verbinding
require_once '../../../config/conn.php';

//2. Query
$query = "INSERT INTO meldingen (attractie, type, melder, capaciteit, prioriteit, overige_info)
VALUES(:attractie, :type, :melder, :capaciteit, :prioriteit, :overig)";

//3. Prepare
$statement = $conn->prepare($query);
//4. Execute
$statement->execute([
    ":attractie"=>$attractie,
    ":type"=>$type,
    ":melder"=>$melder,
    ":capaciteit"=>$capaciteit,
    ":prioriteit"=>$prioriteit,
    ":overig"=>$overig]);


header("Location: ../../../resources/views/meldingen/index.php?msg=Meldingopgeslagen");
}





if ($action == "update") {

    $id = $_POST['id'];

    $capaciteit = $_POST['capaciteit'];
    if (!is_numeric($capaciteit)) {
        $errors[] = "Vul voor capaciteit geldig getal in";
    }

    $melder = $_POST['melder'];
    if (empty($melder)) {
        $errors[] = "Vul melder's naam in";
    }

    $overige_info = $_POST['overige_info'];

    if (isset($_POST['prioriteit'])) {
        $prioriteit = 1;
    } else {
        $prioriteit = 0;
    }

    if (isset($errors)) {
        var_dump($errors);
        die();
    }
    //verbind
    require_once '../../../config/conn.php';
    // query
    $query = "
        UPDATE meldingen
        SET capaciteit = :capaciteit,
            melder = :melder,
            overige_info = :overig,
            prioriteit = :prioriteit
    WHERE id = :id    ";

        //3. Prepare
        $statement = $conn->prepare($query);

        //4. Execute
        $statement->execute([
            ":melder" => $melder,
            ":capaciteit" => $capaciteit,
            ":prioriteit" => $prioriteit,
            ":overig" => $overig,
            ":id" => $id
        ]);
        header("Location: ../../../resources/views/meldingen/index.php?msg=Melding aangepast");
}





if ($action == "delete") {

    $id = $_POST['id'];

    //1. Verbinding
    require_once '../../../config/conn.php';

    //2. Query
    $query = "DELETE FROM meldingen
         WHERE id = :id";

    //3. Prepare
    $statement = $conn->prepare($query);

    //4. Execute
    $statement->execute([
        ":id" => $id
    ]);
    header("Location: ../../../resources/views/meldingen/index.php?msg=Melding Verwijderd");
}
