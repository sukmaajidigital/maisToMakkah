<?php

namespace App\Exports;

use App\Models\Withdrawal;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class WithdrawalsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Ambil semua data penarikan yang statusnya 'pending'
        return Withdrawal::with('user')->where('status', 'pending')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID Penarikan',
            'Nama Pengguna',
            'Email Pengguna',
            'Jumlah Penarikan',
            'Status',
            'Tanggal Permintaan',
            'Nama Bank',
            'No. Rekening',
            'Nama Pemilik Rekening',
        ];
    }

    /**
     * @param mixed $withdrawal
     * @return array
     */
    public function map($withdrawal): array
    {
        return [
            $withdrawal->id,
            $withdrawal->user->longname,
            $withdrawal->user->email,
            $withdrawal->amount,
            ucfirst($withdrawal->status),
            $withdrawal->created_at->format('Y-m-d H:i:s'),
            $withdrawal->user->bank_name,
            $withdrawal->user->bank_account_number,
            $withdrawal->user->bank_account_name,
        ];
    }
}
