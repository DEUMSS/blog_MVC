<?php

namespace blog\model;

class BilletsManager extends Manager
{

    public function getBillet( int $idBillet )
    {
        $req = $this->dbManager->db->prepare(
            'SELECT 
                    id, 
                    titre, 
                    contenu, 
                    date_creation
                FROM billets 
                WHERE id = :id'
        );
        if( $req->execute([
                ':id'=>$idBillet
        ]) ) {
            $billet = new Billets( $req->fetch() );
            return $billet;
        }
        else return false;

    }
   
}