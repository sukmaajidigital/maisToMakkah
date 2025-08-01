<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Ambil semua user dengan relasi yang dibutuhkan
        return User::with(['rank', 'parent'])->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nama Lengkap',
            'Username',
            'Email',
            'No. HP',
            'Peringkat',
            'Upline',
            'Saldo Bonus',
            'Nama Bank',
            'No. Rekening',
            'Nama Pemilik Rekening',
            'Tanggal Bergabung',
        ];
    }

    /**
     * @param mixed $user
     * @return array
     */
    public function map($user): array
    {
        return [
            $user->id,
            $user->longname,
            $user->name,
            $user->email,
            $user->phone,
            $user->rank->name ?? 'N/A',
            $user->parent->longname ?? '-',
            $user->bonus_balance,
            $user->bank_name,
            $user->bank_account_number,
            $user->bank_account_name,
            $user->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
