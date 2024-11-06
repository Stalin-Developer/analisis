<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        log_message('debug', 'Método login llamado');

        if ($this->request->getMethod() === 'POST') {
            log_message('debug', 'Método POST detectado');
            
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            
            log_message('debug', 'Datos recibidos - Username: ' . $username);
            
            // Verificación manual
            if ($username === 'admin' && $password === 'admin123') {
                $model = new UserModel();
                $user = $model->where('username', 'admin')->first();
                
                if ($user) {
                    $session = session();
                    unset($user['password']);
                    $session->set('user', $user);
                    
                    log_message('debug', 'Login exitoso, redirigiendo...');
                    return redirect()->to(base_url('dashboard'));
                }
            }
            
            return redirect()->back()->with('error', 'Credenciales incorrectas');
        }

        return view('auth/login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }
}