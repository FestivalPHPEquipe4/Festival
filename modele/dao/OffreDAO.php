<?php

namespace modele\dao;

use modele\metier\Offre;
use PDOStatement;
use PDO;

/**
 * Description of OffreDao
 * Classe métier  :  Offre
 * @author btssio
 */
class OffreDAO implements IDAO {

    /**
     * crée un objet métier à partir d'un enregistrement
     * @param array $enreg Description
     * @return Offre objet métier obtenu
     */
    protected static function enregVersMetier($enreg) {
        $idEtab = $enreg[strtoupper('idEtab')];
        $idTypeChambre = $enreg[strtoupper('idTypeChambre')];
        $nombreChambres  = $enreg[strtoupper('nombreChambres')];;
        $objetMetier = new Offre($idEtab, $idTypeChambre, $nombreChambres);
        return $objetMetier;
    }

    /**
     * Complète une requête préparée
     * les paramètres de la requête associés aux valeurs des attributs d'un objet métier
     * @param \modele\metier\Offre $objetMetier
     * @param \PDOStatement $stmt
     */
    protected static function metierVersEnreg(Offre $objetMetier, PDOStatement $stmt) {
        $stmt->bindValue(':idEtab', $objetMetier->getIdEtab());
        $stmt->bindValue(':idTypeChambre', $objetMetier->getTypeChambre());
        $stmt->bindValue(':nombreChambres', $objetMetier->getNbChambres());
    }

    public static function getOneById($id) {
        $idEtab = $id['idEtab'];
        $idTypeChambre = $id['idTypeChambre'];
        $objetConstruit = null;
        $requete = "SELECT * FROM Offre WHERE idEtab = :idEtab AND idTypeChambre = :idTypeChambre";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':idEtab', $idEtab);
        $stmt->bindParam(':idTypeChambre', $idTypeChambre);
        $ok = $stmt->execute();
        // attention, $ok = true pour un select ne retournant aucune ligne
        if ($ok && $stmt->rowCount() > 0) {
            $objetConstruit = self::enregVersMetier($stmt->fetch(PDO::FETCH_ASSOC));
        }
        return $objetConstruit;
    }

    public static function getAll() {
        $lesObjets = array();
        $requete = "SELECT * FROM Offre";
        $stmt = Bdd::getPdo()->prepare($requete);
        $ok = $stmt->execute();
        if ($ok) {
            while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $lesObjets[] = self::enregVersMetier($enreg);
            }
        }
        return $lesObjets;
    }
    
    public static function update($id, $objet) {       
        //if ($nombreChambres == 0) {
        //}else {
        //$lgOffre = getNbCh($idEtab, $idTypeChambre);
        //if ($lgOffre != 0) {
        $idEtab = $id['idEtab'];
        $idTypeChambre = $id['idTypeChambre'];
        $ok = false; 
        $req = "UPDATE Offre SET nombreChambres=:nombreChambres WHERE idEtab=:idEtab AND idTypeChambre=:idTypeChambre";
        $stmt = Bdd::getPdo()->prepare($req);
        self::metierVersEnreg($objet, $stmt);
        $stmt->bindParam(':idEtab', $idEtab);
        $stmt->bindParam(':idTypeChambre', $idTypeChambre);
//        $stmt->bindParam(':nombreChambres', $objet);
        $ok = $stmt->execute();
        $ok = $ok && ($stmt->rowCount() > 0);
        return $ok;
        //}
        //}
    }
    
    /*public static function getNbCh($idEtab, $idTypeChambre) {  
        $req2 = "SELECT nombreChambres FROM Offre WHERE idEtab=:idEtab AND idTypeChambre=:idTypeCh";
        $stmt2 = Bdd::getPdo()->prepare($req2);
        $stmt2->bindParam(':idEtab', $idEtab);
        $stmt2->bindParam(':idTypeCh', $idTypeChambre);
        $stmt2->execute();
        $lgOffre = $stmt2->fetchColumn();
        return $lgOffre;
    }*/
    
    public static function delete($id) {             
        //if ($nombreChambres == 0) {
        $idEtab = $id['idEtab'];
        $idTypeChambre = $id['idTypeChambre'];
        $ok = false;  
        $req = "DELETE FROM Offre WHERE idEtab = :idEtab and idTypeChambre = :idTypeCh";
        $stmt = Bdd::getPdo()->prepare($req);
        $stmt->bindParam(':idEtab', $idEtab);
        $stmt->bindParam(':idTypeCh', $idTypeChambre);
        $ok = $stmt->execute();
        $ok = $ok && ($stmt->rowCount() > 0);
        return $ok;
        //} 
    }
    
    public static function insert($objet) {
        //if ($nombreChambres == 0) {
        //}else {
        //$lgOffre = getNbCh($idEtab, $idTypeChambre);
        //if ($lgOffre != 0) {
        //} else {
//        $idEtab = $object['idEtab'];
//        $idTypeChambre = $object['idTypeChambre'];
//        $nombreChambres = $object['nombreChambres'];
        $ok = false; 
        $req = "INSERT INTO Offre VALUES(:idEtab, :idTypeChambre, :nombreChambres)";
        $stmt = Bdd::getPdo()->prepare($req);
        self::metierVersEnreg($objet, $stmt);
//        $stmt->bindParam(':idEtab', $idEtab);
//        $stmt->bindParam(':idTypeCh', $idTypeChambre);
//        $stmt->bindParam(':nombreChambres', nombreChambres);
        $ok = $stmt->execute();
        $ok = $ok && ($stmt->rowCount() > 0);
        return $ok;
        //}
        //}      
    }
    
    public static function obtenirNbOffre($idEtab, $idTypeChambre) {
        $req = "SELECT nombreChambres FROM Offre WHERE idEtab=:idEtab AND idTypeChambre=:idTypeCh";
        $stmt = Bdd::getPdo()->prepare($req);
        $stmt->bindParam(':idEtab', $idEtab);
        $stmt->bindParam(':idTypeCh', $idTypeChambre);
        $stmt->execute();
        $ok = $stmt->fetchColumn();
        if ($ok) {
            return $ok;
        } else {
            return 0;
        } 
    }

    public static function estModifOffreCorrecte($idEtab, $idTypeChambre, $nombreChambres) {
        $nbOccup = AttributionDAO::obtenirNbOccup($idEtab, $idTypeChambre);
        return ($nombreChambres >= $nbOccup);
    }
    
    /*public static function insert($objet) {
        $ok = false;
        $requete = "INSERT INTO Offre VALUES (:idEtab, :idTypeChambre, :nombreChambres)";
        $stmt = Bdd::getPdo()->prepare($requete);
        self::metierVersEnreg($objet, $stmt);
        $ok = $stmt->execute();
        $ok = $ok && $stmt->rowCount() > 0;
        return $ok;
    }

    public static function update($idEtab, $idTypeChambre, $nombreChambres) {
        $ok = false;
        $requete = "UPDATE Offre SET nombreChambres = :nombreChambres WHERE idEtab = :idEtab AND idTypeChambre = :idTypeChambre";
        $stmt = Bdd::getPdo()->prepare($requete);
        self::metierVersEnreg($objet, $stmt);
        $stmt->bindParam(':idEtab', $idEtab);
        $stmt->bindParam(':idTypeChambre', $idTypeChambre); 
        $stmt->bindParam(':nombreChambres', $nombreChambres);        
        $ok = $stmt->execute();
        $ok = $ok && ($stmt->rowCount() > 0);
        return $ok;
    }

    public static function delete($idEtab) {
        $ok = false;
        $requete = "DELETE FROM Offre WHERE idEtab = :idEtab";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':idEtab', $idEtab);
        $ok = $stmt->execute();
        $ok = $ok && ($stmt->rowCount() > 0);
        return $ok;
    }*/


    /**
     * Recherche un identifiant d'Etablissement existant
     * @param string $idEtab de l'etablissement recherché
     * @return int le nombre d'offres à cet id 
     */
    /*public static function isAnExistingId($idEtab) {
        $requete = "SELECT COUNT(*) FROM Offre WHERE idEtab = :idEtab";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':idEtab', $idEtab);
        $stmt->execute();
        return $stmt->fetchColumn(0);
    }*/

}

