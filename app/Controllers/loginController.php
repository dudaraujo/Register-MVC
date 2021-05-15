<?php

namespace App\Controllers;

use Core\Controller;
use Core\Request;
use App\Models\Usuario;
use Core\Session;

class LoginController extends Controller {

    private $session;

    public function __construct() {
        $this->session = Session::getInstance();
    }

    public function index(Request $request) {
        if($request->isMethod('get')) {
            $this->view('formLogin');
        } else {
            $usuarioModel = new Usuario();
            $response = $usuarioModel->login($request->post()); 
            if($response) {
                $this->session->set('user', $response);
                $this->redirect('/user/visualize');
            } else {
                $this->redirect('/login');
            }          
        }
    } 

    public function logout() {
        $this->session->destroy();
        $this->redirect('/login');
    }
}