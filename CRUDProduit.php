<head>
    <title>Affichage base client <br /></title>
    
</head>
<br /><br />
<h2> Base produit actuelle <br /><br /><br /></h2>



<?php
include_once('Classe/ProcedureCRUD.php');

$pdo = connectBdd();
$stmt = selectTable($pdo,"Produit");
/*$dsn = 'mysql:host=mysql-rlucas974.alwaysdata.net;dbname=rlucas974_coffeeshop;port=3306;charset=utf8';

$pdo = new PDO($dsn, 'rlucas974', 'm9741223');

$stmt = $pdo->query("SELECT `ID_Produit`,`Libellé`,Prix FROM `Produit`");*/


?>
<div class="container">
    <div class="col-lg-12">
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Référence</th>
                    <th>Libellé</th>
                    <th>Prix</th>
                    <th>Action</th>
                </tr>
            </thead>

            <?php
            while ($donnee = $stmt->fetch()) {
                ?>

                <tbody>
                    <tr>

                        <td scope="row"> <?php echo ($donnee["ID_Produit"]) ?> </td>
                        <td> <?php echo ($donnee["Libellé"]) ?> </td>
                        <td> <?php echo ($donnee["Prix"]) ?> </td>
                        <td> 
                        <?php echo "<a id='btn_voir' class='btn btn-primary' href='template.php?page=VoirProduit&id_produit=" . $donnee['ID_Produit'] . "'> Voir </a>"; ?>  
                        <?php echo "<a id='btn_modif' class='btn btn-primary' href='template.php?page=ModifProduit&id_produit=" . $donnee['ID_Produit'] . "'> Modifier </a>"; ?>
                        <?php echo "<a id='btn_supprimer' class='btn btn-primary' href='template.php?page=SupprimeProduit&id_produit=" . $donnee['ID_Produit'] . "'> Supprimer </a>"; ?>
                        </td>
                    </tr>
                </tbody>
            <?php } ?>
        </table>
        <div>
        </div>
        <br /><br /><br />

        <a name="AjouteProduit" id="btn_ajout_produit" class="btn btn-primary" href="template.php?page=AjouteProduit" role="button">Ajouter un produit</a>

        <?php
        //$transfert = $pdo->query("INSERT INTO `Produit`(`ID_Produit`, `Libellé`, `Prix`, `Description`, Catégorie) VALUES ('123456','test','1.99','testestest','testcatégorie')"); 
        //$req_transfert = INSERT INTO `Produit`(`Description`, `Libellé`) VALUES ('testestest1', 'testtest2')""; 
        //exec($req_transfert);
        ?>
    </div>
</div>