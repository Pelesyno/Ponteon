<?php

namespace App\Controllers;

use App\Models\Users as mUsers;

class Users extends BaseController
{
    protected $session;

    function __construct()
    {
        $this->session = \Config\Services::session();
        $this->session->start();
    }

    public function login(){
        $users = new mUsers();
        $users->where('email', $this->request->getPost('email'));
        $users->where('password', md5($this->request->getPost('password')));
        $user = $users->findAll();

        if (count($user) == 1){
            var_dump($user);
            $this->session->set('logged', true);
            $this->session->set('username', $user[0]['name']);
            $this->session->set('id_user', $user[0]['id_user']);
            return redirect()->to('enquetes'); 
        } else {
            session()->setFlashdata('message', 'Erro Email ou Senha Incorretos!');
            session()->setFlashdata('alert-class', 'alert-danger');
            return view('login');
        }
    }

    public function logout(){
        $this->session->destroy();
        return redirect()->to('home');
    }
}