<?php

namespace blog\model;

use blog\model\Billets;

class Commentaires
{
    private $id;
    private $idBillet;
    private $auteur;
    private $commentaire;
    private $dateCommentaire;
    
    
    public function __construct( array $data )
    {

        $this->hydrate( $data );
    }

    public function hydrate(array $data)
    {
        foreach ($data as $key => $value) {
            $method = 'set' . str_replace('_', '', ucwords($key, '_'));
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    public function getId()
    {
        return $this->id;
    }
    public function setId( $id )
    {
        $this->id = $id;
    }

    public function getIdBillet()
    {
        return $this->idBillet;
    }
    
    public function setIdBillet( $idBillet )
    {
        $this->idBillet = $idBillet;
    }
    public function getAuteur()
    {
        return $this->auteur;
    }
    public function setAuteur( $auteur )
    {
        $this->auteur = $auteur;
    }
    public function getCommentaire()
    {
        return $this->commentaire;
    }
    public function setCommentaire( $commentaire )
    {
        $this->commentaire = $commentaire;
    }
    public function getDateCommentaire()
    {
        return $this->dateCommentaire;
    }
    public function setDateCommentaire( $dateCommentaire )
    {
        $this->dateCommentaire = $dateCommentaire;
    }


}