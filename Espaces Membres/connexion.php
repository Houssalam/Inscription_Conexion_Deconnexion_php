


<?php
session_start();
  $bdd = new PDO('mysql:host=localhost; dbname=espace_membres;charset=utf8;', 'root', 'Nayef2021@');

  if(isset($_POST['envoi'])) {
    if(!empty($_POST['pseudo']) AND !empty($_POST['email']) AND !empty($_POST['mdp'])) {
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $email = htmlspecialchars($_POST['email']);
    $mdp = sha1($_POST['mdp']);

    $recupUser = $bdd->prepare('SELECT * FROM users WHERE pseudo = ? AND email = ? AND mdp = ?');
    $recupUser->execute(array($pseudo, $email, $mdp));

    if($recupUser->rowCount() > 0) {  
        $_SESSION['pseudo'] = $pseudo;
        $_SESSION['email'] = $email;
        $_SESSION['mdp'] = $mdp;
        $_SESSION['id'] = $recupUser->fetch()['id'];

        header('Location: index.php');
    }
    else {
        echo "Votre mot de passe ou pseudo ou email est incorrect...";
    }
    }
    else {
        echo "Veuillez completer les champs";
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    
<form method="POST" action="" align="center">
    pseudo : 
    <input type="text" name="pseudo" autocomplete="off">
    <br><br>
    Email :
    <input type="email" name="email" autocomplete="off">
    <br><br>
    Mot de passe :
    <input type="password" name="mdp" autocomplete="off">
    <br><br>
    <input type="submit" name="envoi" >
    
</form>

</body>
</html>