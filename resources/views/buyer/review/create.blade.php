@extends('layouts.buyer')

@section('title', 'Beri Rating & Review - ELSHOP')

@section('content')
<div class="section">
    <div class="section-header">
        <h2 class="section-title">Beri Rating & Review</h2>
    </div>

    <div style="max-width: 900px; margin: 0 auto;">
        <div style="background: white; border-radius: 12px; padding: 24px; margin-bottom: 24px; box-shadow: var(--shadow); border: 1px solid var(--accent-light);">
            <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 16px;">
                <div style="font-size: 1.5rem;">✓</div>
                <div>
                    <h3 style="font-weight: 600; color: var(--gray-800); margin-bottom: 4px;">
                        Pesanan Selesai
                    </h3>
                    <p style="color: var(--gray-600); font-size: 0.875rem;">
                        Order #{{ $transaction->code }} - {{ $transaction->created_at->format('d M Y') }}
                    </p>
                </div>
            </div>
        </div>

        <div style="background: white; border-radius: 12px; padding: 24px; margin-bottom: 24px; box-shadow: var(--shadow); border: 1px solid var(--accent-light);">
            <h3 style="font-size: 1.125rem; font-weight: 700; color: var(--gray-800); margin-bottom: 24px;">
                Berikan Rating untuk Setiap Produk
            </h3>

            @if($transaction->transactionDetails && $transaction->transactionDetails->count() > 0)
                @foreach($transaction->transactionDetails as $detail)
                    @php
                        $existingReview = $existingReviews->where('product_id', $detail->product_id)->first();
                    @endphp
                    <div style="padding: 20px; margin-bottom: 20px; background: var(--gray-50); border-radius: 12px; border: 1px solid var(--accent-light);">
                        <div style="display: flex; gap: 16px; margin-bottom: 20px;">
                            @if($detail->product->images && $detail->product->images->count() > 0)
                                <img src="{{ asset('storage/' . $detail->product->images->first()->image_url) }}" 
                                     alt="{{ $detail->product->name }}"
                                     style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; flex-shrink: 0;">
                            @else
                                <div style="width: 80px; height: 80px; background: var(--gray-100); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--gray-400); flex-shrink: 0;">?</div>
                            @endif
                            
                            <div style="flex: 1;">
                                <h4 style="font-weight: 600; margin-bottom: 4px; color: var(--gray-800);">
                                    {{ $detail->product->name }}
                                </h4>
                                <p style="font-size: 0.875rem; color: var(--gray-600); margin-bottom: 8px;">
                                    Jumlah: {{ $detail->qty }}x
                                </p>
                                <p style="font-size: 0.875rem; color: var(--gray-600);">
                                    Harga: Rp {{ number_format($detail->product->price, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        <form class="review-form" data-product-id="{{ $detail->product_id }}" data-transaction-id="{{ $transaction->id }}">
                            @csrf

                            <div style="margin-bottom: 16px;">
                                <label style="display: block; font-weight: 600; margin-bottom: 12px; color: var(--gray-700); font-size: 0.938rem;">
                                    Rating <span style="color: var(--danger);">*</span>
                                </label>
                                <div class="star-rating" style="display: flex; gap: 8px; margin-bottom: 8px;">
                                    @for($i = 1; $i <= 5; $i++)
                                        <input type="radio" name="rating" value="{{ $i }}" id="rating-{{ $detail->product_id }}-{{ $i }}" 
                                               style="display: none;"
                                               {{ $existingReview && $existingReview->rating == $i ? 'checked' : '' }}>
                                        <label for="rating-{{ $detail->product_id }}-{{ $i }}" 
                                               class="star-btn"
                                               style="font-size: 2rem; cursor: pointer; user-select: none; color: var(--gray-300); transition: all 0.2s;">
                                            ★
                                        </label>
                                    @endfor
                                </div>
                                <span class="rating-text" style="font-size: 0.813rem; color: var(--gray-500);">
                                    {{ $existingReview ? 'Rating: ' . $existingReview->rating . ' bintang' : 'Pilih rating' }}
                                </span>
                            </div>

                            <div style="margin-bottom: 16px;">
                                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--gray-700); font-size: 0.938rem;">
                                    Review <span style="color: var(--danger);">*</span>
                                </label>
                                <textarea name="review" rows="3" 
                                          placeholder="Bagaimana kualitas produk ini? Apakah sesuai dengan deskripsi?"
                                          style="width: 100%; padding: 12px 16px; border: 1px solid var(--accent-light); border-radius: 8px; font-size: 0.938rem; font-family: inherit; resize: vertical; min-height: 80px;"
                                          required>{{ $existingReview?->review }}</textarea>
                                <p style="font-size: 0.813rem; color: var(--gray-500); margin-top: 4px;">
                                    Minimal 10 karakter, maksimal 1000 karakter
                                </p>
                            </div>

                            <button type="submit" class="submit-review-btn" 
                                    style="background: var(--accent); color: white; border: none; padding: 10px 24px; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 0.938rem; transition: all 0.2s;">
                                {{ $existingReview ? 'Perbarui Review' : 'Kirim Review' }}
                            </button>
                        </form>
                    </div>
                @endforeach
            @endif
        </div>

        <a href="{{ route('buyer.orders.show', $transaction->id) }}" 
           style="display: inline-block; padding: 12px 24px; background: white; color: var(--gray-700); border: 2px solid var(--accent-light); border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 0.2s;">
            ← Kembali ke Detail Pesanan
        </a>
    </div>
</div>

<style>
.star-btn {
    transition: all 0.2s;
}

.star-btn:hover {
    transform: scale(1.3);
    color: var(--warning);
}

input[type="radio"]:checked + .star-btn {
    color: var(--warning);
}

.submit-review-btn:hover {
    background: var(--primary) !important;
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}
</style>

<script>
document.querySelectorAll('.review-form').forEach(form => {
    const productId = form.dataset.productId;
    const transactionId = form.dataset.transactionId;
    const ratingInputs = form.querySelectorAll('input[name="rating"]');
    const ratingText = form.querySelector('.rating-text');

    ratingInputs.forEach(input => {
        input.addEventListener('change', function() {
            ratingText.textContent = `Rating: ${this.value} bintang`;
        });
    });

    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        const rating = form.querySelector('input[name="rating"]:checked')?.value;
        const review = form.querySelector('textarea[name="review"]').value;
        const submitBtn = form.querySelector('.submit-review-btn');

        if (!rating) {
            alert('Pilih rating terlebih dahulu');
            return;
        }

        if (!review || review.trim().length < 10) {
            alert('Review minimal 10 karakter');
            return;
        }

        if (review.length > 1000) {
            alert('Review maksimal 1000 karakter');
            return;
        }

        submitBtn.disabled = true;
        submitBtn.textContent = 'Mengirim...';

        try {
            const response = await fetch(`/buyer/review/${transactionId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify({
                    product_id: productId,
                    rating: rating,
                    review: review
                })
            });

            const data = await response.json();

            if (data.success) {
                alert(data.message);
                submitBtn.textContent = 'Perbarui Review';
            } else {
                alert(data.message || 'Gagal mengirim review');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan');
        } finally {
            submitBtn.disabled = false;
        }
    });
});
</script>
@endsection