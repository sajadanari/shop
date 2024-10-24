<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $req){
        $page_size = $req->query('page_size') ? $req->query('page_size') : 12;
        $products = Product::orderBy('created_at', 'DESC')->paginate($page_size);
        return view('home.shop.index', compact('products'));
    }

    public function product_details($prod_slug){
        $product = Product::where('slug', $prod_slug)->first();
        $related_products = Product::where('slug', '<>', $prod_slug)->get()->take(8);
        return view('home.shop.product_details', compact('product', 'related_products'));
    }
}
