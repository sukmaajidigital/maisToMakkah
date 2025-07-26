<x-layouts>
    <x-slot:header>
        Order Produk
    </x-slot:header>

    {{-- Notifikasi untuk pesan sukses atau error --}}
    @if (session('success'))
        <div id="alert-success" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div class="ms-3 text-sm font-medium">{{ session('success') }}</div>
        </div>
    @endif
    @if (session('error'))
        <div id="alert-error" class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div class="ms-3 text-sm font-medium">{{ session('error') }}</div>
        </div>
    @endif

    {{-- Daftar Produk --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        {{-- Loop melalui data produk yang dikirim dari controller --}}
        @forelse ($productsForView as $item)
            @php
                // Ekstrak data produk dan harga dinamisnya
                $product = $item['product'];
                $price = $item['price'];
            @endphp
            <div class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 flex flex-col">
                <div class="p-5 flex-grow">
                    <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">{{ $product->name }}</h5>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">{{ $product->description }}</p>
                </div>
                <div class="px-5 pb-5">
                    <div class="flex items-center justify-between">
                        {{-- Tampilkan harga dinamis yang sudah dihitung --}}
                        <span class="text-2xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($price, 0, ',', '.') }}</span>

                        {{-- Form untuk membeli produk --}}
                        <form action="{{ route('order.store') }}" method="POST" onsubmit="return confirm('Anda yakin ingin membeli produk ini dengan harga yang tertera?')">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Beli Sekarang</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="lg:col-span-3 md:col-span-2 text-center py-10">
                <p class="text-gray-500 dark:text-gray-400">Saat ini tidak ada produk yang tersedia.</p>
            </div>
        @endforelse
    </div>
</x-layouts>
