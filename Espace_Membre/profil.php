<?php
    session_start();

    $bdd = new PDO('mysql:host=127.0.0.1;port=8889;dbname=espace_membre', 'root', 'root');

    if(isset($_GET['id']) && $_GET['id'] > 0){
        $getid = intval($_GET['id']);
        $requser = $bdd->prepare("SELECT * FROM membres WHERE id = ?");
        $requser->execute(array($getid));
        $userinfo = $requser->fetch();
    
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
</head>
<body>

    <div align="center">
        <h3>Profil de <?php echo $userinfo['pseudo']; ?></h3>
        <br><br>

        Pseudo = <?php echo $userinfo['pseudo']; ?>
        <br>
        Mail = <?php echo $userinfo['mail'] ?>
        <br>
        <?php
            if(isset($_SESSION['id']) && $userinfo['id'] == $_SESSION['id']){
        ?>
        <a href="#">Editer mon profil</a>
        <br>
        <a href="deconnexion.php">Se déconnecter</a>
        <?php
            }
        ?>

    </div>
    
</body>
</html>
<?php
    }
?>