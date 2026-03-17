<?php
require "connexion.php";
require "head.php";
require "lesmenu.php";



if (isset($_POST['appliquermodifier'])) {
    //Récupération des données
    $idutilisateur = $_POST['idutilisateur'];
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $q = $bd->prepare("
    UPDATE utilisateur 
    SET nom = ?, email = ?
    WHERE idutilisateur = ?
");
$q->execute(array($nom, $email, $idutilisateur));
 
    //Rafraichir la page
    header("Refresh:3");
    //Message de confirmation de la modification
    echo '<div class="alert alert-success">Utilisateur modifié ...</div>';
}
?>
<?php
    // Récupération des données
    if (isset($_POST['modifier'])) {
        // Récupération
        $idutilisateur= $_POST['idutilisateur'];
        $nom = $_POST['nom'];
        $email = $_POST['email'];
    ?>

<div class="container"><br>
    <div class="row">
        <div class="col"></div>
        <div class="col">
            <div class="card">
                <div class="card-header ">Modification </div>
                    <div class="card-body">
                            <form action="" method="POST">
                                <input type="hidden" name="idutilisateur" value="<?php echo $idutilisateur ?>">
                               
                                <label for="">Nom</label>
                                <input type="text" name="nom" value="<?php echo $nom ?>" class="form-control">
                                <label for="">Email</label>
                                <input type="mail" name="email" value="<?php echo $email ?>" class="form-control">
                                <br>

                                <input type="submit" value="Modifier" name="appliquermodifier" class="btn btn-warning btn-lg">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col"></div>
            </div>
        </div>
    <?php
    } 
    ?>
<table class="table">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Email</th>
            <th>Modifier</th>

        </tr>
    </thead>
    <tbody>
        <?php
        $q = $bd->prepare("select * from utilisateur order by idutilisateur desc");
        $q->execute();
        while ($d = $q->fetch()) {
        ?>
            <tr>

                <td><?php echo $d['nom'] ?></td>
                <td><?php echo $d['email'] ?></td>
               
            
                <td>
                    <form action="" method="post" onsubmit="return confirm('Voulez vous modifier cette ligne ?')">
                        <input type="hidden" name="idutilisateur" value="<?php echo $d['idutilisateur']  ?>" />
                        <input type="hidden" name="nom" value="<?php echo $d['nom']  ?>" />
                        <input type="hidden" name="email" value="<?php echo $d['email']  ?>" />

                        <input type="submit" name="modifier" value="modifier" class="btn btn-warning">
                    </form>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>

</table>