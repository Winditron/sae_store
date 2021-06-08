<?php

namespace App\Controllers;

use App\Models\Product;
use Core\Models\AbstractModel;
use Core\View;

class ProductController
{

    public function index()
    {

        $products = Product::all();

        View::render('product/index', [
            'products' => $products,
        ]);
    }

    public function show(string $slug)
    {
        $product = Product::findBySlug($slug);

        View::render('product/show', [
            'product' => AbstractModel::returnOrFail($product),
        ]);
    }
}
