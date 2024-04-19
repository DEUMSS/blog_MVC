<?php

namespace blog\controller;

use blog\model\Users;
use blog\model\UsersManager;

class UsersController extends Controller
{

    private $usersManager;

    public function __construct()
    {
        $this->usersManager = new UsersManager();
        parent::__construct();
    }

    public function defaultAction()
    {
        $this->inscriptionAction();
    }
    

    public function inscriptionAction()
    {
        $data=[];
        $this->render( 'inscription', $data );   
    }

    
    public function valideInscriptionAction()
    {
        $data = [];
        $login = htmlspecialchars( $_POST['login'] );
        $password = htmlspecialchars( $_POST['password'] );
        $passwordConfirm = htmlspecialchars( $_POST['passwordConfirm'] );

        // Vérifier le mot de passe et la confirm
        if( strlen( $password ) < 8 ) {
            header( 'Location: index.php?controller=users&invalidpass=1' );
            exit();
        }
        if( $password != $passwordConfirm ) {
            header( 'Location: index.php?controller=useers&invalidconfirm=1' );
            exit();
        }
        $passHash = sodium_crypto_pwhash_str(
            $password,
            SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE,
            SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE
        );
        $newUser = new Users([
            'pseudo'    => $login,
            'password'  => $passHash
        ]);
        if( $newUser = $this->usersManager->createUser( $newUser ) ) {
            $data['etape2'] = true;
            $_SESSION['newUserId'] = $newUser->getId();
            $_SESSION['login'] = $newUser->getPseudo();
            $_SESSION['isConnected'] = true;
        } else {
            $data['message'] = [
                'type'  => 'warning',
                'mess'  => 'Erreur lors de l\'ajout'
            ];
        }
        $this->render( 'inscription', $data );

    }


    public function insertProfilThumbAction()
    {
        $data = [];
        $photoName = false;
        $newUser = $this->usersManager->getUserById( $_SESSION['newUserId'] );
        if( isset( $_FILES['photo'] ) && $_FILES['photo']['error'] == 0 ) {
            if( $_FILES['photo']['size'] < 128000 ) {
                $infoFichier = pathinfo( $_FILES['photo']['name'] );
                $extension_upload = $infoFichier['extension'];
                $extension_autorisees = [ 'jpg', 'jpeg', 'png' ];
                if( in_array( $extension_upload, $extension_autorisees ) ) {
                    $photoName = basename( $_FILES['photo']['name'] );
                    move_uploaded_file( $_FILES['photo']['tmp_name'], 'assets/images/' . $photoName );
                    $data['message'] = [
                        'type' => 'success',
                        'mess' => "La photo a bien été envoyé"
                    ];  
                    $newUser->setPhoto( $photoName );         
                } else {
                    $data['message'] = [
                        'type' => 'warning',
                        'mess' => "Erreur ! Le format de la photo n'est pas autorisé"
                    ];
                }
            } else {
                $data['message'] = [
                    'type' => 'warning',
                    'mess' => "La photo ne doit pas dépasser les 128Ko"
                ];
            }
        } else {
            $data['message'] = [
                'type' => 'warning',
                'mess' => "Erreur lors du tranfert de la photo"
            ];
        }
        $this->render( 'index', $data );
    }

}