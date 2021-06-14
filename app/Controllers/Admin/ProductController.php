<?php

namespace App\Controllers\Admin;

use App\Models\Category;
use App\Models\Product;
use Core\View;

class ProductController
{
    public function index()
    {
        $products = Product::all();

        View::render('admin/product/index', [
            'products' => $products,
        ]);
    }

    public function edit(int $id)
    {
        $product = Product::find($id);
        $categories = Category::all();

        View::render('admin/product/edit', [
            'product' => $product,
            'categories' => $categories,
        ]);
    }

}
