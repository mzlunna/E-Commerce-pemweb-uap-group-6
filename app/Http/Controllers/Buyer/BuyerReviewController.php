<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class BuyerReviewController extends Controller
{
    public function create($transactionId)
    {
        $buyer = auth()->user()->buyer;
        
        $transaction = Transaction::with(['transactionDetails.product.images'])
            ->where('buyer_id', $buyer->id)
            ->where('payment_status', 'completed')
            ->findOrFail($transactionId);

        // Get existing reviews
        $existingReviews = ProductReview::where('transaction_id', $transactionId)->get();

        return view('buyer.reviews.create', compact('transaction', 'existingReviews'));
    }

    public function store(Request $request, $transactionId)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|min:10|max:1000',
        ]);

        $buyer = auth()->user()->buyer;
        
        $transaction = Transaction::where('buyer_id', $buyer->id)
            ->where('payment_status', 'completed')
            ->findOrFail($transactionId);

        // Check if product is in this transaction
        $productExists = $transaction->transactionDetails()
            ->where('product_id', $request->product_id)
            ->exists();

        if (!$productExists) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan dalam pesanan ini'
            ], 400);
        }

        // Create or update review
        $review = ProductReview::updateOrCreate(
            [
                'transaction_id' => $transactionId,
                'product_id' => $request->product_id,
            ],
            [
                'rating' => $request->rating,
                'review' => $request->review,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Review berhasil disimpan'
        ]);
    }

    public function destroy($reviewId)
    {
        $buyer = auth()->user()->buyer;
        
        $review = ProductReview::whereHas('transaction', function ($query) use ($buyer) {
            $query->where('buyer_id', $buyer->id);
        })->findOrFail($reviewId);

        $review->delete();

        return response()->json([
            'success' => true,
            'message' => 'Review berhasil dihapus'
        ]);
    }

    public function productReviews($productId)
    {
        $product = \App\Models\Product::with(['images', 'category'])
            ->findOrFail($productId);

        $reviews = ProductReview::with(['transaction.buyer.user'])
            ->where('product_id', $productId)
            ->latest()
            ->paginate(10);

        return view('buyer.reviews.product-reviews', compact('product', 'reviews'));
    }
}