<?php

namespace App\Controllers;

use Core\Controller;
use Core\Request;
use App\Models\Usuario;
use Core\Session;

class UserController extends Controller {

    private $usuarioModel;

    private $session;

    public function __construct() {
        $this->session = Session::getInstance();
    }

    public function register(Request $request) {
        if($request->isMethod('get')) {
            $this->view('formRegister');
        } else {
            $usuarioModel = new Usuario();
            $response = $usuarioModel->record($request->post()); 
            
            $this->view('show', ['user' => $request->post(), 'response' => $response]);
        }
    } 
    
    public function visualize() {
        $usuarioModel = new Usuario();  
        $response = $usuarioModel->getAll();
        $content = ['response' => $response]; 

        $this->view('list', $content);  
    }

    public function update(Request $request) {
        if($request->isMethod('get')) {
            $userId = $request->get();
            $usuarioModel = new Usuario();
            $user = $usuarioModel->findById($userId);

            $this->view('formUpdate', ['user' => $user]);
    
        } else {
            $userId = $request->get();
            $data = $request->post();
            $data['id'] = $userId;
            $usuarioModel = new Usuario();
            $user = $usuarioModel->update($data, ['id' => $userId]);

            $this->redirect('/user/visualize');
        }
    }

    public function delete(Request $request) {
        $userId = $request->get();
        if($userId != null) {
            $usuarioModel = new Usuario();
            $users = $usuarioModel->delete($userId);
        }
        
        $this->redirect('/user/visualize');
    }
}