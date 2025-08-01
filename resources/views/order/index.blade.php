<x-layouts>
    <x-slot:header>
        Order Produk
    </x-slot:header>

    {{-- Notifikasi --}}
    @if (session('success'))
        <div id="alert-success" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
            <div class="ms-3 text-sm font-medium">{{ session('success') }}</div>
        </div>
    @endif
    @if (session('error'))
        <div id="alert-error" class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
            <div class="ms-3 text-sm font-medium">{{ session('error') }}</div>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($products as $product)
            <div class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 flex flex-col">
                <div class="p-5 flex-grow">
                    <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">{{ $product->name }}</h5>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">{{ $product->description }}</p>
                </div>
                <div class="px-5 pb-5">
                    <div class="flex items-center justify-between">
                        <span class="text-2xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($product->base_price, 0, ',', '.') }}</span>

                        <form action="{{ route('order.store') }}" method="POST" onsubmit="return confirm('Anda yakin ingin membeli produk ini?')">
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
