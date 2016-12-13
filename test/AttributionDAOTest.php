<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>AttributionDAO : test</title>
    </head>

    <body>

        <?php

        use modele\dao\AttributionDao;
        use modele\dao\Bdd;
        use modele\metier\Attribution;
        use modele\dao\EtablissementDAO;
        use modele\dao\TypeChambreDAO;
        use modele\dao\OffreDAO;
        use modele\metier\Offre;
        use modele\dao\GroupeDAO;

require_once __DIR__ . '/../includes/autoload.php';
        $id = array();
        $id['Offre']['Etab'] = '0350773A';
        $id['Offre']['TypeChambre'] = 'C2';
        $id['Groupe']= 'g004';
        Bdd::connecter();

        echo "<h2>1- AttributionDAO</h2>";

        // Test n°1
        echo "<h3>Test getOneById</h3>";
        try {
            $objet = AttributionDAO::getOneById($id);
            var_dump($objet);
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }

        // Test n°2
        echo "<h3>2- getAll</h3>";
        try {
            $lesObjets = AttributionDAO::getAll();
            var_dump($lesObjets);
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }

        // Test n°3
        echo "<h3>3- insert</h3>";
        try {
            $id['Offre']['Etab'] = '0350773A';
            $id['Offre']['TypeChambre'] = 'C3';
            $id['Groupe']= 'g004';
            $id['NombreChambres']='2';
            $uneOffre= OffreDAO::getOneById($id['Offre']);
            $objet= new Attribution ($uneOffre,GroupeDAO::getOneById($id['Groupe']),'8');
            $ok = AttributionDAO::insert($objet);
            if ($ok) {
                echo "<h4>ooo réussite de l'insertion ooo</h4>";
                $objetLu = AttributionDao::getOneById($id);
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
            $id['Offre']['Etab'] = '0350773A';
            $id['Offre']['TypeChambre'] = 'C3';
            $id['Groupe']= 'g004';
            $uneOffre= OffreDAO::getOneById($id['Offre']);
            $objet= new Attribution ($uneOffre,GroupeDAO::getOneById($id['Groupe']),'8');
            $ok = AttributionDAO::insert($objet);
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
            $objet->setNombreChambres('7');
            $ok = AttributionDao::update($id, $objet);
            if ($ok) {
                echo "<h4>ooo réussite de la mise à jour ooo</h4>";
                $objetLu = AttributionDao::getOneById($id);
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
            $ok = AttributionDao::delete($id);
//            $ok = AttributionDao::delete("xxx");
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
            $id['Offre']['Etab'] = '0350773A';
            $id['Offre']['TypeChambre'] = 'C2';
            $id['Groupe']= 'g004';
            $ok = AttributionDao::isAnExistingId($id);
            $id['Offre']['Etab'] = 'AZERTY';
            $ok = $ok && !AttributionDAO::isAnExistingId($id);
            $id['Offre']['Etab'] = '0352072M';
            $id['TypeChambre'] = 'AZERTY';
            $ok = $ok && !AttributionDAO::isAnExistingId($id);
            $id['Etab'] = 'AZERTY';
            $ok = $ok && !AttributionDAO::isAnExistingId($id);
            $id['Offre']['Etab'] = '0350773A';
            $id['Offre']['TypeChambre'] = 'C2';
            $id['Groupe']= 'AZERTY';
            $ok = $ok && !AttributionDAO::isAnExistingId($id);

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
