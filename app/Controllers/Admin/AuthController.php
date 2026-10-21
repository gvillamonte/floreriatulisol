<?php
// ========================================================
// AuthController - Panel de Administración Florería Tulisol
// ========================================================

class AuthController extends Controller {
    public function login(): void {
        if (Session::isLoggedIn()) {
            $this->redirect('admin');
            return;
        }

        $this->render('admin.auth.login', [
            'pageTitle' => 'Iniciar Sesión | CMS Florería Tulisol'
        ], null);
    }

    public function authenticate(): void {
        $email    = trim($this->getPost('email', ''));
        $password = trim($this->getPost('password', ''));

        if (empty($email) || empty($password)) {
            Session::setFlash('error', 'Por favor ingresa tu correo y contraseña.');
            $this->redirect('admin/login');
            return;
        }

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if (!$user || !$userModel->verifyPassword($password, $user['password'])) {
            Session::setFlash('error', 'Credenciales incorrectas. Verifica tu correo y contraseña.');
            $this->redirect('admin/login');
            return;
        }

        Session::setUser([
            'id'    => $user['id'],
            'name'  => $user['name'],
            'email' => $user['email'],
            'role'  => $user['role']
        ]);

        Session::setFlash('success', '¡Bienvenido(a) al panel administrativo!');
        $this->redirect('admin');
    }

    public function logout(): void {
        Session::logout();
        Session::setFlash('success', 'Has cerrado sesión correctamente.');
        $this->redirect('admin/login');
    }
}
