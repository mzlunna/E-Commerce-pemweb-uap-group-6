@extends('layouts.admin')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-[#d8e1e8] p-6">
    <div class="w-full max-w-xl bg-[#c6d3e3]/50 p-8 rounded-xl shadow-lg">
        <h2 class="text-3xl font-bold mb-6 text-[#304674] text-center">✏️ Edit Toko</h2>

        <form action="{{ route('stores.update', $store->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block mb-2 font-semibold text-[#304674]">Nama Toko:</label>
                <input type="text" name="name" value="{{ $store->name }}"
                       class="w-full px-4 py-2 rounded-lg border border-[#b2cbde] bg-[#d8e1e8] text-[#304674] focus:outline-none focus:ring-2 focus:ring-[#98bad5]">
            </div>

            <div>
                <label class="block mb-2 font-semibold text-[#304674]">Pemilik:</label>
                <input type="text" value="{{ $store->owner->name }}" disabled
                       class="w-full px-4 py-2 rounded-lg border border-[#b2cbde] bg-[#d8e1e8] text-[#304674] cursor-not-allowed">
            </div>

            <button type="submit"
                    class="w-full py-3 bg-[#98bad5] hover:bg-[#304674] text-white font-semibold rounded-lg transition">
                Update
            </button>
        </form>
    </div>
</div>
@endsection
