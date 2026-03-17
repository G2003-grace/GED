<?php
require "connexion.php";
require "head.php";
if (isset ($_POST['ajouter'])) 
{
    $nom= $_POST['nom'];
    $email=$_POST['email'];
    $motdepasse=$_POST['motdepasse'];
    $confirmer=$_POST['confirmer'];
    if($motdepasse==$confirmer){ 
    $q= $bd->prepare("INSERT into utilisateur ( nom, email, motdepasse) values (?,?,?) ");
    $q->execute(array($nom, $email,$motdepasse));
    if ($q){
        header("location: ajoutercompte.php");
    }
   if($q->execute()){
    echo"compte cree";
   }
   else{
    echo"erreur de creation";
   }
 }
   else{
    echo"mots de passe different";
   }
      
     }
?>
<?php
//Traitement de la modification du compte après soumission
    if (isset($_POST['appliquermodifier'])) {
        $idutilisateur= $_POST['idutilisateur'];
        $nom = $_POST['nom'];
        $email= $_POST['email'];
        $motdepasse = $_POST['motdepasse'];
        $q = $bd->prepare("UPDATE utilisateur SET  nom= ?, email=?,motdepasse=? order by idutilisateur");
        $q->execute(array( $nom, $idemail,$motdepasse));
    
        echo '<div class="alert alert-success">Compte modifié avec succès</div>';
    
}

?>

<?php
if (isset($_POST['modifier'])) {
    // Récupération de l'ID du compte depuis l'URL
    $idutilisateur = $_POST['idutilisateur'];
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $motdepasse = $_POST['motdepasse'];
    
?>


<div class="card">
        <div class="card-body">
            <h5 class="card-title">Modifier le compte</h5>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                <input type="hidden" name="idutilisateur" value="<?php echo $idutilisateur; ?>" />    
                    <label for="nom">Nom</label>
                    <input type="text" name="nom" class="form-control" value="<?php echo  $nom; ?>" required />
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" value="<?php echo $email; ?>" required />
                    <label for="motdepasse">Mot de passe</label>
                    <input type="password" name="confirmer" class="form-control" value="<?php  echo $motdepasse; ?>" required />
                </div>
                <button type="submit" name="appliquermodifier" class="btn btn-warning">Modifier le compte</button>
            </form>
        </div>
    </div>
    <?php

}
    else {
        
    
    ?>
    <!--formulaire d'ajout le debut du code-->
    <div class="container"><br>
   

   <div class="card">
       <div class="card-header bg-primary text-white"> Ajouter un document</div>
   <div class="card-body">
   
   <form method="POST" action=""enctype="multipart/form-data" >

       <label for="" class="mb-2">Nom </label>
       <input type="text" name="nom" placeholder="entrer le nom du compte" class="form-control mb-2"
       required=""><br>
       <label for="" class="mb-2">Email</label>
        <input type="text" name="email" placeholder="saisiser l'email" class="form-control mb-2"
        required=""><br>
        <label for="" class="mb-2">mot de passe</label>
        <input type="password" name="motdepasse" placeholder="saisiser le mot de passe" class="form-control"
        required=""><br>
        <label for="" class="mb-2">confirmer le mot de passe</label>
        <input type="password" name="confirmer" placeholder="confirmer le mot de passe" class="form-control"
        required=""><br>
        <input type="submit" name="ajouter" value="Ajouter" class="btn btn-primary">
       <input type="submit" name="anuler" value="anuler" class="btn btn-primary">
</form>

<?php
       }
    ?>
<div class="card mt-4">
    <div class="card-header">Liste des comptes</div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>mot de passe</th>
                    <th>modifier</th>
                    <th>Supprimer</th>
                </tr>
            </thead>
            <tbody>
            <?php
                // Récupérer les comptes avec les informations 
                $q = $bd->prepare("SELECT idutilisateur,nom,email,motdepasse FROM utilisateur ORDER BY idutilisateur");

                // Exécuter la requête et afficher les résultats dans le tableau
                $q->execute();
                while ($d = $q->fetch()) {
            ?>
                    <tr>
                        <td><?php echo $d['nom']; ?></td>
                        <td><?php echo $d['email']; ?></td>
                        <td><?php echo $d['motdepasse']; ?></td>
                       
                        <td>
                            <form method="POST" action="">
                                <input type="hidden" name="idutilisateur" value="<?php echo $d['idutilisateur']; ?>" />
                                <input type="hidden" name="idutilisateur" value="<?php echo $d['nom']; ?>" />
                                <input type="hidden" name="idutilisateur" value="<?php echo $d['email']; ?>" />
                                <input type="hidden" name="idutilisateur" value="<?php echo $d['motdepasse']; ?>" />
                                <input type="submit" value="Modifier" name="modifier" class="btn btn-warning">
                            </form>
                        </td>
                        <td>
                            <form method="POST" action="" onsubmit="return confirm('Voulez-vous supprimer ce compte ?')">
                                <input type="hidden" name="idutilisateur" value="<?php echo $d['idutilisateur']; ?>" />
                                <input type="submit" value="Supprimer" name="supprimer" class="btn btn-danger">
                            </form>
                        </td>
                    </tr>
            <?php
                }
            ?>
            </tbody>
        </table>
    </div>
</div>

