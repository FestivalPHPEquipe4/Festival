<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Attribution Test</title>
    </head>
    <body>
        <?php
        use modele\metier\Attribution;
        use modele\metier\Etablissement;
        use modele\metier\TypeChambre;
        use modele\metier\Offre;
        use modele\metier\Groupe;
        require_once __DIR__ . '/../includes/autoload.php';
        echo "<h2>Test unitaire de la classe métier Attribution</h2>";
        $typeChambre = new TypeChambre('C2','2 à 3 lits');
        $etab = new Etablissement('0350799A','Collège Ste Jeanne d\'Arc-Choisy','3, avenue de la Borderie BP 32','35404','Paramé','0299560159',NULL,'1','Madame','LEFORT','ANNE' );
        $groupe = new Groupe('g001','Groupe folklorique du Bachkortostan',null,null,'40','Bachirie','O');
        $offre = new Offre($etab,$typeChambre,'2');
        $objet = new Attribution($offre,$groupe,'2');
        var_dump($objet);
        ?>
    </body>
</html>
