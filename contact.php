<?php

//*************************************connection **************************************

$dbhost = 'db'; // le nom du service MySQL dans docker-compose.yml
$dbname = 'faiez';
$dbuser = 'root';
$dbpass = 'password';

$con = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8", $dbuser, $dbpass);
$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if(!empty($_POST['surname']) && !empty($_POST['firstname']) && !empty($_POST['email']) && !empty($_POST['message'])){
    $surname = htmlspecialchars($_POST['surname'], ENT_QUOTES, 'UTF-8');
    $firstname = htmlspecialchars($_POST['firstname'], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
    $message = htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8');

    if(filter_var($email, FILTER_VALIDATE_EMAIL)){

        $req = $con->prepare("INSERT INTO monweb (name, firstname, email, message) VALUES (:surname, :firstname, :email, :message)");
        $req->bindParam(':surname', $surname);
        $req->bindParam(':firstname', $firstname);
        $req->bindParam(':email', $email);
        $req->bindParam(':message', $message);
        $req->execute();

        $success_msg = "Email envoyé avec succès !";
    }
    else{
        $error_msg = "Email non valide";
    }

} else {
    header('Location: index.html');
    die();
}

if(isset($success_msg)){
    header('Location: index.html?success_msg=' . urlencode($success_msg));
} else {
    header('Location: index.html?error_msg=' . urlencode($error_msg));
}

?>
