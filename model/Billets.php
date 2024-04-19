<?php

namespace blog\model;

class Billets
{
    private $id;
    private $titre;
    private $contenu;
    private $dateCreation;
    
    
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

    public function getTitre()
    {
        return $this->titre;
    }
    public function setTitre( $titre )
    {
        $this->titre = $titre;
    }

    public function getContenu()
    {
        return $this->contenu;
    }
    public function setContenu( $contenu )
    {
        $this->contenu = $contenu;
    }

    public function getDateCreation()
    {
        return $this->dateCreation; 
    }
    public function setDateCreation( $dateCreation )
    {
        $this->dateCreation = $dateCreation;
    }

}