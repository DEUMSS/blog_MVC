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