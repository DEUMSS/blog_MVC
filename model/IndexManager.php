<?php

namespace blog\model;

class IndexManager extends Manager
{
    
    public function getListPosts()
    {
        $req = $this->dbManager->db->query(
            'SELECT 
                    id, 
                    titre, 
                    contenu, 
                    date_creation
                FROM billets 
                ORDER BY date_creation 
                DESC LIMIT 0, 5'
        );
        if( $req ) return $req->fetchAll( \PDO::FETCH_ASSOC );
        else return false;
    }


}