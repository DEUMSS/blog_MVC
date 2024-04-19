<?php

namespace blog\model;

use blog\model\BilletsManager;

class CommentairesManager extends Manager
{

    private $billetsManager;

    public function __construct()
    {
        $this->billetsManager = new BilletsManager(); 
        parent::__construct();
    }


    /**
     * Return list of comments 
     * 
     * @param int $idBillet
     * @return false|array
     */
    public function getListCommentaires( int $idBillet )
    {
        $billet = $this->billetsManager->getBillet( $idBillet );
        $req = $this->dbManager->db->prepare(
            'SELECT 
                        auteur, 
                        commentaire, 
                        date_commentaire
                    FROM commentaires 
                    WHERE id_billet = :id 
                    ORDER BY date_commentaire DESC'
        );
        if( $req->execute([
                ':id'   =>  $billet->getId()
        ]) ) {
            return $req->fetchAll( \PDO::FETCH_ASSOC ); 
        } else return false;


    }


   
}