<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>OffreDAO : test</title>
    </head>

    <body>

        <?php

        use modele\dao\OffreDAO;
        use modele\dao\Bdd;
        use modele\metier\Offre;
        use modele\dao\EtablissementDAO;
        use modele\dao\TypeChambreDAO;

require_once __DIR__ . '/../includes/autoload.php';
        $id = array();
        $id['Etab'] = '0350785N';
        $id['TypeChambre'] = 'C1';
        Bdd::connecter();

        echo "<h2>1- OffreDAO</h2>";

        // Test n°1
        echo "<h3>Test getOneById</h3>";
        try {
            $objet = OffreDAO::getOneById($id);
            var_dump($objet);
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }

        // Test n°2
        echo "<h3>2- getAll</h3>";
        try {
            $lesObjets = OffreDAO::getAll();
            var_dump($lesObjets);
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }

        // Test n°3
        echo "<h3>3- insert</h3>";
        try {
            $id = array();
            $id['Etab'] = '0350773A';
            $id['TypeChambre'] = 'C5';
            $objet = new Offre(EtablissementDAO::getOneById($id['Etab']), TypeChambreDAO::getOneById($id['TypeChambre']), '8');
            $ok = OffreDAO::insert($objet);
            if ($ok) {
                echo "<h4>ooo réussite de l'insertion ooo</h4>";
                $objetLu = OffreDAO::getOneById($id);
                var_dump($objetLu);
            } else {
                echo "<h4>*** échec de l'insertion ***</h4>";
            }
        } catch (Exception $e) {
            echo "<h4>*** échec de la requête ***</h4>" . $e->getMessage();
        }
 
        // Test n°3-bis
        echo "<h3>3- insert déjà présent</h3>";
        try {
            $id = array();
            $id['Etab'] = '0350773A';
            $id['TypeChambre'] = 'C5';
            $objet = new Offre(EtablissementDAO::getOneById($id['Etab']), TypeChambreDAO::getOneById($id['TypeChambre']), '10');
            $ok = OffreDAO::insert($objet);
            if ($ok) {
                echo "<h4>*** échec du test : l'insertion ne devrait pas réussir  ***</h4>";
                $objetLu = Bdd::getOneById($id);
                var_dump($objetLu);
            } else {
                echo "<h4>ooo réussite du test : l'insertion a logiquement échoué ooo</h4>";
            }
        } catch (Exception $e) {
            echo "<h4>ooo réussite du test : la requête d'insertion a logiquement échoué ooo</h4>" . $e->getMessage();
        }

        // Test n°4
        echo "<h3>4- update</h3>";
        try {
            $objet->setNombreChambres('12');
            $ok = OffreDAO::update($id, $objet);
            if ($ok) {
                echo "<h4>ooo réussite de la mise à jour ooo</h4>";
                $objetLu = OffreDAO::getOneById($id);
                var_dump($objetLu);
            } else {
                echo "<h4>*** échec de la mise à jour ***</h4>";
            }
        } catch (Exception $e) {
            echo "<h4>*** échec de la requête ***</h4>" . $e->getMessage();
        }

        // Test n°5
        echo "<h3>5- delete</h3>";
        try {
            $ok = OffreDAO::delete($id);
//            $ok = EtablissementDAO::delete("xxx");
            if ($ok) {
                echo "<h4>ooo réussite de la suppression ooo</h4>";
            } else {
                echo "<h4>*** échec de la suppression ***</h4>";
            }
        } catch (Exception $e) {
            echo "<h4>*** échec de la requête ***</h4>" . $e->getMessage();
        }


        // Test n°6
        echo "<h3>6- isAnExistingId</h3>";
        try {
            $id = array();
            $id['Etab'] = "0352072M";
            $id['TypeChambre'] = 'C2';
            $ok = OffreDAO::isAnExistingId($id);
            //$id['Etab'] = 'AZERTY';
            //$ok = $ok && !OffreDAO::isAnExistingId($id);
            //$id['Etab'] = '0352072M';
            //$id['TypeChambre'] = 'AZERTY';
            //$ok = $ok && !OffreDAO::isAnExistingId($id);
            //$id['Etab'] = 'AZERTY';
            //$ok = $ok && !OffreDAO::isAnExistingId($id);

            if ($ok) {
                echo "<h4>ooo test réussi ooo</h4>";
            } else {
                echo "<h4>*** échec du test ***</h4>";
            }
        } catch (Exception $e) {
            echo "<h4>*** échec de la requête ***</h4>" . $e->getMessage();
        }

        Bdd::deconnecter();
        ?>


    </body>
</html>
