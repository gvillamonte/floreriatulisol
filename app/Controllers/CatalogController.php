<?php
// ========================================================
// CatalogController - Florería Tulisol
// ========================================================

class CatalogController extends Controller {
    public function index(): void {
        $categoryModel = new Category();
        $productModel  = new Product();

        $categories = $categoryModel->getActive();

        $categorySlug = $this->getQuery('categoria');
        $search = $this->getQuery('q');
        $sort = $this->getQuery('orden', 'default');
        $page = max(1, (int)$this->getQuery('pagina', 1));
        $limit = 12;
        $offset = ($page - 1) * $limit;

        $selectedCategory = null;
        $categoryId = null;
        if (!empty($categorySlug)) {
            $selectedCategory = $categoryModel->findBySlug($categorySlug);
            if ($selectedCategory) {
                $categoryId = $selectedCategory['id'];
            }
        }

        $themePalette = !empty($this->activeTheme) ? $this->activeTheme['palette'] : null;
        $result = $productModel->searchAndFilter($categoryId, $search, $sort, $limit, $offset, $themePalette);

        $this->render('catalog.index', [
            'pageTitle'        => $selectedCategory ? $selectedCategory['name'] . ' | Florería Tulisol' : 'Catálogo de Flores y Ramos | Florería Tulisol',
            'categories'       => $categories,
            'selectedCategory' => $selectedCategory,
            'products'         => $result['items'],
            'total'            => $result['total'],
            'pages'            => $result['pages'],
            'currentPage'      => $page,
            'currentSort'      => $sort,
            'searchQuery'      => $search
        ]);
    }

    public function detail(string $slug): void {
        $productModel = new Product();
        $product = $productModel->findBySlug($slug);

        if (!$product || !$product['is_active']) {
            $this->redirect('catalogo');
            return;
        }

        $relatedProducts = $productModel->getRelated((int)$product['id'], $product['category_id'] ? (int)$product['category_id'] : null, 4);

        $this->render('catalog.detail', [
            'pageTitle'       => $product['name'] . ' | Florería Tulisol',
            'product'         => $product,
            'relatedProducts' => $relatedProducts
        ]);
    }
}
