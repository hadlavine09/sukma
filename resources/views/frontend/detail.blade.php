<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk - {{ $product->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f6f6f6;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 85%;
            margin: 30px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-sizing: border-box;
        }
        .product-detail {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .product-image {
            flex: 1 1 40%;
            min-width: 220px;
        }
        .product-image img {
            width: 100%;
            border-radius: 8px;
            border: 1px solid #ccc;
            object-fit: cover;
        }
        .product-info {
            flex: 1 1 55%;
            min-width: 220px;
        }
        .product-info h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .price {
            font-size: 20px;
            font-weight: bold;
        }
        .stock {
            margin-top: 5px;
            color: #555;
        }
        .btn-buy {
            margin-top: 15px;
            background-color: #1b4d3e;
            color: #fff;
            padding: 10px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            max-width: 220px;
        }
        .tabs {
            margin-top: 30px;
            border-bottom: 2px solid #eee;
            display: flex;
            flex-wrap: wrap;
        }
        .tab-btn {
            padding: 10px 16px;
            cursor: pointer;
            background: none;
            border: none;
            border-bottom: 2px solid transparent;
            font-weight: bold;
            transition: color 0.2s, border-color 0.2s;
        }
        .tab-btn.active {
            border-color: #3c9d40;
            color: #3c9d40;
        }
        .tab-content {
            display: none;
            margin-top: 20px;
        }
        .tab-content.active {
            display: block;
        }
        .review-item {
            border-bottom: 1px solid #eee;
            padding: 10px 0;
        }
        .review-stars {
            color: #f5c518;
        }

        /* Responsive Styles */
        @media (max-width: 1024px) {
            .container, .store-container {
            max-width: 98vw;
            padding: 16px 8px;
            }
            .product-info h1 {
            font-size: 20px;
            }
        }
        @media (max-width: 800px) {
            .product-detail {
            flex-direction: column;
            gap: 16px;
            }
            .product-image, .product-info {
            min-width: 0;
            }
            .tabs {
            flex-direction: column;
            }
        }
        @media (max-width: 700px) {
            .container, .store-container {
            padding: 12px 4px;
            border-radius: 0;
            }
            .store-header, .store-stats {
            flex-direction: column;
            gap: 12px;
            align-items: flex-start;
            }
            .store-actions {
            margin-left: 0;
            width: 100%;
            flex-direction: column;
            gap: 8px;
            }
            .store-stats {
            gap: 18px;
            }
            .store-avatar-wrapper {
            width: 48px;
            height: 48px;
            }
            .store-avatar {
            width: 48px;
            height: 48px;
            }
            .store-name {
            font-size: 15px;
            max-width: 120px;
            }
        }
        @media (max-width: 480px) {
            .container, .store-container {
            padding: 6px 2px;
            }
            .product-info h1 {
            font-size: 16px;
            }
            .btn-buy, .btn-chat, .btn-visit {
            font-size: 13px;
            padding: 8px 8px;
            }
            .store-name {
            font-size: 13px;
            max-width: 90px;
            }
            .store-badge span {
            font-size: 10px;
            padding: 2px 6px;
            }
            .stat-value {
            font-size: 13px;
            }
        }
        .store-container {
            max-width: 85%;
            margin: 30px auto 20px auto;
            background: #fff;
            padding: 24px 24px 16px 24px;
            border-radius: 8px;
            box-sizing: border-box;
        }
        .store-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        .store-profile {
            display: flex;
            align-items: center;
            gap: 16px;
            flex: 1;
            min-width: 0;
        }
        .store-avatar-wrapper {
            position: relative;
            width: 64px;
            height: 64px;
            margin-right: 8px;
        }
        .store-avatar {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            overflow: hidden;
            border: 1px solid #eee;
            background: #fafafa;
        }
        .store-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .store-badge {
            position: absolute;
            left: 0;
            bottom: -18px;
        }
        .store-badge span {
            background: #3c9d40;
            color: #fff;
            font-size: 12px;
            padding: 2px 10px;
            border-radius: 8px;
            font-weight: bold;
            box-shadow: 0 2px 6px rgba(245,114,36,0.08);
        }
        .store-name {
            font-weight: bold;
            font-size: 17px;
            margin-bottom: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 180px;
        }
        .store-active {
            color: #888;
            font-size: 13px;
        }
        .store-actions {
            display: flex;
            gap: 8px;
            margin-left: 16px;
        }
        .btn-chat {
            display: flex;
            align-items: center;
            gap: 6px;
            border: 1.5px solid #2d5727;
            background: #fff;
            color: #2d5727;
            border-radius: 4px;
            padding: 7px 16px;
            font-weight: 500;
            cursor: pointer;
            font-size: 15px;
            transition: background 0.2s, color 0.2s;
        }
        .btn-chat:hover {
            background: #2d5727;
            color: #fff;
        }
        .btn-visit {
            border: 1.5px solid #ddd;
            background: #fff;
            color: #333;
            border-radius: 4px;
            padding: 7px 16px;
            font-weight: 500;
            cursor: pointer;
            font-size: 15px;
            transition: background 0.2s, color 0.2s;
        }
        .btn-visit:hover {
            background: #f6f6f6;
            color: #2d5727;
            border-color: #2d5727;
        }
        .chat-icon {
            font-size: 15px;
        }
        .store-stats {
            display: flex;
            margin-top: 18px;
            gap: 40px;
            flex-wrap: wrap;
        }
        .store-stats > div {
            color: #888;
            font-size: 14px;
            min-width: 90px;
        }
        .stat-value {
            color: #2d5727;
            font-weight: bold;
            font-size: 15px;
            margin-top: 2px;
        }
        /* Responsive Styles */
        @media (max-width: 1024px) {
            .container, .store-container {
                max-width: 98vw;
                padding: 16px 8px;
            }
            .product-info h1 {
                font-size: 20px;
            }
        }
        @media (max-width: 800px) {
            .product-detail {
                flex-direction: column;
                gap: 16px;
            }
            .product-image, .product-info {
                min-width: 0;
            }
            .tabs {
                flex-direction: column;
            }
        }
        @media (max-width: 700px) {
            .container, .store-container {
                padding: 12px 4px;
                border-radius: 0;
            }
            .store-header, .store-stats {
                flex-direction: column;
                gap: 12px;
                align-items: flex-start;
            }
            .store-actions {
                margin-left: 0;
                width: 100%;
                flex-direction: column;
                gap: 8px;
            }
            .store-stats {
                gap: 18px;
            }
            .store-avatar-wrapper {
                width: 48px;
                height: 48px;
            }
            .store-avatar {
                width: 48px;
                height: 48px;
            }
            .store-name {
                font-size: 15px;
                max-width: 120px;
            }
        }
        @media (max-width: 480px) {
            .container, .store-container {
                padding: 6px 2px;
            }
            .product-info h1 {
                font-size: 16px;
            }
            .btn-buy, .btn-chat, .btn-visit {
                font-size: 13px;
                padding: 8px 8px;
            }
            .store-name {
                font-size: 13px;
                max-width: 90px;
            }
            .store-badge span {
                font-size: 10px;
                padding: 2px 6px;
            }
            .stat-value {
                font-size: 13px;
            }
        }
    </style>
</head>
</head>
<body>

<div class="container">
    {{-- Detail Produk --}}
    <div class="product-detail">
        <div class="product-image">
            <img src="" alt="{{ $product->name }}">
        </div>
        <div class="product-info">
            <h1>{{ $product->name }}</h1>
            <div class="price">Rp{{ number_format($product->price, 0, ',', '.') }}</div>
            <div class="stock">Stok: {{ $product->stock }}</div>
            <button class="btn-buy">Beli Sekarang</button>
        </div>
    </div>

    {{-- Tab Navigasi --}}
    <div class="tabs">
        <button class="tab-btn active" data-tab="specs">Spesifikasi Produk</button>
        <button class="tab-btn" data-tab="desc">Deskripsi Produk</button>
        <button class="tab-btn" data-tab="review">Penilaian Produk</button>
    </div>

    {{-- Tab Konten --}}
    <div id="specs" class="tab-content active">
        <ul>
            @foreach ($product->specs as $spec)
                <li><strong>{{ $spec['key'] }}</strong>: {{ $spec['value'] }}</li>
            @endforeach
        </ul>
    </div>

    <div id="desc" class="tab-content">
        <p>{{ $product->description }}</p>
    </div>

    <div id="review" class="tab-content">
        @forelse ($product->reviews as $review)
            <div class="review-item">
                <div><strong>{{ $review->user->name }}</strong></div>
                <div class="review-stars">{{ str_repeat('★', $review->rating) }}</div>
                <div>{{ $review->comment }}</div>
            </div>
        @empty
            <p>Belum ada penilaian.</p>
        @endforelse
    </div>
</div>

<div class="store-container">
    {{-- Identitas Toko --}}
    <div class="store-header">
        <div class="store-profile">
            <div class="store-avatar-wrapper">
                <div class="store-avatar">
                    <img src="" alt="{{ $product->store }}">
                </div>
                <div class="store-badge">
                    <span>Star+</span>
                </div>
            </div>
            <div>
                <div class="store-name">{{ $product->store }}</div>
                <div class="store-active">Aktif {{ $product->store->last_active ?? 'Baru saja' }}</div>
            </div>
        </div>
        <div class="store-actions">
            <button class="btn-chat">
                <span class="chat-icon">💬</span> Chat Sekarang
            </button>
            <button class="btn-visit">
                Kunjungi Toko
            </button>
        </div>
    </div>
    <div class="store-stats">
        <div>
            <div>Penilaian</div>
            <div class="stat-value">40,8RB</div>
        </div>
        <div>
            <div>Produk</div>
            <div class="stat-value">1,3RB</div>
        </div>
        <div>
            <div>Persentase Chat Dibalas</div>
            <div class="stat-value">96%</div>
        </div>
        <div>
            <div>Waktu Chat Dibalas</div>
            <div class="stat-value">hitungan jam</div>
        </div>
        <div>
            <div>Bergabung</div>
            <div class="stat-value">6 tahun lalu</div>
        </div>
        <div>
            <div>Pengikut</div>
            <div class="stat-value">9,4RB</div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tabButtons = document.querySelectorAll('.tab-btn');
        const tabContents = document.querySelectorAll('.tab-content');

        tabButtons.forEach(btn => {
            btn.addEventListener('click', function () {
                const target = this.getAttribute('data-tab');

                // Atur aktif pada tombol tab
                tabButtons.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                // Tampilkan konten tab sesuai data-tab
                tabContents.forEach(content => {
                    if (content.id === target) {
                        content.classList.add('active');
                    } else {
                        content.classList.remove('active');
                    }
                });
            });
        });
    });
</script>

</body>
</html>
