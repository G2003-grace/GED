
<?php
//charger le fichier de connexion à la base de données 
require "connexion.php";
require "head.php";
require "lesmenu.php";
?>

<body>
<table class="table table-bordered">
        <thead>
            <tr>
               <th>Nom du document</th>
               <th>Catégorie</th>
               <th>Département</th>
               <th>Date</th>
               <th>Visualiser</th>
            </tr>
        </thead>
        <tbody>
        <?php
             $q = $bd->prepare("select document.nomdoc,datesave,categories.idcategorie,categorie,departements.iddepartement,departement,iddoc from document
            inner join categories on categories.idcategorie=document.idcategorie
            inner join  departements on departements.iddepartement=document.iddepartement
             order by iddoc desc");
            $q->execute();
            while ($d = $q->fetch()) {
            ?>
                <tr>

                    <td><?php echo $d['nomdoc'] ?></td>
                    <td><?php echo $d['categorie'] ?></td>
                    <td><?php echo $d['departement'] ?></td>
                    <td><?php echo $d['datesave'] ?></td>
                    <td>
                        <form action="" method="post" onsubmit="return confirm('Voulez vous visualisez cette ligne ?')">
                            <input type="hidden" name="iddoc" value="<?php echo $d['iddoc'] ?>" />
                            <input type="submit" name="visualiser" value="Voir" class="btn btn-primary">
                        </form>
                    </td>
                    
                </tr>
            <?php
            }
            ?>
        </tbody>

    </table>


    <?php
    if (isset($_POST['visualiser'])) {
        $iddoc = $_POST['iddoc'];

        // Requête pour récupérer les détails du document
        $q = $bd->prepare("
            SELECT document.nomdoc, document.fichier, categories.categorie, departements.departement, datesave 
            FROM document
            INNER JOIN categories ON categories.idcategorie = document.idcategorie
            INNER JOIN departements ON departements.iddepartement = document.iddepartement
            WHERE iddoc = :iddoc
        ");
        $q->execute([':iddoc' => $iddoc]);
        $doc = $q->fetch();

        if ($doc) {
    ?>
        <div class="card mt-4">
            <div class="card-header">Détails du Document</div>
            <div class="card-body">
                <p><strong>Nom :</strong> <?php echo htmlspecialchars($doc['nomdoc']); ?></p>
                <p><strong>Catégorie :</strong> <?php echo htmlspecialchars($doc['categorie']); ?></p>
                <p><strong>Département :</strong> <?php echo htmlspecialchars($doc['departement']); ?></p>
                <p><strong>Date de sauvegarde :</strong> <?php echo htmlspecialchars($doc['datesave']); ?></p>
                <p>
                    <strong>Fichier :</strong> 
                    <?php if (!empty($doc['fichier'])) { ?>
                        <a href="fichier/<?php echo htmlspecialchars($doc['fichier']); ?>" target="_blank" class="btn btn-primary">Télécharger / Voir</a>
                    <?php } else { ?>
                        <span class="text-danger">Fichier non disponible</span>
                    <?php } ?>
                </p>
            </div>
        </div>
    <?php
        } else {
            echo '<div class="alert alert-danger mt-4">Document introuvable.</div>';
        }
    }
    ?>
</div>
</body>


