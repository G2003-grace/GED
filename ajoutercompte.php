<?php
require "connexion.php";
require "head.php";
require "lesmenu.php";

if (isset($_POST['ajouter'])) {
    $nom = $_POST["nom"];
    $email = $_POST["email"];
    $motdepasse = $_POST["motdepasse"];
    $mdp = $_POST["mdp"];

    if ($motdepasse == $mdp) {
        if (strlen($motdepasse) >= 8) {
            $q = $bd->prepare("SELECT COUNT(*) FROM utilisateur WHERE email = ?");
            $q->execute(array($email));
            $user = $q->fetchColumn();
            if ($user > 0) {
                echo '<div class="alert alert-danger">Erreur : Cet email est déja utilisé.</div>';
            } else {
                # code.
                $q = $bd->prepare("INSERT INTO utilisateur (nom, email, motdepasse) VALUES (?, ?, ?)");
                $q->execute(array($nom, $email, password_hash($motdepasse, PASSWORD_DEFAULT)));
                echo '<div class="alert alert-success">Compte ajouté avec succès.</div>';
                header("Location: listecompte.php");
            }
        } else {
            echo '<div class="alert alert-danger">Erreur : votre mot de passe est inférieur à 8 caractères.</div>';
        }
    } else {
        echo '<div class="alert alert-danger">Erreur : vos mots de passe ne correspondent pas.</div>';
    }
}
?>

<div class="container"><br>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">Ajouter un compte</div>
                <div class="card-body">
                    <form action="" method="POST">
                        <label for="">Nom</label>
                        <input type="text" name="nom" class="form-control" required>
                        <label for="">Email</label>
                        <input type="mail" name="email" class="form-control" required>
                        <br>
                        <label for="">Mot de passe</label>
                        <input type="password" name="motdepasse" class="form-control" required>
                        <label for="">Confirmer le mot de passe</label>
                        <input type="passwword" name="mdp" class="form-control" required>
                        <br>

                        <input type="submit" value="Ajouter" name="ajouter" class="btn btn-primary">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>