<?php

namespace blog\controller;

use blog\model\Users;
use blog\model\UsersManager;

class SecurityController extends Controller
{
    private $usersManager;
    
    public function __construct()
    {
        $this->usersManager = new UsersManager();
        parent::__construct();
    }

    public function defaultAction()
    {
        $this->loginAction();
        
    }

    public function loginAction()
    {
        $data=[];
        if( isset( $_POST['login'] ) && isset( $_POST['password'] ) ) {
 
            if( $acces = $this->usersManager->getUserByLogin( $_POST['login'] ) ) {
                if( sodium_crypto_pwhash_str_verify( hex2bin($acces->getPassword('password')), $_POST['password']) ) {
                        $_SESSION['login'] = $acces->getPseudo();
                        $_SESSION['photo'] = $acces->getPhoto();
                        $_SESSION['isConnected'] = true;
                        header('Location:index.php');
                        exit;
                } else {
                    $_SESSION['login'] = $acces->getPseudo();
                    $data['message'] = [
                        'type'  => 'warning',
                        'mess'  => 'Le mot de passe est incorrect'
                    ];
                }
            } else {
                $data['message'] = [
                    'type'  => 'warning',
                    'mess'  => 'Le login est incorrect'
                ];
            }
        } 
        $this->render( 'security', $data );
    }


    public function logoutAction()
    {
        session_destroy();
        header('Location: .');
        exit;
    }



    
}