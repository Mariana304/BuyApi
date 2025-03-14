<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Purchase;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $purchases = Purchase::where('user_id', $user->id)->get();
        $products = Product::all(); // Obtenemos todos los productos disponibles

        return view('dashboard', compact('purchases', 'products')); // Pasamos los productos a la vista
    }
}