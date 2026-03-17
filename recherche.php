<?php
include "connexion.php";
include "head.php";
include "lesmenu.php";
?>

<div class="container"><br>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">Rechercher un document</div>
                <div class="card-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <label for="">Nom du document</label>
                        <input type="text" name="nomdoc" class="form-control" required><br>
                        <input type="submit" value="Rechercher" name="rechercher" class="btn btn-success">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['rechercher'])) {
    $nomdoc = $_POST['nomdoc'];

    // Requête préparée avec recherche partielle
    $q = $bd->prepare("
        SELECT document.nomdoc, datesave, categories.idcategorie, categorie, 
               departements.iddepartement, departement, iddoc 
        FROM document
        INNER JOIN categories ON categories.idcategorie = document.idcategorie
        INNER JOIN departements ON departements.iddepartement = document.iddepartement
        WHERE document.nomdoc LIKE :nomdoc
    ");

    // Ajout du paramètre pour la recherche
    $q->execute([':nomdoc' => $nomdoc . '%']);

    if ($q->rowCount() > 0) { ?>
        <div class="card mt-4">
            <div class="card-header">Résultats de la recherche: <?php echo htmlspecialchars($nomdoc); ?></div>
            <div class="card-body">
                <table class="table">
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
                        // Affichage des résultats
                        while ($d = $q->fetch()) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($d['nomdoc']); ?></td>
                                <td><?php echo htmlspecialchars($d['categorie']); ?></td>
                                <td><?php echo htmlspecialchars($d['departement']); ?></td>
                                <td><?php echo htmlspecialchars($d['datesave']); ?></td>
                                <td>
                                    <form action="" method="post" onsubmit="return confirm('Voulez-vous visualiser cette ligne ?')">
                                        <input type="hidden" name="iddoc" value="<?php echo htmlspecialchars($d['iddoc']); ?>" />
                                        <input type="submit" name="visualiser" value="Voir" class="btn btn-primary">
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php
    } else {
        // Aucun résultat trouvé
        echo '<div class="alert alert-warning mt-4">Aucun document trouvé pour "' . htmlspecialchars($nomdoc) . '".</div>';
    }
}
?>
