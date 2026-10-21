<?php
// ========================================================
// DashboardController - CMS Florería Tulisol
// ========================================================

class DashboardController extends Controller {
    public function index(): void {
        $orderModel = new Order();
        $productModel = new Product();
        $categoryModel = new Category();

        $stats = $orderModel->getDashboardStats();
        $recentOrders = $orderModel->getRecentOrders(8);
        $totalCategories = $categoryModel->count();

        $this->renderAdmin('admin.dashboard.index', [
            'pageTitle'       => 'Panel de Control | Florería Tulisol CMS',
            'stats'           => $stats,
            'recentOrders'    => $recentOrders,
            'totalCategories' => $totalCategories
        ]);
    }
}
