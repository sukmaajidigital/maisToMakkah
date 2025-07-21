<div>
    <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Informasi Akun</h2>
    <div class="grid gap-6 sm:grid-cols-2">
        {{-- Full Name --}}
        <div class="sm:col-span-2">
            <x-forms.text-input label="Full Name" name="longname" id="longname" placeholder="Masukkan nama lengkap" :value="old('longname', $user->longname ?? '')" :required="true" />
        </div>

        {{-- Username --}}
        <div>
            <x-forms.text-input label="Username" name="name" id="name" placeholder="Pilih username unik" :value="old('name', $user->name ?? '')" :required="true" />
        </div>

        {{-- Email --}}
        <div>
            <x-forms.text-input type="email" label="Email" name="email" id="email" placeholder="contoh@email.com" :value="old('email', $user->email ?? '')" :required="true" />
        </div>

        {{-- Phone --}}
        <div class="sm:col-span-2">
            <x-forms.text-input type="tel" label="Phone" name="phone" id="phone" placeholder="081234567890" :value="old('phone', $user->phone ?? '')" :required="true" />
        </div>
    </div>
</div>
<div>
    <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Informasi Bank</h2>
    <p class="mb-6 text-sm text-gray-500 dark:text-gray-400">
        Informasi ini akan digunakan untuk keperluan transaksi. Pastikan data yang Anda masukkan sudah benar.
    </p>
    <div class="grid gap-6 sm:grid-cols-2">
        {{-- Bank Name --}}
        <div>
            <x-forms.text-input label="Nama Bank" name="bank_name" id="bank_name" placeholder="Contoh: BCA, Mandiri, dll." :value="old('bank_name', $user->bank_name ?? '')" :required="true" />
        </div>

        {{-- Bank Account Number --}}
        <div>
            <x-forms.text-input type="number" label="Nomor Rekening" name="bank_account_number" id="bank_account_number" placeholder="Hanya angka" :value="old('bank_account_number', $user->bank_account_number ?? '')" :required="true" />
        </div>

        {{-- Bank Account Name --}}
        <div class="sm:col-span-2">
            <x-forms.text-input label="Nama di Bank" name="bank_account_name" id="bank_account_name" placeholder="Sesuai nama di buku tabungan" :value="old('bank_account_name', $user->bank_account_name ?? '')" :required="true" />
        </div>
    </div>
</div>
<div>
    <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Keamanan</h2>
    <p class="mb-6 text-sm text-gray-500 dark:text-gray-400">
        Isi bagian ini untuk membuat atau mengubah password. Kosongkan jika tidak ingin mengubah.
    </p>
    <div class="grid gap-6 sm:grid-cols-2">
        {{-- Password --}}
        <div>
            <x-forms.text-input type="password" label="Password" name="password" id="password" placeholder="Minimal 8 karakter" value="" {{-- Password tidak pernah diisi ulang --}} :required="!isset($user)" {{-- Wajib hanya saat create --}} />
        </div>

        {{-- Password Confirmation --}}
        <div>
            <x-forms.text-input type="password" label="Password Confirmation" name="password_confirmation" id="password_confirmation" placeholder="Ketik ulang password" value="" :required="!isset($user)" {{-- Wajib hanya saat create --}} />
        </div>
    </div>
</div>
