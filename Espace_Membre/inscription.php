<?php

    $bdd = new PDO('mysql:host=127.0.0.1;port=8889;dbname=espace_membre', 'root', 'root');

    if(isset($_POST['forminscription'])){
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $mail = htmlspecialchars($_POST['mail']);
        $mailc = htmlspecialchars($_POST['mailc']);
        $password = sha1($_POST['password']);
        $passwordc = sha1($_POST['passwordc']);
        if(!empty($_POST['pseudo']) && !empty($_POST['mail'])
            && !empty($_POST['mailc']) && !empty($_POST['password'])
            && !empty($_POST['passwordc'])){
                

                $pseudolength = strlen($pseudo);
                if($pseudolength <= 50){
                    if($mail == $mailc){
                        if(filter_var($mail, FILTER_VALIDATE_EMAIL)){
                            $reqmail = $bdd->prepare("SELECT * FROM membres WHERE mail = ?");
                            $reqmail->execute(array($mail));
                            $mailexist = $reqmail->rowCount();
                            if($mailexist == 0){
                                if($password == $passwordc){
                                    $insertmbr = $bdd->prepare("INSERT INTO membres(pseudo, mail, password) VALUES (?, ?, ?)");
                                    $insertmbr->execute(array($pseudo, $mail, $password));
                                    $erreur = "Votre compte a bien été créé ! <a href=\"connexion.php\">Me connecter</a>";
                                } else {
                                    $erreur = "Vos mots de passes ne correspondent pas !";
                                }
                            } else {
                                $erreur = "Un compte est déjà associé à cet adresse mail !";
                            }
                        } else {
                            $erreur = "Votre adresse mail n'est pas valide !";
                        }
                    } else {
                        $erreur = "Vos adresses mail ne correspondent pas !";
                    }
                } else {
                    $erreur = "Votre pseudo ne doit pas dépasser 50 caractères !";
                }
            } else {
                $erreur = "Veuillez remplir tout les champs !";
            }
    }

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body>

    <div align="center">
        <h3>Inscription</h3>
        <br><br>

        <form action="" method="POST">

            <table>
                <tr>
                    <td align="right">
                        <label for="pseudo">Pseudo :</label>
                    </td>
                    <td>
                        <input type="text" name="pseudo" placeholder="Votre pseudo" id="pseudo" value="<?php if(isset($pseudo)) {echo $pseudo;} ?>">
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        <label for="mail">Mail :</label>
                    </td>
                    <td>
                        <input type="email" name="mail" placeholder="Votre mail" id="mail" value="<?php if(isset($mail)) {echo $mail;} ?>">
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        <label for="mailc">Confirmation Mail :</label>
                    </td>
                    <td>
                        <input type="email" name="mailc" placeholder="Confirmez votre mail" id="mailc" value="<?php if(isset($mailc)) {echo $mailc;} ?>">
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        <label for="password">Mot de passe :</label>
                    </td>
                    <td>
                        <input type="password" name="password" placeholder="Votre mot de passe" id="password">
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        <label for="passwordc">Confirmation mot de passe :</label>
                    </td>
                    <td>
                        <input type="password" name="passwordc" placeholder="Confirmez votre mdp" id="passwordc">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td align="center">
                        <br>
                        <!-- <button type="submit">Signup</button> -->
                        <input type="submit" name="forminscription" value="Signup">
                    </td>
                </tr>
                
            </table>
            
        </form>
        <br>
        <?php
            if(isset($erreur)){
                echo '<font color="red">' . $erreur . '</font>';
            }
        ?>

    </div>
    
</body>
</html>