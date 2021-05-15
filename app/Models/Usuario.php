<?php

namespace App\Models;

use Core\Database;

class Usuario {
    private $table = "Usuario";

    public function getUserMail() {
        $db = Database::getInstance();

        return $db->getList($this->table, 'email');
    }
                                                                                                                                                                                                                                                                                                       
    public function getAll() {
        $db = Database::getInstance();

        return $db->getList($this->table, '*');
    }

    public function findById($id) {
        $db = Database::getInstance();
        $data = $db->getList($this->table, '*', ['id' => $id]);

        return $data[0];
    }

    public function record($data = null) {
        $db = Database::getInstance();

        if($data != null && !empty($data)) {
            if(
                filter_var($data['email'], FILTER_VALIDATE_EMAIL) && 
                isset($data['senha'])) {

                $data = [
                    'nome' => ($data['nome']),
                    'email' => filter_var($data['email'], FILTER_VALIDATE_EMAIL),  
                    'senha' => password_hash($data['senha'], PASSWORD_BCRYPT, ["cost" => 10]), 
                ];
                return $db->insert($this->table, $data);
            }
        }
        return false;
    }

    public function update($data, $condition) {
        $db = Database::getInstance();
       
        $data['senha'] = password_hash($data['senha'], PASSWORD_BCRYPT, ["cost" => 10]);
        
        return $db->update($this->table, $data, $condition);
    }

    public function delete($id) {
        $db = Database::getInstance();

        return $db->delete($this->table, ['id' => $id]);
    }

    public function login($data) {
        $db = Database::getInstance();
        
        if(!empty($data['email']) && !empty($data['senha'])) {
            $userContent = $db->getList($this->table, '*', ['email' => $data['email']]);

            if(password_verify($data['senha'], $userContent[0]['senha'])) {
                unset($userContent[0]['senha']);
                return $userContent;
            }      
        }
        return false;
    }
}

