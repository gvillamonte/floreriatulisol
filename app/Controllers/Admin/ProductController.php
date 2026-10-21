<?php
// ========================================================
// ProductController - Gestión de Productos en el CMS
// Florería Tulisol
// ========================================================

class ProductController extends Controller {
    public function index(): void {
        $productModel = new Product();
        $products = $productModel->getAllWithCategory();

        $this->renderAdmin('admin.products.index', [
            'pageTitle' => 'Gestión de Ramos y Productos | Florería Tulisol CMS',
            'products'  => $products
        ]);
    }

    public function create(): void {
        $categoryModel = new Category();
        $categories = $categoryModel->all('sort_order ASC, name ASC');

        $this->renderAdmin('admin.products.create', [
            'pageTitle'  => 'Crear Nuevo Arreglo Floral | Florería Tulisol CMS',
            'categories' => $categories
        ]);
    }

    public function store(): void {
        $name             = trim($this->getPost('name', ''));
        $categoryId       = (int)$this->getPost('category_id', 0) ?: null;
        $price            = (float)$this->getPost('price', 0);
        $salePrice        = $this->getPost('sale_price') !== '' ? (float)$this->getPost('sale_price') : null;
        $stock            = (int)$this->getPost('stock', 20);
        $shortDescription = trim($this->getPost('short_description', ''));
        $description      = trim($this->getPost('description', ''));
        $flowersIncluded  = trim($this->getPost('flowers_included', ''));
        $careTips         = trim($this->getPost('care_tips', ''));
        $isFeatured       = isset($_POST['is_featured']) ? 1 : 0;
        $isBestSeller     = isset($_POST['is_best_seller']) ? 1 : 0;
        $colorTheme       = in_array($this->getPost('color_theme', 'none'), ['none', 'yellow', 'purple', 'blue'], true) ? $this->getPost('color_theme') : 'none';
        $isActive         = isset($_POST['is_active']) ? 1 : 0;

        if (empty($name) || $price <= 0) {
            Session::setFlash('error', 'El nombre del arreglo floral y el precio son obligatorios.');
            $this->redirect('admin/productos/crear');
            return;
        }

        // Procesar subida de imagen con optimización estricta a WebP
        if (empty($_FILES['main_image']['tmp_name'])) {
            Session::setFlash('error', 'Debes subir una imagen para el arreglo floral.');
            $this->redirect('admin/productos/crear');
            return;
        }

        $uploadResult = ImageOptimizer::processUpload($_FILES['main_image'], 'products', 1200, 84);
        if (!$uploadResult['success']) {
            Session::setFlash('error', 'Error en la imagen: ' . $uploadResult['error']);
            $this->redirect('admin/productos/crear');
            return;
        }

        $productModel = new Product();
        $slug = $productModel->generateSlug($name);

        $productId = $productModel->create([
            'category_id'       => $categoryId,
            'name'              => $name,
            'slug'              => $slug,
            'price'             => $price,
            'sale_price'        => $salePrice,
            'stock'             => $stock,
            'short_description' => $shortDescription,
            'description'       => $description,
            'flowers_included'  => $flowersIncluded,
            'care_tips'         => $careTips,
            'main_image'        => $uploadResult['path'],
            'is_featured'       => $isFeatured,
            'is_best_seller'    => $isBestSeller,
            'color_theme'       => $colorTheme,
            'is_active'         => $isActive
        ]);

        if ($productId) {
            Session::setFlash('success', "¡Arreglo floral '{$name}' creado con éxito y optimizado en WebP ({$uploadResult['size_kb']} KB)!");
            $this->redirect('admin/productos');
        } else {
            Session::setFlash('error', 'Error al guardar el producto en la base de datos.');
            $this->redirect('admin/productos/crear');
        }
    }

    public function edit(string $id): void {
        $productModel = new Product();
        $product = $productModel->find((int)$id);

        if (!$product) {
            Session::setFlash('error', 'Producto no encontrado.');
            $this->redirect('admin/productos');
            return;
        }

        $categoryModel = new Category();
        $categories = $categoryModel->all('sort_order ASC, name ASC');

        $this->renderAdmin('admin.products.edit', [
            'pageTitle'  => 'Editar: ' . $product['name'] . ' | Florería Tulisol CMS',
            'product'    => $product,
            'categories' => $categories
        ]);
    }

    public function update(string $id): void {
        $productModel = new Product();
        $product = $productModel->find((int)$id);

        if (!$product) {
            Session::setFlash('error', 'Producto no encontrado.');
            $this->redirect('admin/productos');
            return;
        }

        $name             = trim($this->getPost('name', ''));
        $categoryId       = (int)$this->getPost('category_id', 0) ?: null;
        $price            = (float)$this->getPost('price', 0);
        $salePrice        = $this->getPost('sale_price') !== '' ? (float)$this->getPost('sale_price') : null;
        $stock            = (int)$this->getPost('stock', 20);
        $shortDescription = trim($this->getPost('short_description', ''));
        $description      = trim($this->getPost('description', ''));
        $flowersIncluded  = trim($this->getPost('flowers_included', ''));
        $careTips         = trim($this->getPost('care_tips', ''));
        $isFeatured       = isset($_POST['is_featured']) ? 1 : 0;
        $isBestSeller     = isset($_POST['is_best_seller']) ? 1 : 0;
        $colorTheme       = in_array($this->getPost('color_theme', 'none'), ['none', 'yellow', 'purple', 'blue'], true) ? $this->getPost('color_theme') : 'none';
        $isActive         = isset($_POST['is_active']) ? 1 : 0;

        if (empty($name) || $price <= 0) {
            Session::setFlash('error', 'El nombre y el precio son obligatorios.');
            $this->redirect("admin/productos/editar/{$id}");
            return;
        }

        $updateData = [
            'category_id'       => $categoryId,
            'name'              => $name,
            'price'             => $price,
            'sale_price'        => $salePrice,
            'stock'             => $stock,
            'short_description' => $shortDescription,
            'description'       => $description,
            'flowers_included'  => $flowersIncluded,
            'care_tips'         => $careTips,
            'is_featured'       => $isFeatured,
            'is_best_seller'    => $isBestSeller,
            'color_theme'       => $colorTheme,
            'is_active'         => $isActive
        ];

        // Regenerar slug si cambió el nombre
        if ($name !== $product['name']) {
            $updateData['slug'] = $productModel->generateSlug($name, (int)$id);
        }

        // Si se subió nueva imagen
        if (!empty($_FILES['main_image']['tmp_name'])) {
            $uploadResult = ImageOptimizer::processUpload($_FILES['main_image'], 'products', 1200, 84);
            if (!$uploadResult['success']) {
                Session::setFlash('error', 'Error en la imagen: ' . $uploadResult['error']);
                $this->redirect("admin/productos/editar/{$id}");
                return;
            }
            // Eliminar imagen anterior
            ImageOptimizer::deletePrevious($product['main_image']);
            $updateData['main_image'] = $uploadResult['path'];
        }

        $productModel->update((int)$id, $updateData);
        Session::setFlash('success', "¡Arreglo floral '{$name}' actualizado correctamente!");
        $this->redirect('admin/productos');
    }

    public function delete(string $id): void {
        $productModel = new Product();
        $product = $productModel->find((int)$id);

        if ($product) {
            ImageOptimizer::deletePrevious($product['main_image']);
            $productModel->delete((int)$id);
            Session::setFlash('success', "El arreglo '{$product['name']}' fue eliminado.");
        }

        $this->redirect('admin/productos');
    }

    public function toggle(string $id): void {
        $productModel = new Product();
        $product = $productModel->find((int)$id);

        if ($product) {
            $newStatus = $product['is_active'] ? 0 : 1;
            $productModel->update((int)$id, ['is_active' => $newStatus]);
            Session::setFlash('success', 'Estado del arreglo actualizado.');
        }

        $this->redirect('admin/productos');
    }
}
