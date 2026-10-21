<?php
// ========================================================
// ContactController - Florería Tulisol
// ========================================================

require_once __DIR__ . '/../../config/database.php';

class ContactController extends Controller {
    public function index(): void {
        $this->render('contact.index', [
            'pageTitle' => 'Contacto y Ubicación | Florería Tulisol'
        ]);
    }

    public function send(): void {
        $name    = trim($this->getPost('name', ''));
        $email   = trim($this->getPost('email', ''));
        $phone   = trim($this->getPost('phone', ''));
        $subject = trim($this->getPost('subject', 'Consulta Web'));
        $message = trim($this->getPost('message', ''));

        if (empty($name) || empty($email) || empty($message)) {
            Session::setFlash('error', 'Por favor llena todos los campos requeridos.');
            $this->redirect('contacto');
            return;
        }

        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("INSERT INTO `contact_messages` (`name`, `email`, `phone`, `subject`, `message`) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$name, $email, $phone, $subject, $message]);

            Session::setFlash('success', '¡Gracias por escribirnos! Te responderemos a la brevedad.');
        } catch (Exception $e) {
            Session::setFlash('error', 'Ocurrió un error al enviar tu mensaje. Intenta nuevamente.');
        }

        $this->redirect('contacto');
    }
}
