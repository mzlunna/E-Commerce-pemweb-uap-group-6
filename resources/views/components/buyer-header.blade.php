<header class="buyer-header">
    {{-- Main Header - Logo, Search, Actions --}}
    <div class="header-main">
        <div class="header-main-content">
            {{-- Logo --}}
            <a href="{{ route('buyer.dashboard') }}" class="logo">
                <svg width="40" height="40" viewBox="0 0 40 40" fill="none">
                    <circle cx="20" cy="20" r="20" fill="url(#grad1)"/>
                    <path d="M12 16h16M12 20h16M12 24h10" stroke="white" stroke-width="2" stroke-linecap="round"/>
                    <defs>
                        <linearGradient id="grad1" x1="0" y1="0" x2="40" y2="40">
                            <stop offset="0%" style="stop-color:#304674"/>
                            <stop offset="100%" style="stop-color:#98bad5"/>
                        </linearGradient>
                    </defs>
                </svg>
                <span>ELSHOP</span>
            </a>

            {{-- Search Bar --}}
            <form action="{{ route('buyer.products.index') }}" method="GET" class="search-bar">
                <input 
                    type="text" 
                    name="search"
                    class="search-input" 
                    placeholder="Cari produk di ELSHOP..."
                    value="{{ request('search') }}"
                >
                <button type="submit" class="search-btn">
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
                    Cari
                </button>
            </form>

            {{-- Header Actions --}}
            <div class="header-actions">
                @auth
                    {{-- Keranjang --}}
                    <a href="{{ route('buyer.cart.index') }}" class="header-action">
                        <svg width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                        </svg>
                        @if(auth()->user()->cart_items_count > 0)
                            <span class="badge">{{ auth()->user()->cart_items_count }}</span>
                        @endif
                        <span class="action-label">Keranjang</span>
                    </a>
                    
                    {{-- Notifikasi --}}
                    <a href="#" class="header-action">
                        <svg width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zm.995-14.901a1 1 0 1 0-1.99 0A5.002 5.002 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901z"/>
                        </svg>
                        <span class="action-label">Notifikasi</span>
                    </a>
                    
                    {{-- User Profile Dropdown --}}
                    <div class="profile-dropdown">
                        <div class="profile-trigger">
                            <div class="dropdown-avatar" style="width: 32px; height: 32px; font-size: 0.938rem;">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <span class="profile-name">{{ Str::limit(auth()->user()->name, 10) }}</span>
                            <svg width="12" height="12" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                            </svg>
                        </div>
                        
                        {{-- Dropdown Menu --}}
                        <div class="dropdown-menu">
                            <div class="dropdown-header">
                                <div class="dropdown-avatar">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <div class="dropdown-info">
                                    <div class="dropdown-name">{{ auth()->user()->name }}</div>
                                    <div class="dropdown-email">{{ auth()->user()->email }}</div>
                                </div>
                            </div>
                            
                            <div class="dropdown-divider"></div>
                            
                            <a href="{{ route('buyer.profile.edit') }}" class="dropdown-item">
                                <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                                </svg>
                                <span>Akun Saya</span>
                            </a>
                            
                            <a href="{{ route('buyer.orders.index') }}" class="dropdown-item">
                                <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5 8 5.961 14.154 3.5 8.186 1.113zM15 4.239l-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6z"/>
                                </svg>
                                <span>Pesanan Saya</span>
                            </a>
                            
                            @php
                                $hasStore = false;
                                try {
                                    $hasStore = auth()->user()->store()->exists();
                                } catch (\Exception $e) {}
                            @endphp
                            
                            @if($hasStore)
                                <a href="{{ route('seller.dashboard') }}" class="dropdown-item">
                                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.371 2.371 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976l2.61-3.045zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0zM1.5 8.5A.5.5 0 0 1 2 9v6h12V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5zm2 .5a.5.5 0 0 1 .5.5V13h8V9.5a.5.5 0 0 1 1 0V13a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9.5a.5.5 0 0 1 .5-.5z"/>
                                    </svg>
                                    <span>Dashboard Toko</span>
                                </a>
                            @else
                                <a href="{{ route('buyer.store.create') }}" class="dropdown-item">
                                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M8 4a.5.5 0 0 1 .5.5V6h1.5a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V7H6a.5.5 0 0 1 0-1h1.5V4.5A.5.5 0 0 1 8 4z"/>
                                        <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.371 2.371 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976l2.61-3.045z"/>
                                    </svg>
                                    <span>Buka Toko</span>
                                </a>
                            @endif
                            
                            <div class="dropdown-divider"></div>
                            
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item logout-item">
                                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
                                        <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                                    </svg>
                                    <span>Keluar</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('register') }}" class="btn-outline">Daftar</a>
                    <a href="{{ route('login') }}" class="btn-primary">Masuk</a>
                @endauth
            </div>
        </div>
    </div>

    {{-- Category Navigation --}}
    <nav class="header-nav">
        <div class="nav-content">
            <a href="{{ route('buyer.dashboard') }}" class="nav-link {{ request()->routeIs('buyer.dashboard') ? 'active' : '' }}">
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="margin-right: 4px; vertical-align: text-bottom;">
                    <path d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5z"/>
                </svg>
                Beranda
            </a>
            <a href="{{ route('buyer.products.index') }}" class="nav-link">Semua Produk</a>
            <a href="{{ route('buyer.products.index', ['category' => 1]) }}" class="nav-link">Keripik</a>
            <a href="{{ route('buyer.products.index', ['category' => 2]) }}" class="nav-link">Biskuit</a>
            <a href="{{ route('buyer.products.index', ['category' => 3]) }}" class="nav-link">Cokelat</a>
            <a href="{{ route('buyer.products.index', ['category' => 4]) }}" class="nav-link">Permen</a>
            <a href="{{ route('buyer.products.index', ['category' => 5]) }}" class="nav-link">Minuman</a>
        </div>
    </nav>
</header>