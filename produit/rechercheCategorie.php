<?php include '../header.php' ?>
<?php include '../navbar.php' ?>

<?php 
    $r = false;
    if ($isBD) {
        $id = (int) filter_input(INPUT_GET, 'categorie');
        if($id > 0){
            $res = $bd->query('SELECT * FROM PRODUIT WHERE CATEGORIE ='.$id.' AND VISIBLE = \'V\'');
            foreach($categories as $categorie){
                if((int) $categorie->getId() === $id){
                    $c = $categorie->getNom();
                }
            }
        }
    }

    $produits = [];
    if($res !== false) while($row = $res->fetch_assoc()){
        $produits[] = new Produit($row['ID_PRODUIT'], $row['NOM_PRODUIT'], $row['DESCRIPTION'], 
                $row['CATEGORIE'], $row['PRIX'], $row['TAXE'], 
                $row['IMAGE'], $row['ALT'], $row['VISIBLE']);
        $r = true;
    }
    
    
?>
<BR>
<div class="container">
    <div class="row">
        <?php if($r){ ?>
            <h2 class="titreRubrique"><?php echo $c; ?> </h2>
            <BR>
            <table class="table table-hover">
            <thead>
                <th>Produit</th>
                <th></th> 
                <th>Prix</th>
            </thead>
            <?php
            foreach ($produits as $produit){ 
                if($produit->getVisible() !== 'I'){
            ?>
            <tr onclick="document.location = 'detail.php?id=<?php echo $produit->getId(); ?>';" style="cursor: pointer;">
                <td class="vert-align" style="width: 100px;"><img src="<?php echo $documentRoot.$produit->getUrlImage(); ?>" alt="<?php echo $produit->getAltImage();?>" class="imagePanier"></td>
                <td class="vert-align" style="width: 800px;"><?php echo $produit->getNom(); ?></td>
                <td class="vert-align"><?php echo $produit->getPrix(); ?> $ CAD</td>
            </tr>
                <?php }} ?>
            </table>
        <?php }else{ ?>
        <h2 class="titreRubrique">Désolé <?php echo ($isUserConnected)? $user->getPrenom() : 'Billy'; ?>, aucun produit ne correspond à ta recherche !</h2>
        <?php } ?>
    </div>
</div>

<?php include '../footer.php' ?>