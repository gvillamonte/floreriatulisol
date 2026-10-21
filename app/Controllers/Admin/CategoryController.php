<?php
// ========================================================
// CategoryController - Gestión de Categorías en el CMS
// Florería Tulisol
// ========================================================

class CategoryController extends Controller {
    public function index(): void {
        $categoryModel = new Category();
        $categories = $categoryModel->getAllWithCount();

        $this->renderAdmin('admin.categories.index', [
            'pageTitle'  => 'Categorías de Arreglos | Florería Tulisol CMS',
            'categories' => $categories
        ]);
    }

    public function store(): void {
        $name        = trim($this->getPost('name', ''));
        $description = trim($this->getPost('description', ''));
        $icon        = trim($this->getPost('icon', 'sparkles'));
        $sortOrder   = (int)$this->getPost('sort_order', 0);
        $isActive    = isset($_POST['is_active']) ? 1 : 0;

        if (empty($name)) {
            Session::setFlash('error', 'El nombre de la categoría es obligatorio.');
            $this->redirect('admin/categorias');
            return;
        }

        $imagePath = null;
        if (!empty($_FILES['image']['tmp_name'])) {
            $uploadResult = ImageOptimizer::processUpload($_FILES['image'], 'categories', 800, 82);
            if ($uploadResult['success']) {
                $imagePath = $uploadResult['path'];
            }
        }

        $categoryModel = new Category();
        $slug = $categoryModel->generateSlug($name);

        $categoryModel->create([
            'name'        => $name,
            'slug'        => $slug,
            'description' => $description,
            'image'       => $imagePath,
            'icon'        => $icon,
            'sort_order'  => $sortOrder,
            'is_active'   => $isActive
        ]);

        Session::setFlash('success', "Categoría '{$name}' creada exitosamente.");
        $this->redirect('admin/categorias');
    }

    public function update(string $id): void {
        $categoryModel = new Category();
        $category = $categoryModel->find((int)$id);

        if (!$category) {
            Session::setFlash('error', 'Categoría no encontrada.');
            $this->redirect('admin/categorias');
            return;
        }

        $name        = trim($this->getPost('name', ''));
        $description = trim($this->getPost('description', ''));
        $icon        = trim($this->getPost('icon', 'sparkles'));
        $sortOrder   = (int)$this->getPost('sort_order', 0);
        $isActive    = isset($_POST['is_active']) ? 1 : 0;

        if (empty($name)) {
            Session::setFlash('error', 'El nombre de la categoría es requerido.');
            $this->redirect('admin/categorias');
            return;
        }

        $updateData = [
            'name'        => $name,
            'description' => $description,
            'icon'        => $icon,
            'sort_order'  => $sortOrder,
            'is_active'   => $isActive
        ];

        if ($name !== $category['name']) {
            $updateData['slug'] = $categoryModel->generateSlug($name, (int)$id);
        }

        if (!empty($_FILES['image']['tmp_name'])) {
            $uploadResult = ImageOptimizer::processUpload($_FILES['image'], 'categories', 800, 82);
            if ($uploadResult['success']) {
                ImageOptimizer::deletePrevious($category['image']);
                $updateData['image'] = $uploadResult['path'];
            }
        }

        $categoryModel->update((int)$id, $updateData);
        Session::setFlash('success', "Categoría '{$name}' actualizada correctamente.");
        $this->redirect('admin/categorias');
    }

    public function delete(string $id): void {
        $categoryModel = new Category();
        $category = $categoryModel->find((int)$id);

        if ($category) {
            ImageOptimizer::deletePrevious($category['image']);
            $categoryModel->delete((int)$id);
            Session::setFlash('success', "Categoría '{$category['name']}' eliminada.");
        }

        $this->redirect('admin/categorias');
    }

    /**
     * Sube o baja una categoría en el orden de aparición.
     */
    public function reorder(string $id): void {
        $direction = $this->getPost('direction', 'up') === 'down' ? 'down' : 'up';
        $categoryModel = new Category();
        $category = $categoryModel->find((int)$id);

        if (!$category) {
            Session::setFlash('error', 'Categoría no encontrada.');
            $this->redirect('admin/categorias');
            return;
        }

        $all = $categoryModel->all('sort_order ASC, id ASC');
        $index = null;
        foreach ($all as $i => $c) {
            if ((int)$c['id'] === (int)$id) {
                $index = $i;
                break;
            }
        }

        if ($index === null) {
            $this->redirect('admin/categorias');
            return;
        }

        $swapIndex = $direction === 'up' ? $index - 1 : $index + 1;
        if ($swapIndex < 0 || $swapIndex >= count($all)) {
            Session::setFlash('error', 'La categoría ya está en el extremo del orden.');
            $this->redirect('admin/categorias');
            return;
        }

        $other = $all[$swapIndex];
        $soA = (int)$category['sort_order'];
        $soB = (int)$other['sort_order'];

        // Si tienen el mismo orden, asignamos valores basados en posición
        if ($soA === $soB) {
            $soA = ($index + 1) * 10;
            $soB = ($swapIndex + 1) * 10;
        }

        $categoryModel->update((int)$category['id'], ['sort_order' => $soB]);
        $categoryModel->update((int)$other['id'], ['sort_order' => $soA]);

        $dirLabel = $direction === 'up' ? 'hacia arriba' : 'hacia abajo';
        Session::setFlash('success', "'{$category['name']}' movida {$dirLabel}.");
        $this->redirect('admin/categorias');
    }
}
