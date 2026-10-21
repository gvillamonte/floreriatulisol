<?php
// ========================================================
// ThemeController - Gestión de Temas de Color por Fecha
// Florería Tulisol CMS
// ========================================================

class ThemeController extends Controller {
    public function index(): void {
        $themeModel = new ColorTheme();
        $themes = $themeModel->getAllThemes();

        $this->renderAdmin('admin.themes.index', [
            'pageTitle' => 'Temas de Color por Fecha | Florería Tulisol CMS',
            'themes'    => $themes,
            'labels'    => ThemeHelper::labels(),
            'swatches'  => array_map('ThemeHelper::swatch', ThemeHelper::labels()),
        ]);
    }

    public function create(): void {
        $this->renderAdmin('admin.themes.form', [
            'pageTitle' => 'Nuevo Tema de Color | Florería Tulisol CMS',
            'theme'     => null,
            'labels'    => ThemeHelper::labels(),
        ]);
    }

    public function store(): void {
        $data = $this->validate();
        if ($data === null) {
            $this->redirect('admin/temas/crear');
            return;
        }

        $themeModel = new ColorTheme();
        $id = $themeModel->create($data);

        if ($id) {
            Session::setFlash('success', "Tema de color '{$data['name']}' creado correctamente.");
        } else {
            Session::setFlash('error', 'Error al guardar el tema en la base de datos.');
        }
        $this->redirect('admin/temas');
    }

    public function edit(string $id): void {
        $themeModel = new ColorTheme();
        $theme = $themeModel->find((int)$id);

        if (!$theme) {
            Session::setFlash('error', 'Tema no encontrado.');
            $this->redirect('admin/temas');
            return;
        }

        $this->renderAdmin('admin.themes.form', [
            'pageTitle' => 'Editar Tema: ' . $theme['name'] . ' | Florería Tulisol CMS',
            'theme'     => $theme,
            'labels'    => ThemeHelper::labels(),
        ]);
    }

    public function update(string $id): void {
        $themeModel = new ColorTheme();
        $theme = $themeModel->find((int)$id);

        if (!$theme) {
            Session::setFlash('error', 'Tema no encontrado.');
            $this->redirect('admin/temas');
            return;
        }

        $data = $this->validate();
        if ($data === null) {
            $this->redirect("admin/temas/{$id}/editar");
            return;
        }

        $themeModel->update((int)$id, $data);
        Session::setFlash('success', "Tema '{$data['name']}' actualizado correctamente.");
        $this->redirect('admin/temas');
    }

    public function delete(string $id): void {
        $themeModel = new ColorTheme();
        $theme = $themeModel->find((int)$id);

        if ($theme) {
            $themeModel->delete((int)$id);
            Session::setFlash('success', "El tema '{$theme['name']}' fue eliminado.");
        }

        $this->redirect('admin/temas');
    }

    /**
     * Valida el formulario y devuelve los datos o null si hay error.
     */
    private function validate(): ?array {
        $name      = trim($this->getPost('name', ''));
        $palette   = $this->getPost('palette', '');
        $startDate = $this->getPost('start_date', '');
        $endDate   = $this->getPost('end_date', '');
        $isActive  = isset($_POST['is_active']) ? 1 : 0;
        $sortOrder = (int)$this->getPost('sort_order', 0);

        if ($name === '') {
            Session::setFlash('error', 'El nombre del tema es obligatorio.');
            return null;
        }

        if (!in_array($palette, ['yellow', 'purple', 'blue'], true)) {
            Session::setFlash('error', 'Debes elegir una paleta válida (amarillo, morado o azul).');
            return null;
        }

        if (!$startDate || !$endDate) {
            Session::setFlash('error', 'Las fechas de inicio y fin son obligatorias.');
            return null;
        }

        if ($endDate < $startDate) {
            Session::setFlash('error', 'La fecha de fin no puede ser anterior a la de inicio.');
            return null;
        }

        return [
            'name'       => $name,
            'palette'    => $palette,
            'start_date' => $startDate,
            'end_date'   => $endDate,
            'is_active'  => $isActive,
            'sort_order' => $sortOrder,
        ];
    }
}
