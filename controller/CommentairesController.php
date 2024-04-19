<?php

namespace blog\controller;

use blog\model\BilletsManager;
use blog\model\CommentairesManager;

class CommentairesController extends Controller
{
    private $commentairesManager;
    private $billetsManager;
    
    public function __construct()
    {
        $this->commentairesManager = new CommentairesManager();
        $this->billetsManager = new BilletsManager();
        parent::__construct();
    }

    public function defaultAction()
    {
        
    }

    public function listAction()
    {
        $data = [];
        if( $_REQUEST['idbillet'] ) {
            $data['billet'] = $this->billetsManager->getBillet( $_REQUEST['idbillet'] );

            if( $listCommentaire = $this->commentairesManager->getListCommentaires( $_REQUEST['idbillet']) ) {
                $data['listCommentaire'] = $listCommentaire;
            } else {
                $data['message'] = [
                        'type' => 'warning',
                        'mess' => 'Aucun commentaire associé au billet'
                ];
            }
        } else {
            $data['message'] = [
                    'type' => 'warning',
                    'mess' => 'Erreur ! L\'identifiant du billet n\'est pas présent'
            ];
        }
        $this->render( 'commentaires', $data );
    }
}