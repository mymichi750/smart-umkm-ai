<x-app-layout>

<x-slot name="header">

<div class="d-flex justify-content-between align-items-center">

<div>

<h2 class="fw-bold mb-1">
<i class="bi bi-cart-check text-primary me-2"></i>
Kasir Pintar
</h2>

<p class="text-muted mb-0">
Kelola transaksi UMKM lebih cepat dengan Smart UMKM AI.
</p>

</div>


<div class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">

<i class="bi bi-lightning-charge me-1"></i>
Point Of Sale

</div>


</div>

</x-slot>



<div class="container-fluid">


@include('partials.alerts')



<div class="row g-4">



<!-- PRODUK -->

<div class="col-xl-5">


<div class="card pos-card h-100">


<div class="card-header bg-white border-0 pt-4 px-4">


<div class="d-flex justify-content-between align-items-center">


<h5 class="fw-bold mb-0">

<i class="bi bi-box-seam text-primary me-2"></i>

Produk

</h5>


<span class="badge bg-success bg-opacity-10 text-success">

{{ count($products) }} Item

</span>


</div>



<div class="mt-3">

<div class="input-group">

<span class="input-group-text bg-light border-0">

<i class="bi bi-search"></i>

</span>


<input 
type="text"
id="searchProduct"
class="form-control bg-light border-0"
placeholder="Cari produk...">


</div>

</div>


</div>





<div class="card-body px-4">


<div class="row g-2 g-sm-3" id="productList">



@foreach($products as $product)


<div class="col-6 col-md-6 col-xl-6 product-item">

    <div class="product-card">

        <span class="stock-badge {{ $product->stock > 5 ? 'stock-good' : 'stock-low' }}">
            {{ $product->stock }} Stok
        </span>

        <div class="product-icon">
            <i class="bi bi-box-seam"></i>
        </div>

        <div>

            <div class="product-name">
                {{ $product->name }}
            </div>

            <div class="product-sku">
                SKU: {{ $product->sku }}
            </div>

            <div class="product-price">
                Rp {{ number_format($product->sell_price,0,',','.') }}
            </div>

        </div>

        <form action="{{ route('pos.cart.add') }}" method="POST">

    @csrf

    <input
        type="hidden"
        name="product_id"
        value="{{ $product->id }}">

    <input
        type="hidden"
        name="quantity"
        value="1">

    <button
        class="btn btn-primary btn-add-cart w-100">

        <i class="bi bi-cart-plus me-1"></i>
        Tambah

    </button>

</form>

    </div>

</div>


@endforeach



</div>


</div>


</div>


</div>







<!-- KERANJANG -->


<div class="col-xl-7">


<div class="card pos-card">


<div class="card-header bg-white border-0 pt-4 px-4">


<h5 class="fw-bold">

<i class="bi bi-basket text-success me-2"></i>

Keranjang Belanja

</h5>


</div>




<div class="card-body px-4">


<div class="table-responsive">


<table class="table align-middle">


<thead class="table-light">


<tr>

<th>Produk</th>

<th>Harga</th>

<th>Qty</th>

<th>Total</th>

<th></th>

</tr>


</thead>



<tbody>


@php $total=0; @endphp


@forelse($cart as $item)


@php $total += $item['subtotal']; @endphp


<tr>


<td class="fw-semibold">

{{ $item['name'] }}

</td>



<td>

Rp {{ number_format($item['price'],0,',','.') }}

</td>




<td>


<form action="{{ route('pos.cart.update',$item['id']) }}"
method="POST"
class="d-flex gap-2">

@csrf

@method('PATCH')


<input 
type="number"
name="quantity"
value="{{ $item['quantity'] }}"
min="1"
class="form-control form-control-sm"
style="width:70px">


<button class="btn btn-outline-primary btn-sm">

<i class="bi bi-arrow-repeat"></i>

</button>


</form>


</td>




<td class="fw-bold text-primary">

Rp {{ number_format($item['subtotal'],0,',','.') }}

</td>




<td>


<form action="{{ route('pos.cart.remove',$item['id']) }}"
method="POST">

@csrf

@method('DELETE')


<button class="btn btn-outline-danger btn-sm">

<i class="bi bi-trash"></i>

</button>


</form>


</td>


</tr>


@empty


<tr>

<td colspan="5"
class="text-center text-muted py-4">

Keranjang masih kosong

</td>

</tr>


@endforelse



</tbody>


</table>


</div>






<div class="total-box mt-4">


<span>Total Pembayaran</span>


<h2>

Rp {{ number_format($total,0,',','.') }}

</h2>


</div>






<form action="{{ route('pos.checkout') }}"
method="POST"
class="mt-4">

@csrf



<label class="form-label fw-semibold">

Pelanggan

</label>


<select name="customer_id"
class="form-select mb-3">


<option value="">
Umum
</option>


@foreach($customers as $customer)


<option value="{{ $customer->id }}">

{{ $customer->name }}

</option>


@endforeach


</select>





<label class="form-label fw-semibold">

Jumlah Uang

</label>


<input 
type="number"
name="paid"
class="form-control mb-3"
value="{{ old('paid',$total) }}">





<label class="form-label fw-semibold">

Catatan

</label>


<textarea 
name="notes"
class="form-control mb-3"></textarea>




<label class="form-label fw-semibold">

Kembalian

</label>


<input 
id="changeAmount"
class="form-control fw-bold mb-4"
readonly
value="Rp 0">



<button class="btn btn-success btn-lg w-100">

<i class="bi bi-check-circle me-2"></i>

Bayar Transaksi

</button>



</form>



</div>

</div>


</div>



</div>


</div>





@push('styles')

<style>


.pos-card{

border:0;

border-radius:22px;

box-shadow:0 15px 40px rgba(15,23,42,.08);

}




.product-card{

background:#fff;

border:1px solid #e2e8f0;

padding:18px;

border-radius:18px;

transition:.25s;

}



.product-card:hover{

transform:translateY(-5px);

box-shadow:0 10px 25px rgba(0,0,0,.08);

border-color:#2563eb;

}



.total-box{

background:linear-gradient(135deg,#2563eb,#06b6d4);

color:white;

padding:25px;

border-radius:20px;

}



.total-box h2{

font-weight:800;

margin:5px 0 0;

}

/* Responsif untuk kartu produk */
.product-card {
    display: flex;
    flex-direction: column;
    height: 100%;
}

.product-card .btn-add-cart {
    margin-top: auto;
}

@media (max-width: 575.98px) {
    .product-card {
        padding: 12px;
        border-radius: 14px;
    }
    .product-icon {
        font-size: 1.4rem;
    }
    .product-name {
        font-size: 0.85rem;
    }
    .product-sku {
        font-size: 0.7rem;
    }
    .product-price {
        font-size: 0.85rem;
    }
    .product-card .btn-add-cart {
        font-size: 0.8rem;
        padding: 0.4rem 0.5rem;
    }
}

</style>

@endpush





@push('scripts')


<script>


document.getElementById('searchProduct')
.addEventListener('keyup',function(){


let value=this.value.toLowerCase();


document.querySelectorAll('.product-item')
.forEach(function(item){


let name=item.querySelector('.product-name')
.innerText.toLowerCase();



item.style.display=
name.includes(value)
?'block'
:'none';


});


});





const totalAmount={{$total}};

const paid=document.querySelector('input[name="paid"]');

const change=document.getElementById('changeAmount');



paid.addEventListener('input',()=>{


let result=paid.value-totalAmount;


change.value=
'Rp '+Math.max(result,0)
.toLocaleString('id-ID');


});



</script>


@endpush



</x-app-layout>