@extends('frontend.component.main')

@section('contentfrontend')
<style>
  .keranjang-container {
    background: #ffffff;
    margin: 20px auto;
    width: 95%;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 0 10px rgba(0,0,0,0.05);
  }
  table {
    width: 100%;
    border-collapse: collapse;
  }
  thead {
    background: #e6f7e9;
  }
  th, td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #f0f0f0;
  }
  .product-img {
    width: 80px;
    border-radius: 6px;
    border: 1px solid #ddd;
  }
  .qty-input {
    width: 60px;
    text-align: center;
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 5px;
  }
  .hapus-btn {
    background: #e53935;
    color: white;
    border: none;
    padding: 6px 10px;
    border-radius: 4px;
    cursor: pointer;
  }
  .footer-keranjang {
    background: #ffffff;
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
  }
  .checkout-btn {
    background: #2e7d32;
    color: white;
    border: none;
    padding: 12px 30px;
    font-weight: bold;
    border-radius: 5px;
    cursor: pointer;
  }
  .total-text {
    font-size: 16px;
  }
  .total-price {
    font-weight: bold;
    color: #2e7d32;
    font-size: 18px;
    margin-left: 10px;
  }
</style>

<div class="keranjang-container">
  <form method="POST" action="{{ route('frontend.checkout') }}">
    @csrf
    <table>
      <thead>
        <tr>
          <th><input type="checkbox" id="check-all"> Semua</th>
          <th>Produk</th>
          <th>Harga Satuan</th>
          <th>Kuantitas</th>
          <th>Total Harga</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($keranjang as $item)
        <tr id="row-{{ $item->id }}">
          <td>
            <input type="checkbox" class="item-check" name="selected[]" value="{{ $item->id }}" data-id="{{ $item->id }}">
          </td>
          <td>
            <div style="display: flex; gap: 10px; align-items: center;">
              <img src="{{ asset('storage/' . $item->gambar_produk) }}" class="product-img" alt="gambar produk">
              <div>
                <div><strong>{{ $item->nama_produk }}</strong></div>
              </div>
            </div>
          </td>
          <td class="harga" data-id="{{ $item->id }}">
            Rp{{ number_format($item->harga_produk, 0, ',', '.') }}
          </td>
          <td>
            <input type="number" min="0" class="qty-input update-qty" data-id="{{ $item->id }}" value="{{ $item->quantity }}">
          </td>
          <td class="subtotal" data-id="{{ $item->id }}">
            Rp{{ number_format($item->harga_produk * $item->quantity, 0, ',', '.') }}
          </td>
          <td>
            <button type="button" class="hapus-btn btn-remove" data-id="{{ $item->id }}">Hapus</button>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <div class="footer-keranjang">
      <div>
        <span class="total-text">Total Pilihan:</span>
        <span class="total-price" id="total-price">Rp0</span>
      </div>
      <button type="submit" class="checkout-btn">Checkout</button>
    </div>
  </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  // Fungsi debounce supaya delay saat user mengetik
  function debounce(func, wait) {
    let timeout;
    return function(...args) {
      clearTimeout(timeout);
      timeout = setTimeout(() => func.apply(this, args), wait);
    };
  }

  // Format angka ke IDR
  function formatRupiah(value) {
    return 'Rp' + value.toLocaleString('id-ID');
  }

  // Parsing string rupiah ke integer (hapus Rp, titik dan koma)
  function parseRupiah(text) {
    return parseInt(text.replace(/[^0-9]/g, '')) || 0;
  }

  // Update total harga sesuai checkbox terpilih
  function updateTotal() {
    let total = 0;
    $('.item-check:checked').each(function () {
      const id = $(this).data('id');
      const subtotalText = $(`.subtotal[data-id="${id}"]`).text();
      const subtotal = parseRupiah(subtotalText);
      total += subtotal;
    });
    $('#total-price').text(formatRupiah(total));
  }

  // Simpan qty sebelumnya tiap input untuk rollback jika batal hapus
  const previousQtyMap = {};

  // Inisialisasi previousQtyMap dengan value awal
  $('.update-qty').each(function () {
    const id = $(this).data('id');
    previousQtyMap[id] = $(this).val();
  });

  // Update kuantitas dengan debounce dan konfirmasi hapus jika 0
  $('.update-qty').on('input', debounce(function () {
    const $input = $(this);
    const id = $input.data('id');
    let qty = parseInt($input.val());

    if (isNaN(qty) || qty < 0) {
      qty = previousQtyMap[id];
      $input.val(qty);
      return;
    }

    if (qty === 0) {
      if (confirm('Quantity 0, hapus produk ini dari keranjang?')) {
        // Hapus item via ajax
        $.ajax({
  url: "{{ route('frontend.cartdestroy', ':id') }}".replace(':id', id),
  type: 'DELETE',
  data: {
    _token: '{{ csrf_token() }}'
  },
  success: function (res) {
    $('#row-' + id).remove();
    updateTotal();
    // alert(res.message); // Tampilkan pesan dari controller
  },
  error: function () {
    alert('Gagal menghapus item.');
  }
});

      } else {
        $input.val(previousQtyMap[id]); // rollback
      }
      return;
    }

    // Update quantity di server
    $.post("{{ route('frontend.cartupdate') }}", {
      _token: '{{ csrf_token() }}',
      id: id,
      jumlah: qty
    })
    .done(function () {
      // Update subtotal di UI
      const hargaText = $(`.harga[data-id="${id}"]`).text();
      const harga = parseRupiah(hargaText);
      const subtotal = harga * qty;
      $(`.subtotal[data-id="${id}"]`).text(formatRupiah(subtotal));

      previousQtyMap[id] = qty; // update previous qty
      updateTotal();
    })
    .fail(function () {
      alert('Gagal mengupdate kuantitas.');
      $input.val(previousQtyMap[id]); // rollback
    });

  }, 500));

  // Event checkbox semua dan update total
  $('#check-all').on('change', function () {
    $('.item-check').prop('checked', this.checked);
    updateTotal();
  });

  // Event checkbox individual update total
  $(document).on('change', '.item-check', function () {
    updateTotal();
  });

  // Event hapus button
  $('.btn-remove').on('click', function () {
    const id = $(this).data('id');
    if (confirm('Yakin ingin menghapus item ini?')) {
      $.ajax({
        url: "{{ route('frontend.cartdestroy', ':id') }}".replace(':id', id),
        type: 'DELETE',
        data: {
          _token: '{{ csrf_token() }}'
        },
        success: function () {
          $('#row-' + id).remove();
          updateTotal();
          delete previousQtyMap[id];
        },
        error: function () {
          alert('Gagal menghapus item.');
        }
      });
    }
  });

  // Hitung total awal saat document siap
  $(document).ready(function () {
    updateTotal();
  });
</script>
@endsection
