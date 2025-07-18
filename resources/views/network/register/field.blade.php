<x-forms.text-input label="Full Name" name="full_name" id="full_name" placeholder="Masukkan nama lengkap" :value="old('full_name', $user->full_name ?? '')" :required="true" />

{{-- Email --}}
<x-forms.text-input type="email" label="Email" name="email" id="email" placeholder="contoh@email.com" :value="old('email', $user->email ?? '')" :required="true" />

{{-- Phone --}}
<x-forms.text-input type="tel" label="Phone" name="phone" id="phone" placeholder="081234567890" :value="old('phone', $user->phone ?? '')" :required="true" />

{{-- Username --}}
<x-forms.text-input label="Username" name="username" id="username" placeholder="Pilih username unik" :value="old('username', $user->username ?? '')" :required="true" />

<x-forms.text-input label="Nama Bank" name="bank_name" id="bank_name" placeholder="Contoh: BCA, Mandiri, dll." :value="old('bank_name', $user->bank_name ?? '')" :required="true" />

{{-- Nomor Rekening --}}
<x-forms.text-input type="number" label="Nomor Rekening" name="account_number" id="account_number" placeholder="Hanya angka" :value="old('account_number', $user->account_number ?? '')" :required="true" />

{{-- Nama di Bank --}}
<x-forms.text-input label="Nama di Bank" name="account_holder_name" id="account_holder_name" placeholder="Sesuai nama di buku tabungan" :value="old('account_holder_name', $user->account_holder_name ?? '')" :required="true" />

{{-- Password --}}
<x-forms.text-input type="password" label="Password" name="password" id="password" placeholder="Minimal 8 karakter" value="" {{-- Password tidak pernah diisi ulang --}} :required="!isset($user)" {{-- Wajib hanya saat create --}} />

{{-- Password Confirmation --}}
<x-forms.text-input type="password" label="Password Confirmation" name="password_confirmation" id="password_confirmation" placeholder="Ketik ulang password" value="" :required="!isset($user)" {{-- Wajib hanya saat create --}} />
