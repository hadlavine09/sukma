<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Penjual - SukMa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f5f5f5;
        }

        .sidebar {
            min-height: 100vh;
            background-color: #2d5727;
            color: white;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
        }

        .sidebar a:hover {
            background-color: #244a21;
            color: #fff;
        }

        .card-stat {
            border: none;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .card-stat:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .text-green {
            color: #2d5727;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">

            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar py-4 px-3">
                <div class="text-center mb-4">
                    <img src="{{ asset('logo/logo2.png') }}" alt="Logo Toko" class="rounded-circle mb-2" style="width: 80px;">
                    <h5 class="mb-0">Toko Anda</h5>
                    <small>Penjual Terdaftar</small>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2"><a href="#" class="nav-link"><i class="bi bi-house-door me-2"></i>Beranda</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link"><i class="bi bi-box-seam me-2"></i>Produk</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link"><i class="bi bi-cart-check me-2"></i>Pesanan</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link"><i class="bi bi-bar-chart-line me-2"></i>Statistik</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link"><i class="bi bi-gear me-2"></i>Pengaturan</a></li>
                </ul>
            </nav>
 <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container " class="app-container container-xl">
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card body-->
                <div class="card-body">
                    <!--begin::Stepper-->
                    <div class="stepper stepper-links d-flex flex-column pt-15" id="kt_create_account_stepper"
                        data-kt-stepper="true">
                        <!--begin::Nav-->
                        <div class="stepper-nav mb-5">
                            <!--begin::Step 1-->
                            <div class="stepper-item rounded-circle current" data-kt-stepper-element="nav">
                                <h3 class="stepper-title">Tahap Pertama</h3>
                            </div>
                            <!--end::Step 1-->
                            <!--begin::Step 2-->
                            <div class="stepper-item" data-kt-stepper-element="nav">
                                <h3 class="stepper-title">Tahap Kedua</h3>
                            </div>
                            <!--end::Step 2-->
                            <!--begin::Step 3-->
                            <div class="stepper-item" data-kt-stepper-element="nav">
                                <h3 class="stepper-title">Tahap Ketiga</h3>
                            </div>
                            <!--end::Step 3-->
                            <!--begin::Step 4-->
                            <div class="stepper-item" data-kt-stepper-element="nav">
                                <h3 class="stepper-title">Tahap Keempat</h3>
                            </div>
                            <!--end::Step 4-->
                            <!--begin::Step 5-->
                            <div class="stepper-item" data-kt-stepper-element="nav">
                                <h3 class="stepper-title">Selesai</h3>
                            </div>
                            <!--end::Step 5-->
                        </div>
                        <!--end::Nav-->
                        <!--begin::Form-->
                        <form class="mx-auto mw-800px w-300 pt-15 pb-10 fv-plugins-bootstrap5 fv-plugins-framework"
                            novalidate="novalidate" id="kt_create_account_form">
                            <!--begin::Step 1-->

                            <div class="current" data-kt-stepper-element="content">
                                <!--begin::Wrapper-->
                                <div class="w-100">
                                    <!--begin::Heading-->
                                    <div class="pb-10 pb-lg-15 text-center">

                                        <h1>Informasi Pengunjung</h1>
                                        <hr style="color: green ">
                                    </div>
                                    <!--end::Heading-->
                                    <!--begin::Input group-->
                                    <div class="fv-row fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
                                        <div class="card-body">
                                            <div class="form-group row">
                                                <div class="row mb-3">
                                                    <label for="nik"
                                                        class="col-sm-4 col-form-label form-label">NIK
                                                        Pengunjung :</label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control" type="text" name="nik"
                                                            placeholder="Masukan NIK anda" id="nik"
                                                            aria-describedby="desk-nik" value="" minlength="16"
                                                            maxlength="16" onkeypress="return hanyaAngka(event)"
                                                            required>

                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="nik"
                                                        class="col-sm-4 col-form-label form-label">Nama
                                                        Pengunjung :</label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control" type="text" name="nama"
                                                            placeholder="Masukan nama lengkap anda" id="nama"
                                                            value="" minlength="16" maxlength="50" required
                                                            onkeypress='return harusHuruf(event)'>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="row mb-3">
                                                    <label for="status"
                                                        class="col-sm-4 col-form-label form-label">Status
                                                        Pengunjung :</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control custom-select" name="status"
                                                            id="status" title="">
                                                            <option class="bs-title-option" value=""
                                                                id="status">
                                                                -- Pilih Status Pengunjung --</option>
                                                            <option value="Diri Sendiri atau Wajib Pajak Langsung">
                                                                Diri Sendiri atau Wajib Pajak Langsung</option>
                                                            <option value="Kuasa dari Wajib Pajak">Kuasa dari Wajib
                                                                Pajak</option id="status">
                                                        </select>
                                                        <div class="filter-option">
                                                            <div class="filter-option-inner">
                                                                <div class="filter-option-inner-inner"></div>
                                                            </div>
                                                        </div></button>
                                                        <div class="dropdown-menu ">
                                                            <div class="inner show" role="listbox" id="bs-select-1"
                                                                tabindex="-1">
                                                                <ul class="dropdown-menu inner show"
                                                                    role="presentation"></ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="input-email"
                                                        class="col-sm-4 col-form-label form-label reqired">Alamat
                                                        Email :</label>
                                                    <div class="col-sm-8">
                                                        <div class="input-group">
                                                            <input
                                                                class="form-control @error('email') is-invalid @enderror"
                                                                type="email" name="email"
                                                                placeholder="Masukan Email anda" value=""
                                                                id="email" maxlength="50">
                                                        </div>
                                                    </div>
                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="input-no-hp"
                                                        class="col-sm-4 col-form-label form-label">No. Hp</label>
                                                    <div class="col-sm-8">
                                                        <div class="input-group">
                                                            <span class="input-group-text"><img
                                                                    class="h-20px w-20px rounded-sm"
                                                                    src="{{ asset('assets_frontend/umkm_register/img/indo.png') }}"
                                                                    alt="">+62</span>
                                                            <input class="form-control" type="text" name="no_hp"
                                                                placeholder="Masukan kontak yang aktif" id="no_hp"
                                                                required="" value="" maxlength="13"
                                                                onkeypress="return hanyaAngka(event)">
                                                        </div>
                                                    </div>
                                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--end::Wrapper-->
                            </div>

                            <!--end::Step 1-->
                            <!--begin::Step 2-->
                            <div data-kt-stepper-element="content">
                                <!--begin::Wrapper-->
                                <div class="form " id="form-survey">
                                    <div class="pb-10 pb-lg-15 text-center">

                                        <h1>Informasi kesehatan</h1>
                                        <hr style="color: green ">
                                    </div>
                                    <div class="container py-5 px-md-5 ">
                                        <b>
                                            <div class="desc mb-3">
                                                Demi kesehatan dan keselamatan bersama , pengunjung harus jujur dalam
                                                menjawab pertanyaan di bawah ini.
                                            </div>
                                            <div class="container survey p-2">
                                                <div class="mb-3">
                                                    <p>
                                                        Apakah Anda sudah melakukan vaksin COVID-19?
                                                    </p>
                                                    <input type="hidden" name="pertanyaan0" value="3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="pertanyaan0" id="tanya" value="1"
                                                            required="">
                                                        <label class="form-check-label" for="q-3-ya">
                                                            Ya
                                                        </label>
                                                    </div>
                                                    <br>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="pertanyaan0" id="tanya" value="0">
                                                        <label class="form-check-label" for="q-3-tidak">
                                                            Tidak
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <p>
                                                        Apakah Anda pernah memiliki riwayat kontak erat dengan orang
                                                        yang
                                                        dinyatakan positif COVID-19?
                                                    </p>
                                                    <input type="hidden" name="pertanyaan1" value="5">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="pertanyaan1" id="tanya" value="1"
                                                            required="">
                                                        <label class="form-check-label" for="q-5-ya">
                                                            Ya
                                                        </label>
                                                    </div>
                                                    <br>
                                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                                        Please provide a valid city.
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="pertanyaan1" id="tanya" value="0">
                                                        <label class="form-check-label" for="q-5-tidak">
                                                            Tidak
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <p>
                                                        Apakah Anda pernah mengalami demam/batuk/pilek/sakit
                                                        tenggorokan/sesak dalam 14 hari terakhir?
                                                    </p>
                                                    <input type="hidden" name="pertanyaan2" value="6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="pertanyaan2" id="tanya" value="1"
                                                            required="">
                                                        <label class="form-check-label" for="q-6ya">
                                                            Ya
                                                        </label>
                                                    </div>
                                                    <br>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="pertanyaan2" id="tanya" value="0">
                                                        <label class="form-check-label" for="q-6tidak">
                                                            Tidak
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <div class="form-check">
                                                        <input id="persetujuan" class="form-check-input"
                                                            type="checkbox" name="persetujuan" required="">
                                                        <label for="persetujuan" class="form-check-label">Saya
                                                            menyatakan
                                                            bahwa data yang diisi adalah benar dan sesuai dengan
                                                            kenyataan
                                                            yang sebenarnya.</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </b>
                                    </div>

                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Step 2-->
                            <!--begin::Step 3-->
                            <div data-kt-stepper-element="content">
                                <!--begin::Wrapper-->
                                <div class="form" id="form-waktu">
                                    <div class="pb-10 pb-lg-15 text-center">
                                        <h1>Jadwal Layanan</h1>
                                        <hr style="color: green ">
                                    </div>
                                    <div class="container p-xxl-6 ">
                                        <div class="card-body">
                                            <div class="form-group row">
                                                <div class="row mb-3">
                                                    <label for="tujuan"
                                                        class="col-sm-4 col-form-label form-label ">Kantor
                                                        Tujuan</label>
                                                    <div class="col-sm-8">
                                                        <select id='tujuan' class="form-control custom-select"
                                                            name='tujuan'>
                                                            <option value=''>-- Masukan Kantor Tujuan --</option>

                                                            <!-- Read Departments -->
                                                            {{-- @foreach ($kantor as $data)
                                                                <option value='{{ $data->nama_kota }}'>
                                                                    {{ $data->nama_kota }}</option>
                                                            @endforeach --}}
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-sm-4 col-form-label form-label">Tanggal
                                                        Kunjungan:</label>
                                                    <div class="col-sm-8">
                                                        <input
                                                            class="form-control p flatpickr-input valid datetimepicker"
                                                            type="date" name="tanggal" id="tanggal">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="row mb-3">
                                                    <label class="col-sm-4 col-form-label form-label">Waktu
                                                        Pelayanan:</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control custom-select" name="waktu"
                                                            id="waktu">
                                                            <option value="">Masukan waktu anda</option>
                                                            <option value="08:00 - 10:00">08:00 - 10:00</option>
                                                            <option value="10:00 - 12:00">10:00 - 12:00</option>
                                                            <option value="13:00 - 15:00">13:00 - 15:00</option>
                                                            <option value="15:00 - 17:00">15:00 - 17:00</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label class="col-sm-4 col-form-label form-label">Layanan:</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control custom-select" name="layanan"
                                                            id="layanan">
                                                            <option value="">Silahkan masukan tujuan anda
                                                            </option>
                                                            {{-- @foreach ($layanan as $layan)
                                                                <option value='{{ $layan->layanan }}'>
                                                                    {{ $layan->layanan }}</option>
                                                            @endforeach --}}
                                                        </select>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Step 3-->
                            <!--begin::Step 4-->
                            <div data-kt-stepper-element="content">
                                <!--begin::Wrapper-->
                                <div class="form active" id="form-confirm">
                                    <h1 class="title form-title text-center">
                                        Informasi Antrean
                                    </h1>
                                    <hr style="color: green">
                                    <div class="container py-5 px-md-5 ">
                                        <fieldset>
                                            <div class="row mb-3">
                                                <label for="conf-kanotr-tujuan"
                                                    class="col-sm-4 col-form-label form-label">Kantor tujuan</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" type="text" name="tujuan"
                                                        value="" id="conf-kantor-tujuan" disabled>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="conf-kanotr-tujuan"
                                                    class="col-sm-4 col-form-label form-label">Alamat Kantor</label>
                                                <div class="col-sm-8">
                                                    <textarea class="form-control" name="alamat" value="" id="conf-alamat-kantor" disabled cols="10"
                                                        rows="5"></textarea>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="conf-alamat"
                                                    class="col-sm-4 col-form-label form-label">Jenis Layanan</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="conf-layanan"
                                                        disabled>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="conf-tanggal"
                                                    class="col-sm-4 col-form-label form-label">Tanggal
                                                    Kunjungan</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" type="text"
                                                        id="conf-tanggal-kunjungan" disabled>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="conf-sesi-pelayanan"
                                                    class="col-sm-4 col-form-label form-label">Sesi Kunjungan</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" type="text"
                                                        id="conf-sesi-pelayanan" disabled>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <div class="row mb-3">
                                            <div class="h-captcha"
                                                data-sitekey="75992a63-43e1-4304-9c19-f90961c7f26b"><iframe
                                                    src="https://newassets.hcaptcha.com/captcha/v1/1f7dc62/static/hcaptcha.html#frame=checkbox&amp;id=0eye8fgutumg&amp;host=antrean-bappenda.bogorkab.go.id&amp;sentry=true&amp;reportapi=https%3A%2F%2Faccounts.hcaptcha.com&amp;recaptchacompat=true&amp;custom=false&amp;hl=id&amp;tplinks=on&amp;sitekey=75992a63-43e1-4304-9c19-f90961c7f26b&amp;theme=light"
                                                    title="widget containing checkbox for hCaptcha security challenge"
                                                    tabindex="0" frameborder="0" scrolling="no"
                                                    data-hcaptcha-widget-id="0eye8fgutumg" data-hcaptcha-response=""
                                                    style="width: 303px; height: 78px; overflow: hidden;"></iframe>
                                                <textarea id="g-recaptcha-response-0eye8fgutumg" name="g-recaptcha-response" style="display: none;"></textarea>
                                                <textarea id="h-captcha-response-0eye8fgutumg" name="h-captcha-response" style="display: none;"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Step 4-->
                            <!--begin::Step 5-->
                            <div data-kt-stepper-element="content">
                                <!--begin::Wrapper-->
                                <div class="form active">
                                    <h1 class="title form-title">
                                        Tiket Antrean
                                    </h1>
                                    <hr class="mb-3">
                                    <p class="p-2 col-lg-9 text-center mx-auto mb-5">
                                        Silahkan screenshoot/cetak/foto tiket Anda.<br>
                                        Harap datang 15 menit sebelum waktu kunjungan Anda
                                    </p>

                                    <div class="container bg-white shadow col-lg-10 row mx-auto tiket p-3">
                                        <div class="container col-md-8 d-flex flex-column justify-content-around row">
                                            {{-- @php $no= 1; @endphp --}}
                                            {{-- @foreach ($daftar as $data) --}}
                                            <div class="container text-center text-md-left">
                                                No. Tiket :
                                                <b>
                                                    <h4><input style="text-align:center" type="text"
                                                            id="no_tiket" disabled></h4>
                                                </b>
                                            </div>
                                            {{-- @endforeach --}}
                                            <div class="container text-center text-md-left">
                                                Nama: <br>
                                                <b>
                                                    <h4><input style="text-align:center" type="text"
                                                            id="nama_tiket" disabled></h4>
                                                </b>
                                            </div>
                                        </div>
                                        <div class="container col-12 col-md-4 p-3">
                                            <div id="qr" class="p-2"><img crossorigin="anonymous"
                                                    src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMgAAADICAYAAACtWK6eAAAAAXNSR0IArs4c6QAAEBtJREFUeF7tnVt2GzkMRDN7yv5XkD3N6OREk1ZMNS5R1WzaqfwaJIB6EKTs2P/8+/j3Lf+CQBAYIvBPDBJlBIH3CMQgUUcQOEEgBok8gkAMEg0EgR4CmSA93LLqL0EgBvlLiE6bPQRODfL9+/ferhes+vHjx4ddaX2jte4S3bWM9lMwGPXrxmVFzW7eKgxiEBPiMci3bzGISUydbZTTszolOvX8uSYGiUEcOmrvEYN8+6ZgkCvWWHrV4ZkrVtuyrwszQTJBfiqicpxDb/Qu68jV2cNthk4NZ2tofUpeOs2UOKW+0dqOrqYnSAwyPilXXGGoYGKQMVIxCFWQGEcFuOIwoSel2PKH5cpk6AjVUX8nbyZIA/kYhH9goBipQc3pkhjEjeib/WKQGOSnNKjjqGDoPV3JS681Ss3UhytqUU5oioHSx4r63Lo67me5YlGg3Y1QI+10T3fXskKAMcjEVYISopyyVPg0zi1KpTd3LZQPGkcPMdoHzUvjFOw7eskEoYg34pSTl6ajwqJxMcgrAjEIVWIjLgbxP+YpDfRAqDj6cgahJ2Bn3FJyzuLoe81F8I61UOwpVldyHoMc0K1OkxjkNwJU5O63CuXAdcDEIDFIqTmX2J6JqLkyQR6IKeBTAJUcpXomA3aq+a5aYpAJ0SjivYvgifY+hO5U8121xCATClphEFqOUgvNsUIcyqOV9kHjFEypgZV+q3fnX/EGWUEmzRGD7P8jTEcuY5DikU4FHYOMEcgEeeBy1yhU8l45lme/90BFRE2o9KbkUPK6MaD75Yo1wbgL1BjkNwIKpsoBqOS1X7EmNIhClWvNirU0h0IwAuoRVJ2AV5l1RV6KAY2jvMUgbxClACpxlEwat0KotF9as3u/K/NaHum0QBqnALhiLc2RCTJmnOJH9ULjOnljkAO6FEAljpJJ4zJBKFL84+VcsXLF+omAYvQVxuTSZ5G0X8kgrBR/lPKpBAUmcf6fjaO8+RXDdqyMPn3FYmn9URToxPknw4qDw68YtmMMcsFVYoVg/jajMzn7o2KQGOSnqnY3nF/6bMcYJAaJQU68IhmEeXCvqBXXH3fHFUnPfO7eaB/0+zm0D5p3h7gv90c83SKi4lDIpMJy90ZrphjQPmjeHeJikAML9J7uJo4KKwZxI1/vF4PEIKVKMkFKiD5PgPuUpeJQEMoEUdC7du3SbxTuLoQR1CsMci3F73dX+FBqXpGXXperWmKQgukYRPsfoyN4K1GefWpHjRmDPJCi1ykKaibIGCn3IRGDvFGkAozrRJg1i1scs/mvjFf4UOpakdell1yxcsUqte4+JL60QVzOPLtn0hwls78CKCF0Pxq3QlhKDjcutBbKL42jfHT6nZ4gtGhaDH1HUPCVRyEFmsYpNdM+lByUI3e/ioZW9xuDUPYbcQqZMQj/CWRKTedAiEEouo24GGQMWibIAxfq1lyxuPOosOiOlCO6Hz0QaB80jtbX6Xd6gtDRP4pTzNBpbvaDAAr0XX3Q+ij2dL8V2LvNpej0uDYGoSo5xMUgHDQFKypyxVxVJzFIhdDg6wrpymncKPX/JVREVJS0FgUrWgvtrYN9DEKZzgRpIMV/HEgRubK2aioGqRDKBMEfuNC3j/L4dq+t6J82SGdMnT2WlTGqgFUBM/t1WstOcVTQs1gc46le6FXMXXNVXwyisH9Yu5Pw7xIbPeyoyCvxzh68nfpikBjkBQF6n6ewKSJX1rrqi0EokkVcJsgYIEXkylpKa5UjBqFIxiAtpCoBnl2TlLW02CqHxSD0zuse3/ROSfNWYJ2BrmBA89Ic9I5PRbQijk5gWgvdr8I+Bike2pQQKl4aR0VeEex4yFIMlDgqaJqD7lfhF4PEIFRzl8ZRQdMi6H4xyAPRXLE4BlSA7jgqaJqX7heDxCA/NUUPCSpAdxwVNM1L95MMQu/BtGj6qHbnVcDa/c3g7k3hkvK7wqwKLsc+pn83r7u5ysGOR6YCVgyiWYZir2X5uJrmrfQXgxSP9BhEky4VqpYlBpHu0JQkJY5eC6sTa3ZiKjW7bwO5Yl3w2HMLRiFJEVsMMp4BFNNPOUGUE4YKXxGWuz56nVLiFCFQTGl9tBb3fpRzWh81IcUPP9LdAqQNU0Lc9Sl5KUkUAzoJqdg64ji77in70ZopVhT7Ts3T30lXiqZrFaHSHAqoK+qLQSiT/BfMxSAc09v+bvhEiR9CKcHUwLQW936ZIA8EKJkULHriU9Lpfu44Wl8mCEdK4ajKMv19kGrDs3vrXaTTE5C+aa4kZBY/BVOFSwUDyodyeLrWxiAHJGOQsWWooN1xLpErHzbEIDFIOUjcwqf7xSATb5UVoGaCZIL8iUAmSCZIJsgJApd9H4Q+HumpXbL4K4B+eqZMJDr6FQzcfbhxpr1R3pQ42hvF9FhLDHJAowPg7KdOyqc/1Jg0hyLKGOSBAHUmBXoFcVTkmSCUNR5Hsec7skiq0059mSCZIEyFIKojQLBtGRKDlBD9DqAkZYJMgApDKfZwOxx2m0HuuvPSqxglhJrhSqAx2xcFunujmCoaUta6+p3+mJcCQwukjz2adwdQL9K4tC3lw33oKHwoa139xiAHFlygSkq+aLG7txUHVgzyRgy5YvldEoOMMa0mZiZIJsiLcirBPIMzQSYOMTdYNLUyaXY6UWm/ypWD5qC40P2UOMWsNG+VY3qCuElSCIlB+F+RpYJR+KA5aFwl3rNp5soRgxRIKiTRtZRM9+FE91PqU9ZS/BRTVzlikBjkBQFFbIoZRmsr8WaCNMRL30NUCApJdK0iLNovzUFxofspcRQ/peYqx/QEocUo7wMKKq2Fnk6K2Ny10OuPgjPt9yv3VmktBjkgRAVDxVuB//x6dYqdXSVikBt/L5YiBIU4Kiz3yRaDcLFRjnY3f9VHJkgmyItG6MFWCeuzTMeqjxgkBolBTlzyqf/DlPu0q04Tx6lIc9wVRzGlccoHJHQtfQrQ695xvxikoUQKtPJGapRlWUKFT+OoyClWCvZ0bQwiSokCTUkXy7Eup8KncTHIBD0KqG6gJ8r+EBqDaJ92KTpQsKdrM0EUdzzWUqAzQcZAf2mDrGhO1O+H5fT7GysEfRd+Sm/KgUDXUs4VLju1TD/S7yKYAqh8oqGIiNZ3F35Kb1RYVLwUKzeXtA/pinUXwXeBquR1v5s6BD9riEH41TgGefOOUEREjXTXAaP0Ro2ZCSIKiwJNxUbjKHGKiGgtMQhFahyncNnR39I3iAKNIiwlL70m0RzUhB0yZ69TNIdblHQ/5Q1C+ajiYpAKocHXqbAowbubkAraHUfxU/io6I9BKoRikOFv+acTXYmLQSbESYGe2LIdqpxYuWJpv4mFTqk2uX8szARpIBmD8B81oQcbxXQrg1DtKEUra1fUR3Mo1wE6Ve56q1AM3CK/C5djv9P/YUoRgnstJW6FCZXe7hKCklcxK+VDqY+atdJQDFIhJHx9dyEoAoxBJoRBhaCcshPlfAhV6luRVxGqclIqeWOQCWUoAlTW0hJX5FDMrwg1BhmrQMFFeoNQsVHS6acc1Aw0juZ1x9H6lBNayaHwRg8J2hutRem3MtL0GyQG4Z/juwmuyFSE8lxLa6a1KPvRtUrfVR8xyAFdxfx00lxJprJ3DDJGLwaJQV6UQU/t6uR1GI7WohwMVR8xSAwSg5w4zGKQKx08exK5H4DK1ak6nVb2RvugcQrnK9bSPiqOYpCCLQo0NabySQ/NsftbKgaZQKBy8MpTVhEgXRuDTIhDCKUHW6W/TJBMkBcEqLAE7S5ZSvuIQR50ULDoFKCfrlTgr5yOFAMat0TlQhLaR8XR0glCi6ZCpfgpgqb3eVqL+4pF8yrYUz4UnGkfNM7FWwxyQJyKqDp1KImOCUJz0d5W7OfGjx46nbwxSAxCPWF7q3SEOltkJsgEYsrodwF9Vi6tb6LlD6GZIBf8ZkU6uihxCknKqUMFSOtTanFjugL7vEHeoKycnlSUd4Hv7s1tGip8pQ+awx13V82dvJbfauI+FelJTs1F66Mi7wDtFtnZA5/2cVVN1b534dfJG4MUj3S3uSrxzH69Q/psDnf8XTV38sYgMYhb/+V+HaGWm4KATt4YJAYB0vKGdITqqKCTd/r7IEqh7oc7rYUCo8Qp7yHah3LdW9Gbwq+CgbK2eq/FIAd0V4hIITMGcaNXf28kBolBXlRHp4DySaNf5v0dM0Ee2CmTQRFCBX6f1t8rd+qNmsvRt2uPiqNMkEyQTJATty01iMv1z33cpyetj56U1ek02wetj75V3B8sUD5oHxRn2kenvhiEslVMGkoSFS81Fy2fik3J2xHgWf20Zop9p74YhCosBimR6ggwBilh7QdQQmgcrYSebPQ0dtdHpxQ9eRVcKAZKzbSPDs6ZIJT9TJASqY4AP/UEoSdliZwhgJ5EO5FETzYKj7s35dSmH3+74yimVLuVrqZ/FouS6Y6rGnnmc4uIAk37pX1Q8Sr70RyKKGMQqgwxjgohBtGApgeCW/h0P8WsdO0xLhOk0BMVDJUlNTo93ZX9aA4qLHo4KXFKLXRtDELV/IiLQcZg0RPfHUdFTnmrDpjpCVJtOKG9t6H0hKG5FLBWrFVIX8GHe9Ks4I3mqOJikANC9LRTBF0R8vw6rSUGqX9knWI+iotBYpCWfpTJShOuyFHVEoPEIJVGhl9fId4VOarmY5AYpNJIDPIOIfpYpk5X7u6737VbKvu1iL43lBwUe/ogv6tm2gfVboWpZYLEIBXM51+/S2z00KFiU3SgIEjxo/0ea4lBCmZWkE4JVkRET95MkFcEYpAYpPRdJsgbiFYAQ0/PzngsmQcBmSDaL70AEMshV2roU08QamCZgeYGSn10rWJgeugoOSh0VOT0qkhrrjCIQSiDjTgq8rvu/ZU4nnVRsTUg+n9JDPIGPQqMEqcQp6yNQTh6lN9MkAcCVFg0jtPkjVTqo2uV0z0TpP45rlyxvJ542Y2KPFesff+W/ZczCNU7PT0V8dJaVsTRSUNxofu5e6NXMdpHVV8MUiE0+LoyGRrpLEuooKmw6H6W4g+bxCDiG4QSQoWQCTJGNAa5Uaj0hFZIikHGwqe4KNjTQ0z5xIr2UdWSK1aFUK5YQ4RikIkJ0tDY6RJlgtCTYwXB7lrofgofFHslh7KW8ubCyjJBlIaVO75CJgVa6Y2SRGuh+yk1K5gqeena1VjFIJSZRhwV9GrSz1qJQV7RiUEawqdLYhCKFI9bfZjEIJyb6cgYZBqycsH2Bik7uCjA/Q0i91XCvZ/yNqNr3VRRjmhe936jvNUhNj1BaHPuOApW1fCzLreg3ftRkSv93sURzUs5p/vFIA8EFMHQtW7xUoIVE9KrCa2Fik3JG4NMsEHBoiJXxBaDjImjHFHa3ftRUx/jcsU6oEHNFYPEINTkiQsCXxqBT/1HPL80M2luCwRikC1oSBG7IhCD7MpM6toCgRhkCxpSxK4IxCC7MpO6tkAgBtmChhSxKwIxyK7MpK4tEPgPruHO83T8QqsAAAAASUVORK5CYII="
                                                    width="200" height="200"
                                                    style="width: 200px; height: 200px;"></div>
                                        </div>
                                    </div>
                                    <div class="container p-3">
                                        <fieldset>
                                            <div class="row mb-3">
                                                <label for="input-kantor"
                                                    class="col-sm-4 col-form-label form-label ">Kantor Tujuan</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" type="text" id="tujuan_akhir"
                                                        value="" disabled>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="input-antrean"
                                                    class="col-sm-4 col-form-label form-label">No. Antrean</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" type="text" value=""
                                                        id="no_antrian" disabled>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="input-kantor"
                                                    class="col-sm-4 col-form-label form-label">Nama Kantor</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" type="text" id="kantor"
                                                        name="kantor" value="" disabled>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="input-tiket"
                                                    class="col-sm-4 col-form-label form-label">NIK</label>
                                                <div class="col-sm-8 row align-items-center m-auto">
                                                    <input class="form-control col" type="text" id="nik_akhir"
                                                        value="" disabled>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="input-tiket"
                                                    class="col-sm-4 col-form-label form-label">Layanan</label>
                                                <div class="col-sm-8 row align-items-center m-auto">
                                                    <input class="form-control col" type="text" id="layanan_akhir"
                                                        value="" disabled>
                                                </div>
                                            </div>
                                            <div class="input-group">
                                                <label for="input-tiket"
                                                    class="col-sm-4 col-form-label form-label">Tanggal & Waktu</label>
                                                <input class="form-control" type="text" id="tanggal_akhir"
                                                    value="" disabled>
                                                &nbsp;
                                                <input class="form-control" type="text" id="waktu_akhir"
                                                    value="" disabled>

                                            </div>
                                        </fieldset>
                                        <small class="text-danger">
                                            <b>Catatan</b> : Pengubahan jenis layanan dan waktu pelayanan hanya dapat
                                            dilakukan maksimal H-1 sebelum pelayanan
                                            <br>
                                            <b>
                                                <p>**Tiket ini tidak berlaku jika Anda datang terlambat</p>
                                            </b>
                                            <b>
                                                <p>**Pengunjung wajib menunjukkan sertifikat vaksin covid-19</p>
                                            </b>

                                        </small>
                                        <div class="container mb-3 mx-auto d-flex justify-content-end mt-5"
                                            id="button-container">
                                            <a href="" class="btn btn-sm bg-success rounded-pill mr-3"
                                                onclick="event.preventDefault(); printTiket()">Simpan Tiket</a>
                                            <a class="btn-print btn-sm bg-success rounded-pill mr-3"
                                                onclick="window.print()">simpan PDF</a>
                                            <a class="btn btn-sm bg-success rounded-pill mr-3"
                                                href="/">Selesai</a>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Step 5-->
                            <!--begin::Actions-->
                            <div class="d-flex flex-stack pt-15">
                                <!--begin::Wrapper-->
                                <div class="mr-2">
                                    <button type="button" class="btn btn-lg btn-light-primary me-3"
                                        data-kt-stepper-action="previous">
                                        Kembali
                                    </button>
                                </div>
                                <!--end::Wrapper-->
                                <!--begin::Wrapper-->
                                <div>
                                    <input type="hidden" name="_token" id="csrf"
                                        value="{{ Session::token() }}">
                                    <button type="button" class="btn btn-lg btn-primary me-3"
                                        data-kt-stepper-action="submit" id="butsave">
                                        <span class="indicator-label">Kirim
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                                            <span class="svg-icon svg-icon-3 ms-2 me-0">
                                                <svg width="24" height="24" viewBox="0 0 24 24"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect opacity="0.5" x="18" y="13" width="13" height="2"
                                                        rx="1" transform="rotate(-180 18 13)"
                                                        fill="currentColor"></rect>
                                                    <path
                                                        d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                                        fill="currentColor"></path>
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </span>
                                        <span class="indicator-progress">Mengirim...
                                            <span
                                                class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                    <button type="button" class="btn btn-lg btn-success"
                                        data-kt-stepper-action="next" width="50">Lanjut
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->

                                        <!--end::Svg Icon-->
                                    </button>
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Actions-->
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Stepper-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Content container-->
    </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
