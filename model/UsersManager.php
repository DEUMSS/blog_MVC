<?php

namespace blog\model;

use blog\model\Users;

class UsersManager extends Manager
{

    public function __construct()
    {
        parent::__construct();
    }



    public function isUserExist( string $login )
    {
        if( empty( $login ) ) return false; 
        $req = $this->dbManager->db->prepare( 
            'select * from users where pseudo =:pseudo' 
        );
        $req->execute( [':pseudo'=>$login] );
        return $req->rowCount();
    }


    public function getUserByLogin( string $userLogin )
    {
        if( empty( $userLogin ) ) return false;
        $req = $this->dbManager->db->prepare( 
            'SELECT * FROM users WHERE pseudo =:login' 
        );
        if( $req->execute( [':login'=>$userLogin] ) ) {
            if( $t = $req->fetch( \PDO::FETCH_ASSOC ) )
                return new Users( $t );  
        }
        return false; 
    }

    public function getUserById( int $userId )
    {
        if( empty( $userId ) ) return false;
        $req = $this->dbManager->db->prepare( 
            'SELECT * FROM users WHERE id =:id' 
        );
        if( $req->execute( [':id'=>$userId] ) ) {
            return new Users( $req->fetch( \PDO::FETCH_ASSOC ) );
        }
    }


    public function insertProfilThumb( Users $user )
    {
        if( !empty( $user->getPhoto() ) ) {
            $req = $this->dbManager->db->prepare( 
                'UPDATE users SET photo=:photo WHERE id=:id' 
             );
             return $req->execute([
                'id'    => $user->getId(),
                'photo' => $user->getPhoto()
             ]);
        } else return false;
    }


    /**
     * 
     * @return false|Users
     */
    public function createUser( Users $newUser )
    {
        $req = $this->dbManager->db->prepare( 
            "INSERT INTO users( 
                pseudo, 
                password
            ) VALUE( :pseudo, :password )"
         );
        $isInsertOk = $req->execute([
            ':pseudo'   => $newUser->getPseudo(),
            ':password' => bin2hex( $newUser->getPassword() ) 
         ]);
         if( !$isInsertOk ) {
            return false;
         } else {
            $idUser = $this->dbManager->db->lastInsertId();
            $newUser->setId( $idUser );
            return $newUser;
         }
    }

}