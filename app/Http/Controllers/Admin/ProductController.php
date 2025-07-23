<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Menampilkan daftar semua pengguna.
     */
    public function index()
    {
        $products = Product::latest()->get(); // Mengambil data terbaru
        return view('admin.product.index', compact('products'));
    }

    /**
     * Menampilkan form untuk membuat pengguna baru.
     */
    public function create()
    {
        return view('admin.product.create');
    }

    /**
     * Menyimpan pengguna baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'base_price' => 'required|integer',
            'description' => 'required|string',
        ]);
        Product::create($validatedData);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('admin.product.index')->with('success', 'Pengguna baru berhasil dibuat.');
    }

    /**
     * Menampilkan form untuk mengedit data pengguna.
     */
    public function edit(Product $product)
    {
        return view('admin.product.edit', compact('product'));
    }

    /**
     * Memperbarui data pengguna di database.
     */
    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name' => 'required|string' . $product->id,
            'base_price' => 'required|integer',
            'description' => 'required|string',
        ]);

        $product->update($validatedData);

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('admin.product.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Menghapus pengguna dari database.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.product.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
