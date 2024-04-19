<?php

namespace blog\controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Extension\DebugExtension;

abstract class Controller
{
    protected $twig;
    protected $pathView = 'view';

    public function __construct()
    {

        $loader = new FilesystemLoader( $this->pathView );
        $this->twig = new Environment($loader, [
            'debug' => true
        ]);
        $this->twig->addGlobal('session', $_SESSION );
        $this->twig->addExtension(new DebugExtension());

        if( isset( $_REQUEST['action']) ) {
            $action = $_REQUEST['action'] . 'Action';
            $this->$action();
          /*  array_shift( $_REQUEST );
            if( empty( $_REQUEST ) ) {
                $this->$action();
            } else {
                $this->$action( $_REQUEST );
            }*/
        } else {
            $this->defaultAction();
        }
    }

    abstract public function defaultAction();


    protected function render( $view, $data=[] )
    {
        extract( $data );
        $filenameView = ucfirst( $view ) . 'View.twig';
        $filePath = $this->pathView . '/' . $filenameView;
        if( file_exists( $filePath ) ) { 
            echo $this->twig->render( $filenameView, $data );
        } else {
            die( 'View file not exist' );
        }
    }


}