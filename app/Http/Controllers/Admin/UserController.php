<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class UserController extends Controller
{
    /**
     * Menampilkan daftar semua pengguna.
     */
    public function index()
    {
        $users = User::latest()->get(); // Mengambil data terbaru
        return view('admin.users.index', compact('users'));
    }

    /**
     * Menampilkan form untuk membuat pengguna baru.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Menyimpan pengguna baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi untuk semua field yang dibutuhkan saat membuat user baru
        $validatedData = $request->validate([
            'longname' => 'required|string|max:255',
            'name' => 'required|string|max:255|unique:users,name',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'required|string|max:20',
            'bank_name' => 'required|string|max:255',
            'bank_account_number' => 'required|numeric',
            'bank_account_name' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Tambahkan password yang sudah di-hash ke data yang divalidasi
        $validatedData['password'] = Hash::make($request->password);

        // Buat user baru
        User::create($validatedData);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('admin.users.index')->with('success', 'Pengguna baru berhasil dibuat.');
    }

    /**
     * Menampilkan form untuk mengedit data pengguna.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Memperbarui data pengguna di database.
     */
    public function update(Request $request, User $user)
    {
        // Validasi input, termasuk field bank
        $validatedData = $request->validate([
            'longname' => 'required|string|max:255',
            'name' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => 'required|string|max:20',
            'bank_name' => 'required|string|max:255',
            'bank_account_number' => 'required|numeric',
            'bank_account_name' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed', // Password opsional saat update
        ]);

        // Cek jika password diisi, jika ya maka hash password baru
        if (!empty($request->password)) {
            $validatedData['password'] = Hash::make($request->password);
        } else {
            // Jika tidak, hapus dari array agar tidak mengupdate password menjadi kosong
            unset($validatedData['password']);
        }

        // Update data user
        $user->update($validatedData);

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('admin.users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Menghapus pengguna dari database.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
    public function export(Request $request)
    {
        $format = $request->query('format');

        if ($format === 'excel') {
            // Gunakan ekstensi .xlsx yang valid
            $filename = 'data-pengguna-' . date('Y-m-d') . '.xlsx';
            return Excel::download(new UsersExport(), $filename);
        }

        if ($format === 'pdf') {
            $filename = 'data-pengguna-' . date('Y-m-d') . '.pdf';
            $users = User::with(['rank', 'parent'])->get();
            $pdf = Pdf::loadView('admin.users.pdf', ['users' => $users]);
            return $pdf->download($filename);
        }

        return redirect()->back()->with('error', 'Format ekspor tidak valid.');
    }
}
