<?php
//charger le fichier de connexion à la base de données 
require "connexion.php";
require "head.php";
require "lesmenu.php";

if (isset($_POST['ajouter'])) {

    $nomdoc = $_POST['nomdoc'];
    $datesave = $_POST['datesave'];
    $iddepartement = $_POST['iddepartement'];
    $idcategorie = $_POST['idcategorie'];

    $fichier = basename($_FILES['fichier']['name']);
    $q =
        $bd->prepare("insert into document(nomdoc,fichier,datesave,idcategorie,iddepartement)value(?,?,?,?,?)");
    $q->execute(array($nomdoc, $fichier, $datesave, $idcategorie, $iddepartement));

    if ($q) {
        move_uploaded_file($_FILES['fichier']['tmp_name'], 'fichier/' . $fichier);

        header("location:listedoc.php");
    } else {
        echo '<div class="alert alert-danger">Erreur </div>';
    }
}
?>

<div class="container"><br>
    <div class="row">

        <div class="col">
            <div class="card">
                <div class="card-header">Ajouter un document</div>
                <div class="card-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <label for="">Date</label>
                        <input type="date" name="datesave" class="form-control">
                        <label for="">Nom du document</label>
                        <input type="text" name="nomdoc" class="form-control">
                        <label for="">Categorie</label>
                        <select name="idcategorie" id="" class="form-control" required>
                            <option value="">
                                -Selectionner-
                            </option>
                            <?php
                            $q = $bd->prepare("SELECT categorie,idcategorie from categories order by categorie");
                            $q->execute();
                            while ($d = $q->fetch()) {
                            ?>
                                <option value="<?php echo $d['idcategorie'] ?>">
                                    <?php echo $d['categorie'] ?>
                                </option>
                            <?php
                            }
                            ?>

                        </select>
                        <label for="">Departement</label>
                        <select name="iddepartement" id="" class="form-control" required>
                            <option value="">
                                -Selectionner-
                            </option>
                            <?php
                            $q = $bd->prepare("SELECT departement,iddepartement from departements order by departement");
                            $q->execute();
                            while ($d = $q->fetch()) {
                            ?>
                                <option value="<?php echo $d['iddepartement'] ?>">
                                    <?php echo $d['departement'] ?>
                                </option>
                            <?php
                            }
                            ?>

                        </select>

                        <label for="">Charger le document</label>
                        <input type="file" name="fichier" class="form-control" required>
                        <br>
                        <input type="submit" value="Ajouter" name="ajouter" class="btn btn-primary">

                    </form>
                </div>
            </div>
        </div>

    </div>
</div>