<x-forms.text-input label="Nama Produk" name="name" id="name" placeholder="Masukkan nama Produk" :value="old('name', $product->name ?? '')" :required="true" />
<x-forms.text-input label="Harga Dasar" name="base_price" id="base_price" placeholder="Masukkan Harga Produk Rp." :value="old('base_price', $product->base_price ?? '')" :required="true" type="number" />
<<x-forms.textarea-input label="description" readonly="" placeholder="Deskripsi Produk..." id="description" name="description" :required="true" :value="old('description', $product->description ?? '')" />
