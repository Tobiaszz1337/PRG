<?php

class AuthController extends Controller
{
    public function loginForm(): void
    {
        $this->view('login.index', [
            'title'   => 'Přihlášení',
            'heading' => 'Přihlaste se',
        ]);
    }

    public function login(): void
    {
        $email    = $this->input('email', '');
        $password = $this->input('password', '');

        // Demo: hardcoded credentials — replace with User::findByEmail() + password_verify()
        if ($email === 'admin@example.com' && $password === 'tajne123') {
            $_SESSION['user'] = ['email' => $email, 'name' => 'Admin'];
            $this->flash('success', 'Přihlášení úspěšné!');
            $this->redirect('/home');
        }

        $this->view('login.index', [
            'title'   => 'Přihlášení',
            'heading' => 'Přihlaste se',
            'error'   => 'Nesprávný e-mail nebo heslo.',
        ]);
    }

    public function logout(): void
    {
        session_destroy();
        $this->redirect('/login');
    }
}
