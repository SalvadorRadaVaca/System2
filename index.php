<?php

    $host = "localhost";
    $db = "ssystem";
    $user = "root";
    $password = "040319659";

    try {
        $connection = new PDO("mysql:host=$host;dbname=$db",$user,$password);
        //echo "Connected...";
    } catch(Exception $ex) {
        echo $ex->getMessage();
    }

    if(isset($_GET['action'])=="insert") {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $sqlStatement = $connection->prepare("INSERT INTO backpacks (name,price) VALUES (:name,:price)");
        $sqlStatement->bindParam(':name',$name);
        $sqlStatement->bindParam(':price',$price);
        $sqlStatement->execute();
        exit();
    }

    //delete but it should send a key (to delete)
    if (isset($_GET["delete"])) {
        $id = $_GET["delete"];
        $sqlStatement = $connection->prepare("DELETE FROM backpacks WHERE id=:id");
        $sqlStatement->bindParam(':id', $id);
        $sqlStatement->execute();
        exit();
    }

    //Consult the data and we get a key to consult the data with the key
    if(isset($_GET["consult"])) {
        $id = $_GET["consult"];
        $sqlStatement = $connection->prepare("SELECT * FROM backpacks WHERE id=".$id);
        $sqlStatement->execute();
        $backpacksList = $sqlStatement->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($backpacksList);
        exit();
    }

    if(isset($_GET['update'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $sqlStatement = $connection->prepare("UPDATE backpacks SET name=:name, price=:price WHERE id=:id");
        $sqlStatement->bindParam(':name', $name);
        $sqlStatement->bindParam(':price', $price);
        $sqlStatement->bindParam(':id', $id);
        $sqlStatement->execute();
        echo json_encode(["success"=>1]);
        exit();
    }

    $sqlStatement = $connection->prepare("SELECT * FROM backpacks");
    $sqlStatement->execute();
    $backpacksList = $sqlStatement->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($backpacksList);
?>