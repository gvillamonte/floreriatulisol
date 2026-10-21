<?php
// ========================================================
// SettingsController - Configuración de Empresa, Logo y Culqi
// Florería Tulisol CMS
// ========================================================

class SettingsController extends Controller {
    public function index(): void {
        $settingModel = new Setting();
        $settings = $settingModel->getAllGrouped();

        $this->renderAdmin('admin.settings.index', [
            'pageTitle' => 'Configuración de Empresa y Pasarela Culqi | CMS',
            'settings'  => $settings
        ]);
    }

    public function update(): void {
        $settingModel = new Setting();

        // 1. Configuraciones de Texto
        $fields = [
            'site_name',
            'site_tagline',
            'site_phone',
            'site_whatsapp',
            'site_whatsapp_msg',
            'site_email',
            'site_address',
            'site_schedule',
            'site_maps_embed',
            'about_title',
            'about_subtitle',
            'about_text',
            'about_mission',
            'instagram_url',
            'facebook_url',
            'tiktok_url',
            'culqi_public_key',
            'culqi_secret_key',
            'culqi_mode',
            'delivery_cost',
            'free_shipping_threshold'
        ];

        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                $settingModel->set($field, trim($_POST[$field]));
            }
        }

        // 2. Subida de Logo (Optimización y conversión a WebP)
        if (!empty($_FILES['site_logo']['tmp_name'])) {
            $uploadResult = ImageOptimizer::processUpload($_FILES['site_logo'], 'branding', 600, 90);
            if ($uploadResult['success']) {
                $settingModel->set('site_logo', $uploadResult['path']);
            } else {
                Session::setFlash('error', 'Error al procesar el Logo: ' . $uploadResult['error']);
                $this->redirect('admin/configuracion');
                return;
            }
        }

        // 3. Subida de Favicon (Optimización a WebP)
        if (!empty($_FILES['site_favicon']['tmp_name'])) {
            $uploadResult = ImageOptimizer::processUpload($_FILES['site_favicon'], 'branding', 128, 90);
            if ($uploadResult['success']) {
                $settingModel->set('site_favicon', $uploadResult['path']);
            }
        }

        Session::setFlash('success', '¡Configuraciones de la empresa, logo WebP y pasarela Culqi guardadas correctamente!');
        $this->redirect('admin/configuracion');
    }
}
