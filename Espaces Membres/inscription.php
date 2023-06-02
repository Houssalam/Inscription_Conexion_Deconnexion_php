<?php
// session_start();
// $bdd = new PDO('mysql:host=localhost;dbname=espace_membres;charset=utf8;', 'root', 'Nayef2021@');
// if(isset($_POST['envoi'])) {
//   if(!empty($_POST['pseudo'])AND !empty($_POST['email'])  AND !empty($_POST['mdp'])) {
//     $pseudo = htmlspecialchars($_POST['pseudo']);
//     $email = htmlspecialchars($_POST['email']);
//     $mdp = sha1($_POST['mdp']);
//     $insertUser = $bdd->prepare('INSERT INTO users(pseudo, email, mdp)VALUES(?, ?, ?)');
//     $insertUser->execute(array($pseudo, $email, $mdp));

//     $recupUser = $bdd->prepare('SELECT * FROM users WHERE pseudo = ? AND email = ? AND mdp = ?');
//     $recupUser->execute(array($pseudo, $email, $mdp));
//     if($recupUser->rowCount() > 0){
//     $_SESSION['pseudo'] = $pseudo;
//     $_SESSION['email'] = $email;
//     $_SESSION['mdp'] = $mdp;
//     $_SESSION['id'] = $recupUser->fetch()['id'];
//     }
    
//     // echo $_SESSION['id'];
//  }else{
//     echo "Veuillez completer tous les champs...";
//  }
// }
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=espace_membres;charset=utf8;', 'root', 'Nayef2021@');

if(isset($_POST['envoi'])) {
  if(!empty($_POST['pseudo']) && !empty($_POST['email']) && !empty($_POST['mdp'])) {
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $email = htmlspecialchars($_POST['email']);
    $mdp = sha1($_POST['mdp']);

    // Vérifier si le pseudo existe déjà
    $checkPseudo = $bdd->prepare('SELECT * FROM users WHERE pseudo = ?');
    $checkPseudo->execute(array($pseudo));

    // Vérifier si l'email existe déjà
    $checkEmail = $bdd->prepare('SELECT * FROM users WHERE email = ?');
    $checkEmail->execute(array($email));

    if($checkPseudo->rowCount() > 0) {
        echo "Ce pseudo est déjà utilisé. Veuillez en choisir un autre.";
    } elseif($checkEmail->rowCount() > 0) {
        echo "Cet email est déjà utilisé. Veuillez en choisir un autre.";
    } else {
        // Insérer l'utilisateur dans la base de données
        $insertUser = $bdd->prepare('INSERT INTO users(pseudo, email, mdp) VALUES(?, ?, ?)');
        $insertUser->execute(array($pseudo, $email, $mdp));

        $recupUser = $bdd->prepare('SELECT * FROM users WHERE pseudo = ? AND email = ? AND mdp = ?');
        $recupUser->execute(array($pseudo, $email, $mdp));
        
        if($recupUser->rowCount() > 0){
            $userData = $recupUser->fetch();
            $_SESSION['pseudo'] = $pseudo;
            $_SESSION['email'] = $email;
            $_SESSION['mdp'] = $mdp;
            $_SESSION['id'] = $userData['id'];
            echo "Utilisateur enregistré avec succès !";
        }
    }
  } else {
    echo "Veuillez compléter tous les champs...";
  }
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body>
    
<form method="POST" action="" align="center">
    Pseudo : 
    <input type="text" name="pseudo" autocomplete="off">
    <br><br>
    Email : 
    <input type="email" name="email" autocomplete="off" >
    <br><br>
    Mot de passe :
    <input type="password" name="mdp" autocomplete="off">
    <br><br>
    <input type="submit" name="envoi">
    
</form>

</body>
</html>