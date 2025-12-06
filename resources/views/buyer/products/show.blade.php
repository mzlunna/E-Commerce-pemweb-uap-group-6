@extends('layouts.buyer')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-6">
            @if($product->images && $product->images->count() > 0)
                <img src="{{ asset('storage/' . $product->images->first()->image_url) }}" 
                     alt="{{ $product->name }}" class="img-fluid rounded shadow">
            @else
                <img src="https://via.placeholder.com/500x500?text=No+Image" 
                     alt="No Image" class="img-fluid rounded shadow">
            @endif
        </div>
        
        <div class="col-md-6">
            <h2>{{ $product->name }}</h2>
            
            <div class="mb-3">
                @foreach($product->categories as $category)
                    <span class="badge bg-primary">{{ $category->name }}</span>
                @endforeach
            </div>
            
            <h3 class="text-primary mb-3">Rp {{ number_format($product->price, 0, ',', '.') }}</h3>
            
            <div class="mb-3">
                <p><strong>Stok:</strong> {{ $product->stock }} tersedia</p>
                <p><strong>Toko:</strong> <a href="#">{{ $product->store->name }}</a></p>
            </div>
            
            <div class="mb-4">
                <h5>Deskripsi</h5>
                <p>{{ $product->description }}</p>
            </div>
            
            <form action="{{ route('buyer.cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                
                <div class="mb-3">
                    <label class="form-label">Jumlah</label>
                    <input type="number" name="qty" value="1" min="1" max="{{ $product->stock }}" 
                           class="form-control" style="width: 100px;">
                </div>
                
                <button type="submit" class="btn btn-primary btn-lg w-100">
                    <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                </button>
            </form>
        </div>
    </div>
    
    @if($relatedProducts && $relatedProducts->count() > 0)
        <div class="row mt-5">
            <div class="col-12">
                <h4>Produk Lainnya dari Toko Ini</h4>
            </div>
            @foreach($relatedProducts as $related)
                <div class="col-md-3 mb-4">
                    <div class="card">
                        @if($related->images && $related->images->count() > 0)
                            <img src="{{ asset('storage/' . $related->images->first()->image_url) }}" 
                                 class="card-img-top" style="height: 200px; object-fit: cover;">
                        @else
                            <img src="https://via.placeholder.com/300x200" class="card-img-top">
                        @endif
                        <div class="card-body">
                            <h6>{{ Str::limit($related->name, 30) }}</h6>
                            <p class="text-primary fw-bold">Rp {{ number_format($related->price, 0, ',', '.') }}</p>
                            <a href="{{ route('buyer.products.show', $related->id) }}" 
                               class="btn btn-outline-primary btn-sm w-100">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection