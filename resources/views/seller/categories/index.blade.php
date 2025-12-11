@extends('layouts.seller')
@section('title','Categories')

@section('content')

<div class="page-header page-header-actions">
    <h1>Daftar Kategori</h1>
    <a href="{{ route('seller.categories.create') }}" class="btn btn-primary">Tambah Kategori</a>
</div>

<div class="card">
    <div class="card-body">

        @if($categories->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($categories as $c)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $c->name }}</td>
                    <td class="text-center">

                        <a href="{{ route('seller.categories.edit', $c->id) }}"
                           class="btn btn-secondary btn-sm">Edit</a>

                        <form action="{{ route('seller.categories.destroy', $c->id) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin mau hapus kategori?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-secondary btn-sm">Hapus</button>
                        </form>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @else
        <div class="empty-state">
            <div class="empty-icon">📁</div>
            <h3 class="empty-title">Belum ada kategori</h3>
        </div>
        @endif

    </div>
</div>

@endsection
