<?php

namespace blog\controller;

use blog\model\IndexManager;

class IndexController extends Controller
{
    private $_manager;
    
    public function __construct()
    {
        $this->_manager = new IndexManager();
        parent::__construct();
    }


    public function defaultAction()
    {
        if( $listPosts = $this->_manager->getListPosts() ) {
            $data = [
                'listPosts' => $listPosts
            ];
        } else {
            $data = [
                'message' => [
                    'type'  => 'danger',
                    'mess'  => 'Erreur lors de la récupération des billets.'
                ]
            ];
        }
        $this->render( 'index', $data );
    }


}