<?php

namespace blog\model;



class Users
{
    private $id;
    private $pseudo;
    private $password;
    private $photo;
    

    
    public function __construct( array $data )
    {
        if( is_array( $data ) && !empty( $data ) )
            $this->hydrate( $data );
        else return false;    
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


    public function getPseudo()
    {
        return $this->pseudo;
    }
    public function setPseudo( $pseudo )
    {
        $this->pseudo = $pseudo;
    }

    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword( $password )
    {
        $this->password = $password;
    }

    public function getPhoto()
    {
        return $this->photo;
    }
    public function setPhoto( $photo )
    {
        $this->photo = $photo;
    }


}