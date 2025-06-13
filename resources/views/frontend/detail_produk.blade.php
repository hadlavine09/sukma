<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Detail Produk - {{ $produk->name }}</title>
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
    .produk-detail {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
    }
    .produk-image {
      flex: 1 1 40%;
      min-width: 220px;
    }
    .produk-image img {
      width: 100%;
      border-radius: 8px;
      border: 1px solid #ccc;
      object-fit: cover;
    }
    .produk-info {
      flex: 1 1 55%;
      min-width: 220px;
    }
    .produk-info h1 {
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
    .btn-buy,
    .btn-visit {
      padding: 10px 20px;
      border-radius: 5px;
      font-weight: bold;
      cursor: pointer;
      border: none;
      max-width: 200px;
      flex: 1;
    }
    .btn-buy {
      background-color: #2d5727;
      color: #fff;
    }
    .btn-visit {
      background-color: #f48c06;
      color: #fff;
    }

    /* Store Container */
    .store-container {
      max-width: 85%;
      margin: 30px auto 20px auto;
      background: #fff;
      padding: 24px;
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
    }
    .store-avatar-wrapper {
      position: relative;
      width: 64px;
      height: 64px;
    }
    .store-avatar {
      width: 64px;
      height: 64px;
      border-radius: 50%;
      overflow: hidden;
      background: #fafafa;
      border: 1px solid #eee;
    }
    .store-avatar img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    .store-badge {
      position: absolute;
      bottom: -18px;
      left: 0;
    }
    .store-badge span {
      background: #3c9d40;
      color: white;
      font-size: 12px;
      padding: 2px 10px;
      border-radius: 8px;
      font-weight: bold;
      box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }
    .store-name {
      font-weight: bold;
      font-size: 17px;
      margin-bottom: 2px;
      max-width: 180px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }
    .store-active {
      color: #888;
      font-size: 13px;
    }
    .store-actions {
      display: flex;
      gap: 8px;
    }
    .btn-chat,
    .btn-visit {
      padding: 7px 16px;
      border-radius: 4px;
      font-weight: 500;
      font-size: 15px;
      cursor: pointer;
    }
    .btn-chat {
      background: #fff;
      border: 1.5px solid #2d5727;
      color: #2d5727;
    }
    .btn-chat:hover {
      background-color: #2d5727;
      color: #fff;
    }
    .btn-visit {
      background: #fff;
      border: 1.5px solid #ddd;
      color: #333;
    }
    .btn-visit:hover {
      background-color: #f6f6f6;
      border-color: #2d5727;
      color: #2d5727;
    }
    .chat-icon {
      margin-right: 4px;
    }

    .store-stats {
      display: flex;
      flex-wrap: wrap;
      margin-top: 20px;
      gap: 40px;
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

    /* Responsive */
    @media (max-width: 800px) {
      .produk-detail {
        flex-direction: column;
      }
      .store-header, .store-stats {
        flex-direction: column;
        gap: 16px;
      }
      .store-actions {
        flex-direction: column;
        align-items: flex-start;
      }
    }
    @media (max-width: 480px) {
      .store-avatar-wrapper {
        width: 48px;
        height: 48px;
      }
      .store-avatar {
        width: 48px;
        height: 48px;
      }
      .store-name {
        font-size: 14px;
      }
      .btn-buy, .btn-visit, .btn-chat {
        font-size: 13px;
      }
    }
  </style>
</head>
<body>

  <!-- Detail Produk -->
  <div class="container">
    <div class="produk-detail">
      <div class="produk-image">
        <img src="{{ asset('storage/' . $produk->gambar_produk) }}" alt="{{ $produk->nama_produk }}">
      </div>
      <div class="produk-info">
        <h1>{{ $produk->nama_produk }}</h1>
        <div class="price">Rp{{ number_format($produk->harga_produk, 0, ',', '.') }}</div>
        <div class="stock">Stok: {{ $produk->stok_produk }}</div>

        <div style="margin: 20px 0;">
          <label for="jumlah" style="display: block; margin-bottom: 6px;">Jumlah:</label>
            <input type="number" id="jumlah" value="1" min="1" max="{{ $produk->stok_produk }}"
                style="padding: 10px; width: 100px; border: 1px solid #ccc; border-radius: 5px;">
        </div>

        <div class="store-actions" style="margin-top: 20px;">
        <button id="btn-tambah-keranjang" class="btn-buy"
                data-kode-produk="{{ $produk->kode_produk }}">
        + Masukkan Keranjang
        </button>
          <button class="btn-visit">Beli Sekarang</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Informasi Toko -->
  <div class="store-container">
    <div class="store-header">
      <div class="store-profile">
        <div class="store-avatar-wrapper">
          <div class="store-avatar">
            <img src="" alt="{{ $produk->store }}">
          </div>
          <div class="store-badge">
            <span>Star+</span>
          </div>
        </div>
        <div>
          <div class="store-name">{{ $produk->store }}</div>
          <div class="store-active">Aktif {{ $produk->store->last_active ?? 'Baru saja' }}</div>
        </div>
      </div>
      <div class="store-actions">
        <button class="btn-chat"><span class="chat-icon">💬</span> Chat Sekarang</button>
        <button class="btn-visit">Kunjungi Toko</button>
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
</body>
</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $('#btn-tambah-keranjang').click(function(e) {
    e.preventDefault();

    let kodeProduk = $(this).data('kode-produk');
    let quantity = $('#jumlah').val();

    $.ajax({
      url: "{{ route('frontend.tambahkeranjang') }}",
      method: 'POST',
      data: {
        _token: '{{ csrf_token() }}',
        kode_produk: kodeProduk,
        quantity: quantity
      },
      success: function(response) {
        // Redirect ke halaman keranjang jika sukses
        window.location.href = response.redirect;
      },
      error: function(xhr) {
        let json = xhr.responseJSON;
        if (json && json.error) {
          alert(json.error);
        } else {
          alert('Terjadi kesalahan. Silakan coba lagi.');
        }
        console.log(xhr.responseText);
      }
    });
  });
</script>
