<?php
    session_start();

    $bdd = new PDO('mysql:host=127.0.0.1;port=8889;dbname=espace_membre', 'root', 'root');

    if(isset($_POST['formconnexion'])){
        $mailconnect = htmlspecialchars($_POST['mailconnect']);
        $passconnect = sha1($_POST['passconnect']);
        if(!empty($mailconnect) && !empty($passconnect)){
            $requser = $bdd->prepare("SELECT * FROM membres WHERE mail = ? AND password = ?");
            $requser->execute(array($mailconnect, $passconnect));
            $userexist = $requser->rowCount();
            if($userexist == 1){
                $userinfo = $requser->fetch();
                $_SESSION['id'] = $userinfo['id'];
                $_SESSION['pseudo'] = $userinfo['pseudo'];
                $_SESSION['mail'] = $userinfo['mail'];
                header("Location: profil.php?id=" . $_SESSION['id']);
            } else {
                $erreur = "Email ou mot de passe incorrect !";
            }
        } else {
            $erreur = "Veuillez remplir tous les champs !";
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>

    <div align="center">
        <h3>Connexion</h3>
        <br><br>

        <form action="" method="POST">
            <input type="email" name="mailconnect" placeholder="Mail" value="<?php if(isset($mailconnect)) {echo $mailconnect;} ?>">
            <input type="password" name="passconnect" placeholder="Mot de passe">
            <input type="submit" name="formconnexion" value="Se connecter">
        </form>
        <br>
        Pas encore de compte ? <a href="inscription.php">Inscrivez vous !</a>
        <br>
        <?php
            if(isset($erreur)){
                echo '<font color="red">' . $erreur . '</font>';
            }
        ?>

    </div>
    
</body>
</html>