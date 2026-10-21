<?php
// ========================================================
// HomeController - Florería Tulisol
// ========================================================

class HomeController extends Controller {
    public function index(): void {
        $categoryModel = new Category();
        $productModel  = new Product();

        $categories = $categoryModel->getActive();

        // Si hay un tema de color activo, los productos de ese color van primero
        if (!empty($this->activeTheme)) {
            $featuredProducts = $productModel->getFeaturedByTheme($this->activeTheme['palette'], 8);
            $bestSellers = $productModel->getBestSellersByTheme($this->activeTheme['palette'], 4);
        } else {
            $featuredProducts = $productModel->getFeatured(8);
            $bestSellers = $productModel->getBestSellers(4);
        }

        $this->render('home.index', [
            'pageTitle'        => 'Florería Tulisol | Arreglos Florales y Envíos Exclusivos',
            'categories'       => $categories,
            'featuredProducts' => $featuredProducts,
            'bestSellers'      => $bestSellers
        ]);
    }
}
