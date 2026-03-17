<?php
require "connexion.php";

// Si le bouton se connecter est cliqué	
if (isset($_POST['connexion'])) {

    //Récupération des variables
    $email = $_POST['email'];
    $motdepasse= $_POST['motdepasse'];
    $q = $bd->prepare("select idutilisateur,nom from utilisateur where  email=? and motdepasse=?");
    $q->execute(array($email, $motdepasse));
    $d = $q->fetch();
    if ($d) {
        $_SESSION['idutilisateur'] = $d['idutilsateur'];
        $_SESSION['nom'] = $d['nom'];
        echo '<div class="alert alert-sucess">Acces autorisé </div>';

        header("location:listecompte.php");
    } else {
?>

        <div class="alert alert-danger">Login ou mot de passe incorect </div>
        <script>
            alert("Login ou mot de passe incorect")
        </script>
<?php
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Document</title>
</head>

<body>



    <div class="container"><br><br><br><br>
        <div class="row">
            <div class="col"></div>
            <div class="col">
                <div class="card">
                    <div class="card-header bg-primary text-white">GED</div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <label for="">Email</label>
                            <input type="mail" name="email" class="form-control" placeholder="Entrer le login" required>
                            <br>

                            <label for="">Mot de passe</label>
                            <input type="password" name="motdepasse" class="form-control" placeholder="Entrer le mot de passe" required>
                            <br>

                            <input type="submit" name="connexion" value="Se connecter" class="btn btn-primary btn-lg">
                        </form>
                    </div>
                </div>
            </div>

            <div class="col"></div>
        </div>
    </div>
    </div>

</body>

</html>