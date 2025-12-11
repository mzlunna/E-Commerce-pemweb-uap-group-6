@extends('layouts.buyer')

@section('title', $product->name . ' - Ulasan Produk - ELSHOP')

@section('content')
<div class="section">
    <div style="max-width: 900px; margin: 0 auto;">
        <div style="margin-bottom: 24px; font-size: 0.938rem;">
            <a href="{{ route('buyer.dashboard') }}" style="color: var(--accent); text-decoration: none;">Beranda</a>
            <span> / </span>
            <a href="{{ route('buyer.products.show', $product->id) }}" style="color: var(--accent); text-decoration: none;">{{ $product->name }}</a>
            <span> / </span>
            <span style="color: var(--gray-600);">Ulasan</span>
        </div>

        <div style="background: white; border-radius: 12px; padding: 24px; margin-bottom: 24px; box-shadow: var(--shadow); border: 1px solid var(--accent-light); display: flex; gap: 20px; align-items: start;">
            @if($product->images && $product->images->count() > 0)
                <img src="{{ $product->images->first()->image_url }}" 
                     alt="{{ $product->name }}"
                     style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px; flex-shrink: 0;">
            @else
                <div style="width: 100px; height: 100px; background: var(--gray-100); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--gray-400); flex-shrink: 0;">?</div>
            @endif
            
            <div style="flex: 1;">
                <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--gray-900); margin-bottom: 12px;">
                    {{ $product->name }}
                </h1>
                
                <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 12px;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <div style="font-size: 1.25rem; color: var(--warning);">★</div>
                        <span style="font-weight: 700; font-size: 1.25rem; color: var(--gray-800);">
                            {{ number_format($product->average_rating ?? 0, 1) }}
                        </span>
                    </div>
                    <span style="color: var(--gray-600);">|</span>
                    <span style="color: var(--gray-600);">
                        {{ $product->reviews_count ?? 0 }} ulasan
                    </span>
                </div>

                <div style="font-size: 0.938rem; color: var(--gray-600);">
                    Harga: <span style="font-weight: 700; color: var(--primary);">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                </div>
            </div>

            <a href="{{ route('buyer.products.show', $product->id) }}" 
               style="background: var(--accent); color: white; padding: 10px 24px; border-radius: 8px; text-decoration: none; font-weight: 600; white-space: nowrap; transition: all 0.2s;">
                Lihat Produk
            </a>
        </div>

        @if($reviews->count() > 0)
            <div style="background: white; border-radius: 12px; padding: 24px; box-shadow: var(--shadow); border: 1px solid var(--accent-light);">
                <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); margin-bottom: 24px;">
                    Ulasan Pembeli ({{ $product->reviews_count ?? 0 }})
                </h2>

                @foreach($reviews as $review)
                    <div style="padding: 20px; margin-bottom: 16px; background: var(--gray-50); border-radius: 12px; border: 1px solid var(--accent-light);">
                        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 12px;">
                            <div>
                                <div style="font-weight: 600; color: var(--gray-800); margin-bottom: 4px;">
                                    {{ $review->transaction?->buyer?->user?->name ?? 'Pembeli' }}
                                </div>
                                <div style="font-size: 0.813rem; color: var(--gray-500);">
                                    {{ $review->created_at->diffForHumans() }}
                                </div>
                            </div>

                            @if(auth()->user()->buyer->id === $review->transaction->buyer_id)
                                <button type="button" onclick="deleteReview({{ $review->id }})" 
                                        style="background: none; border: none; color: var(--gray-400); cursor: pointer; padding: 4px 8px; font-size: 1.125rem; transition: all 0.2s;">
                                    ×
                                </button>
                            @endif
                        </div>

                        <div style="display: flex; gap: 4px; margin-bottom: 12px;">
                            @for($i = 1; $i <= 5; $i++)
                                <span style="color: {{ $i <= $review->rating ? 'var(--warning)' : 'var(--gray-300)' }}; font-size: 1.125rem;">
                                    ★
                                </span>
                            @endfor
                        </div>

                        <p style="color: var(--gray-700); line-height: 1.6; margin-bottom: 12px;">
                            {{ $review->review }}
                        </p>

                        <div style="display: inline-block; background: var(--success)20; color: var(--success); padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">
                            ✓ Pembeli Terverifikasi
                        </div>
                    </div>
                @endforeach

                <div style="margin-top: 24px;">
                    {{ $reviews->links() }}
                </div>
            </div>
        @else
            <div style="background: white; border-radius: 12px; padding: 40px; box-shadow: var(--shadow); border: 1px solid var(--accent-light); text-align: center;">
                <div style="font-size: 3rem; margin-bottom: 16px;">💬</div>
                <h3 style="font-size: 1.125rem; font-weight: 700; color: var(--gray-800); margin-bottom: 8px;">
                    Belum Ada Ulasan
                </h3>
                <p style="color: var(--gray-600); margin-bottom: 24px;">
                    Jadilah yang pertama memberi ulasan untuk produk ini!
                </p>
                <a href="{{ route('buyer.orders.index') }}" 
                   style="display: inline-block; background: var(--accent); color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 0.2s;">
                    Pesan Sekarang
                </a>
            </div>
        @endif

        <div style="margin-top: 24px;">
            <a href="{{ route('buyer.products.show', $product->id) }}" 
               style="display: inline-block; padding: 12px 24px; background: white; color: var(--gray-700); border: 2px solid var(--accent-light); border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 0.2s;">
                ← Kembali ke Produk
            </a>
        </div>
    </div>
</div>

<script>
function deleteReview(reviewId) {
    if (!confirm('Hapus ulasan ini?')) {
        return;
    }

    fetch(`/buyer/review/${reviewId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            window.location.reload();
        } else {
            alert(data.message || 'Gagal menghapus ulasan');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan');
    });
}
</script>
@endsection