"use strict";

// Array untuk menyimpan data tiap form step
var form1 = [];
var form2 = [];
var form3 = [];
var form4 = [];
var form5 = [];

var KTCreateAccount = (function () {
    var modalEl,
        stepperEl,
        formEl,
        submitBtn,
        nextBtn,
        stepper,
        validations = [];

        async function checkDuplicate(step, data) {
            // Gunakan route{} jika tersedia di window.route_umkm_check_duplicate
            let baseRoute = (typeof window.route_umkm_check_duplicate !== "undefined")
            ? window.route_umkm_check_duplicate
            : "/sukma/Toko/check-duplicate";

            // Hilangkan trailing slash jika ada
            if (baseRoute.endsWith("/")) baseRoute = baseRoute.slice(0, -1);

            const csrf = document.querySelector('meta[name="csrf-token"]');
            let url = `${baseRoute}/${step}`;
            let fd = new FormData();
            if (data && typeof data === "object") {
            Object.keys(data).forEach(key => {
                fd.append(key, data[key]);
            });
            }
            fd.append("step", step); // kirim juga stepnya
            if (csrf) {
            fd.append("_token", csrf.getAttribute("content"));
            }
            // AJAX jQuery
            return new Promise((resolve) => {
            $.ajax({
                url: url,
                method: "POST",
                data: fd,
                processData: false,
                contentType: false,
                success: function (res) {
                resolve(res);
                },
                error: function (xhr) {
                let msg = "Terjadi kesalahan pada server.";
                if (xhr && xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                resolve({
                    status: "error",
                    message: msg
                });
                }
            });
            });
        }

    return {
        init: function () {
            // Modal
            modalEl = document.querySelector("#kt_modal_create_account");
            if (modalEl) new bootstrap.Modal(modalEl);

            // Stepper
            stepperEl = document.querySelector("#kt_create_account_stepper");
            if (!stepperEl) return;

            formEl = stepperEl.querySelector("#kt_create_account_form");
            submitBtn = stepperEl.querySelector('[data-kt-stepper-action="submit"]');
            nextBtn = stepperEl.querySelector('[data-kt-stepper-action="next"]');
            stepper = new KTStepper(stepperEl);

            // Stepper changed event
            stepper.on("kt.stepper.changed", function () {
                var idx = stepper.getCurrentStepIndex();
                if (idx === 4) {
                    submitBtn.classList.remove("d-none");
                    submitBtn.classList.add("d-inline-block");
                    nextBtn.classList.add("d-none");
                } else if (idx === 5) {
                    submitBtn.classList.add("d-none");
                    nextBtn.classList.add("d-none");
                } else {
                    submitBtn.classList.remove("d-inline-block", "d-none");
                    nextBtn.classList.remove("d-none");
                }
            });

            // Stepper next event
            stepper.on("kt.stepper.next", async function (e) {
                var idx = stepper.getCurrentStepIndex();
                // Validasi step per step
                if (idx === 1) {
                    // Form 1: Data UMKM
                    form1 = [];
                    var nama_toko = document.getElementById("nama_toko").value.trim();
                    var no_hp = document.getElementById("no_hp").value.trim();
                    var kategori_toko = document.getElementById("kategori_toko").value.trim();
                    var alamat_toko = document.getElementById("alamat_toko").value.trim();
                    var logo_toko = document.getElementById("logo_toko").files.length > 0
                        ? document.getElementById("logo_toko").files[0]
                        : null;
                    var deskripsi_toko = document.getElementById("deskripsi_toko").value.trim();
                    form1.push(nama_toko, no_hp, kategori_toko, alamat_toko, logo_toko, deskripsi_toko);

                    if (
                        nama_toko === "" ||
                        no_hp === "" ||
                        kategori_toko === "" ||
                        alamat_toko === "" ||
                        !logo_toko ||
                        deskripsi_toko === ""
                    ) {
                        Swal.fire({
                            text: "Semua field harus diisi sebelum melanjutkan",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "cek",
                            customClass: { confirmButton: "btn btn-light" },
                        }).then(KTUtil.scrollTop);
                        return false;
                    }
                    var hpRegex = /^[0-9]{9,13}$/;
                    if (!hpRegex.test(no_hp)) {
                        Swal.fire({
                            text: "No. HP harus berupa angka dan 9-13 digit",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "cek",
                            customClass: { confirmButton: "btn btn-light" },
                        }).then(KTUtil.scrollTop);
                        return false;
                    }
                    if (logo_toko && !logo_toko.type.startsWith("image/")) {
                        Swal.fire({
                            text: "Logo toko harus berupa file gambar",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "cek",
                            customClass: { confirmButton: "btn btn-light" },
                        }).then(KTUtil.scrollTop);
                        return false;
                    }
                    // Cek ke server apakah nama_toko atau no_hp sudah ada
                    let check = await checkDuplicate(1, { nama_toko, no_hp });
                    if (check.status === "error") {
                        Swal.fire({
                            text: check.message || "Nama toko atau No. HP sudah terdaftar.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "cek",
                            customClass: { confirmButton: "btn btn-light" },
                        }).then(KTUtil.scrollTop);
                        return false;
                    }
                } else if (idx === 2) {
                    // Form 2: Dokumen Kepemilikan
                    form2 = [];
                    var nama_ktp = document.getElementById("nama_ktp").value.trim();
                    var nomor_ktp = document.getElementById("nomor_ktp").value.trim();
                    var nomor_kk = document.getElementById("nomor_kk").value.trim();
                    var foto_ktp = document.getElementById("foto_ktp").files.length > 0
                        ? document.getElementById("foto_ktp").files[0]
                        : null;
                    var foto_kk = document.getElementById("foto_kk").files.length > 0
                        ? document.getElementById("foto_kk").files[0]
                        : null;
                    form2.push(nama_ktp, nomor_ktp, nomor_kk, foto_ktp, foto_kk);

                    if (
                        nama_ktp === "" ||
                        nomor_ktp === "" ||
                        nomor_kk === "" ||
                        !foto_ktp ||
                        !foto_kk
                    ) {
                        Swal.fire({
                            text: "Semua field dokumen harus diisi sebelum melanjutkan",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "cek",
                            customClass: { confirmButton: "btn btn-light" },
                        }).then(KTUtil.scrollTop);
                        return false;
                    }
                    var nomorRegex = /^[0-9]{16}$/;
                    if (!nomorRegex.test(nomor_ktp)) {
                        Swal.fire({
                            text: "Nomor KTP harus 16 digit angka",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "cek",
                            customClass: { confirmButton: "btn btn-light" },
                        }).then(KTUtil.scrollTop);
                        return false;
                    }
                    if (!nomorRegex.test(nomor_kk)) {
                        Swal.fire({
                            text: "Nomor KK harus 16 digit angka",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "cek",
                            customClass: { confirmButton: "btn btn-light" },
                        }).then(KTUtil.scrollTop);
                        return false;
                    }
                    if (foto_ktp && !foto_ktp.type.startsWith("image/")) {
                        Swal.fire({
                            text: "Foto KTP harus berupa file gambar",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "cek",
                            customClass: { confirmButton: "btn btn-light" },
                        }).then(KTUtil.scrollTop);
                        return false;
                    }
                    if (foto_kk && !foto_kk.type.startsWith("image/")) {
                        Swal.fire({
                            text: "Foto KK harus berupa file gambar",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "cek",
                            customClass: { confirmButton: "btn btn-light" },
                        }).then(KTUtil.scrollTop);
                        return false;
                    }
                    // Cek ke server apakah nomor_ktp atau nomor_kk sudah ada
                    let check = await checkDuplicate(2, { nomor_ktp, nomor_kk });
                    if (check.status === "error") {
                        Swal.fire({
                            text: check.message || "NIK atau Nomor KK sudah terdaftar.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "cek",
                            customClass: { confirmButton: "btn btn-light" },
                        }).then(KTUtil.scrollTop);
                        return false;
                    }
                } else if (idx === 3) {
                    // Form 3: Informasi Rekening
                    form3 = [];
                    var nama_bank = document.getElementById("nama_bank").value.trim();
                    var nomor_rekening = document.getElementById("nomor_rekening").value.trim();
                    var nama_pemilik = document.getElementById("nama_pemilik").value.trim();
                    form3.push(nama_bank, nomor_rekening, nama_pemilik);

                    if (nama_bank === "" || nomor_rekening === "" || nama_pemilik === "") {
                        Swal.fire({
                            text: "Semua field informasi rekening harus diisi sebelum melanjutkan",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "cek",
                            customClass: { confirmButton: "btn btn-light" },
                        }).then(KTUtil.scrollTop);
                        return false;
                    }
                    var rekeningRegex = /^[0-9]{1,30}$/;
                    if (!rekeningRegex.test(nomor_rekening)) {
                        Swal.fire({
                            text: "Nomor rekening harus berupa angka dan maksimal 30 digit",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "cek",
                            customClass: { confirmButton: "btn btn-light" },
                        }).then(KTUtil.scrollTop);
                        return false;
                    }
                    if (nama_pemilik.length > 100) {
                        Swal.fire({
                            text: "Nama pemilik rekening maksimal 100 karakter",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "cek",
                            customClass: { confirmButton: "btn btn-light" },
                        }).then(KTUtil.scrollTop);
                        return false;
                    }
                    // Cek ke server apakah nomor_rekening sudah ada
                    let check = await checkDuplicate(3, { nomor_rekening });
                    if (check.status === "error") {
                        Swal.fire({
                            text: check.message || "Nomor rekening sudah terdaftar.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "cek",
                            customClass: { confirmButton: "btn btn-light" },
                        }).then(KTUtil.scrollTop);
                        return false;
                    }
                    // Set ke field konfirmasi jika diperlukan
                    $("#conf-nama-bank").val(form3[0]);
                    $("#conf-nomor-rekening").val(form3[1]);
                    $("#conf-nama-pemilik").val(form3[2]);
                } else if (idx === 4) {
                    // Form 4: Kontak & Sosial Media
                    form4 = [];
                    var email_cs = document.getElementById("email_cs").value.trim();
                    var wa_cs = document.getElementById("wa_cs").value.trim();
                    var instagram = document.getElementById("instagram").value.trim();
                    var facebook = document.getElementById("facebook").value.trim();
                    var tiktok = document.getElementById("tiktok").value.trim();
                    var google_maps = document.getElementById("google_maps").value.trim();
                    form4.push(email_cs, wa_cs, instagram, facebook, tiktok, google_maps);

                    if (email_cs === "" || wa_cs === "") {
                        Swal.fire({
                            text: "Email CS dan Whatsapp CS wajib diisi.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "cek",
                            customClass: { confirmButton: "btn btn-light" },
                        }).then(KTUtil.scrollTop);
                        return false;
                    }
                    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(email_cs)) {
                        Swal.fire({
                            text: "Format Email CS tidak valid.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "cek",
                            customClass: { confirmButton: "btn btn-light" },
                        }).then(KTUtil.scrollTop);
                        return false;
                    }
                    var waRegex = /^[0-9]{9,15}$/;
                    if (!waRegex.test(wa_cs)) {
                        Swal.fire({
                            text: "Nomor Whatsapp CS harus berupa angka dan 9-15 digit.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "cek",
                            customClass: { confirmButton: "btn btn-light" },
                        }).then(KTUtil.scrollTop);
                        return false;
                    }
                    if (google_maps !== "") {
                        try {
                            new URL(google_maps);
                        } catch (e) {
                            Swal.fire({
                                text: "Link Google Maps tidak valid.",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "cek",
                                customClass: { confirmButton: "btn btn-light" },
                            }).then(KTUtil.scrollTop);
                            return false;
                        }
                    }
                    // Cek ke server apakah email_cs atau wa_cs sudah ada
                    let check = await checkDuplicate(4, { email_cs, wa_cs });
                    if (check.status === "error") {
                        Swal.fire({
                            text: check.message || "Email CS atau Whatsapp CS sudah terdaftar.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "cek",
                            customClass: { confirmButton: "btn btn-light" },
                        }).then(KTUtil.scrollTop);
                        return false;
                    }
                } else if (idx === 5) {
                    // Form 5: Jam Operasional Toko
                    form5 = [];
                    var hariChecked = [];
                    var hariList = ["senin", "selasa", "rabu", "kamis", "jumat", "sabtu", "minggu"];
                    hariList.forEach(function (hari) {
                        var el = document.getElementById(hari);
                        if (el && el.checked) hariChecked.push(el.value);
                    });
                    var jam_buka = document.getElementById("jam_buka").value;
                    var jam_tutup = document.getElementById("jam_tutup").value;
                    form5.push(hariChecked, jam_buka, jam_tutup);

                    if (hariChecked.length === 0) {
                        Swal.fire({
                            text: "Pilih minimal satu hari operasional.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "cek",
                            customClass: { confirmButton: "btn btn-light" },
                        }).then(KTUtil.scrollTop);
                        return false;
                    }
                    if (jam_buka === "" || jam_tutup === "") {
                        Swal.fire({
                            text: "Jam buka dan jam tutup wajib diisi.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "cek",
                            customClass: { confirmButton: "btn btn-light" },
                        }).then(KTUtil.scrollTop);
                        return false;
                    }
                    if (jam_buka >= jam_tutup) {
                        Swal.fire({
                            text: "Jam buka harus lebih awal dari jam tutup.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "cek",
                            customClass: { confirmButton: "btn btn-light" },
                        }).then(KTUtil.scrollTop);
                        return false;
                    }
                }

                // Validasi FormValidation.js
                var validator = validations[idx - 1];
                if (validator) {
                    validator.validate().then(function (status) {
                        if (status === "Valid") {
                            stepper.goNext();
                            KTUtil.scrollTop();
                        } else {
                            Swal.fire({
                                text: "Jangan ada data yang terlewat, mohon periksa kembali",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "cek",
                                customClass: { confirmButton: "btn btn-light" },
                            }).then(KTUtil.scrollTop);
                        }
                    });
                } else {
                    stepper.goNext();
                    KTUtil.scrollTop();
                }
            });

            // Stepper previous event
            stepper.on("kt.stepper.previous", function (e) {
                e.goPrevious();
                KTUtil.scrollTop();
            });

            // Validasi FormValidation.js per step
            validations.push(
                // Step 1
                FormValidation.formValidation(formEl, {
                    fields: {
                        nama_toko: {
                            validators: {
                                notEmpty: { message: "Nama toko wajib diisi" }
                            }
                        },
                        no_hp: {
                            validators: {
                                notEmpty: { message: "No. HP wajib diisi" },
                                regexp: {
                                    regexp: /^[0-9]{9,13}$/,
                                    message: "No. HP harus berupa angka dan 9-13 digit"
                                },
                            },
                        },
                        kategori_toko: {
                            validators: {
                                notEmpty: { message: "Kategori toko wajib diisi" }
                            }
                        },
                        alamat_toko: {
                            validators: {
                                notEmpty: { message: "Alamat toko wajib diisi" }
                            }
                        },
                        logo_toko: {
                            validators: {
                                notEmpty: { message: "Logo toko wajib diisi" },
                                file: {
                                    extension: 'jpg,jpeg,png,gif,webp',
                                    type: 'image/jpeg,image/png,image/gif,image/webp',
                                    message: "Logo toko harus berupa file gambar",
                                },
                            },
                        },
                        deskripsi_toko: {
                            validators: {
                                notEmpty: { message: "Deskripsi toko wajib diisi" }
                            }
                        },
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: ".fv-row",
                            eleInvalidClass: "",
                            eleValidClass: "",
                        }),
                    },
                }),
                // Step 2
                FormValidation.formValidation(formEl, {
                    fields: {
                        nama_ktp: {
                            validators: {
                                notEmpty: { message: "Nama sesuai KTP wajib diisi" }
                            }
                        },
                        nomor_ktp: {
                            validators: {
                                notEmpty: { message: "Nomor KTP wajib diisi" },
                                regexp: {
                                    regexp: /^[0-9]{16}$/,
                                    message: "Nomor KTP harus 16 digit angka"
                                },
                            },
                        },
                        nomor_kk: {
                            validators: {
                                notEmpty: { message: "Nomor KK wajib diisi" },
                                regexp: {
                                    regexp: /^[0-9]{16}$/,
                                    message: "Nomor KK harus 16 digit angka"
                                },
                            },
                        },
                        foto_ktp: {
                            validators: {
                                notEmpty: { message: "Foto KTP wajib diupload" },
                                file: {
                                    extension: 'jpg,jpeg,png,gif,webp',
                                    type: 'image/jpeg,image/png,image/gif,image/webp',
                                    message: "Foto KTP harus berupa file gambar",
                                },
                            },
                        },
                        foto_kk: {
                            validators: {
                                notEmpty: { message: "Foto KK wajib diupload" },
                                file: {
                                    extension: 'jpg,jpeg,png,gif,webp',
                                    type: 'image/jpeg,image/png,image/gif,image/webp',
                                    message: "Foto KK harus berupa file gambar",
                                },
                            },
                        },
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: ".fv-row",
                            eleInvalidClass: "",
                            eleValidClass: "",
                        }),
                    },
                }),
                // Step 3
                FormValidation.formValidation(formEl, {
                    fields: {
                        nama_bank: {
                            validators: {
                                notEmpty: { message: "Nama bank wajib diisi" }
                            }
                        },
                        nomor_rekening: {
                            validators: {
                                notEmpty: { message: "Nomor rekening wajib diisi" },
                                regexp: {
                                    regexp: /^[0-9]{1,30}$/,
                                    message: "Nomor rekening harus berupa angka dan maksimal 30 digit"
                                },
                            },
                        },
                        nama_pemilik: {
                            validators: {
                                notEmpty: { message: "Nama pemilik rekening wajib diisi" },
                                stringLength: {
                                    max: 100,
                                    message: "Nama pemilik rekening maksimal 100 karakter"
                                },
                            },
                        },
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: ".fv-row",
                            eleInvalidClass: "",
                            eleValidClass: "",
                        }),
                    },
                }),
                // Step 4
                FormValidation.formValidation(formEl, {
                    fields: {
                        email_cs: {
                            validators: {
                                notEmpty: { message: "Email CS wajib diisi" },
                                emailAddress: { message: "Format Email CS tidak valid" },
                            },
                        },
                        wa_cs: {
                            validators: {
                                notEmpty: { message: "Whatsapp CS wajib diisi" },
                                regexp: {
                                    regexp: /^[0-9]{9,15}$/,
                                    message: "Nomor Whatsapp CS harus berupa angka dan 9-15 digit"
                                },
                            },
                        },
                        instagram: { validators: {} },
                        facebook: { validators: {} },
                        tiktok: { validators: {} },
                        google_maps: {
                            validators: {
                                uri: { message: "Link Google Maps tidak valid" },
                            },
                        },
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: ".fv-row",
                            eleInvalidClass: "",
                            eleValidClass: "",
                        }),
                    },
                }),
                // Step 5
                FormValidation.formValidation(formEl, {
                    fields: {
                        jam_buka: {
                            validators: {
                                notEmpty: { message: "Jam buka wajib diisi" }
                            }
                        },
                        jam_tutup: {
                            validators: {
                                notEmpty: { message: "Jam tutup wajib diisi" }
                            }
                        },
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: ".fv-row",
                            eleInvalidClass: "",
                            eleValidClass: "",
                        }),
                    },
                })
            );

            // Submit handler
            if (submitBtn) {
                submitBtn.addEventListener("click", function () {
                    validations[4].validate().then(function (status) {
                        if (status === "Valid") {
                            // Inisialisasi FormData
                            var formData = new FormData();

                            // Step-by-step FormData builder
                            var steps = [1, 2, 3, 4, 5];

                            const csrf = document.querySelector('meta[name="csrf-token"]');
                            const baseRoute = (typeof window.route_umkm_register !== "undefined")
                                ? window.route_umkm_register
                                : "/Toko/umkm/register";

                            // Loop tiap step kirim satu-satu
                            const processStep = async (step) => {
                                const fd = new FormData();

                                if (step === 1) {
                                    fd.append("nama_toko", document.getElementById("nama_toko").value.trim());
                                    fd.append("no_hp", document.getElementById("no_hp").value.trim());
                                    fd.append("kategori_toko", document.getElementById("kategori_toko").value.trim());
                                    fd.append("alamat_toko", document.getElementById("alamat_toko").value.trim());
                                    const logo = document.getElementById("logo_toko").files[0];
                                    if (logo) fd.append("logo_toko", logo);
                                    fd.append("deskripsi_toko", document.getElementById("deskripsi_toko").value.trim());
                                }

                                if (step === 2) {
                                    fd.append("nama_ktp", document.getElementById("nama_ktp").value.trim());
                                    fd.append("nomor_ktp", document.getElementById("nomor_ktp").value.trim());
                                    fd.append("nomor_kk", document.getElementById("nomor_kk").value.trim());
                                    const ktp = document.getElementById("foto_ktp").files[0];
                                    const kk = document.getElementById("foto_kk").files[0];
                                    if (ktp) fd.append("foto_ktp", ktp);
                                    if (kk) fd.append("foto_kk", kk);
                                }

                                if (step === 3) {
                                    fd.append("nama_bank", document.getElementById("nama_bank").value.trim());
                                    fd.append("nomor_rekening", document.getElementById("nomor_rekening").value.trim());
                                    fd.append("nama_pemilik", document.getElementById("nama_pemilik").value.trim());
                                }

                                if (step === 4) {
                                    fd.append("email_cs", document.getElementById("email_cs").value.trim());
                                    fd.append("wa_cs", document.getElementById("wa_cs").value.trim());
                                    fd.append("instagram", document.getElementById("instagram").value.trim());
                                    fd.append("facebook", document.getElementById("facebook").value.trim());
                                    fd.append("tiktok", document.getElementById("tiktok").value.trim());
                                    fd.append("google_maps", document.getElementById("google_maps").value.trim());
                                }

                                if (step === 5) {
                                    const hariList = ["senin", "selasa", "rabu", "kamis", "jumat", "sabtu", "minggu"];
                                    const hariChecked = [];
                                    hariList.forEach(hari => {
                                        const el = document.getElementById(hari);
                                        if (el && el.checked) hariChecked.push(el.value);
                                    });
                                    fd.append("hari_operasional", JSON.stringify(hariChecked));
                                    fd.append("jam_buka", document.getElementById("jam_buka").value);
                                    fd.append("jam_tutup", document.getElementById("jam_tutup").value);
                                }

                                // Tambahkan token CSRF
                                if (csrf) {
                                    fd.append("_token", csrf.getAttribute("content"));
                                }

                                // Fetch per step
                                const response = await fetch(`${baseRoute}/${step}`, {
                                    method: 'POST',
                                    body: fd
                                });

                                return await response.json();
                            };

                            // Jalankan semua step satu per satu
                            const submitAll = async () => {
                                try {
                                    submitBtn.disabled = true;
                                    submitBtn.setAttribute("data-kt-indicator", "on");

                                    for (let i = 0; i < steps.length; i++) {
                                        const step = steps[i];
                                        const result = await processStep(step);

                                        if (result.status !== "success") {
                                            throw new Error(result.message || `Step ${step} gagal`);
                                        }
                                    }

                                    submitBtn.removeAttribute("data-kt-indicator");
                                    submitBtn.disabled = false;

                                    Swal.fire({
                                        text: "Pendaftaran UMKM berhasil!",
                                        icon: "success",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok",
                                        customClass: { confirmButton: "btn btn-primary" },
                                    }).then(function () {
                                        if (formEl.hasAttribute("data-kt-redirect-url")) {
                                            location.href = formEl.getAttribute("data-kt-redirect-url");
                                        } else {
                                            location.reload();
                                        }
                                    });
                                } catch (error) {
                                    submitBtn.removeAttribute("data-kt-indicator");
                                    submitBtn.disabled = false;

                                    Swal.fire({
                                        text: error.message || "Gagal mengirim data. Silakan coba lagi.",
                                        icon: "error",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok",
                                        customClass: { confirmButton: "btn btn-light" },
                                    });
                                }
                            };

                            submitAll(); // Panggil fungsi utama
                        } else {
                            Swal.fire({
                                text: "Jangan ada data yang terlewat, mohon periksa kembali",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "cek",
                                customClass: { confirmButton: "btn btn-light" },
                            }).then(KTUtil.scrollTop);
                        }
                    });
                });
            }
        },
    };
})();

KTUtil.onDOMContentLoaded(function () {
    KTCreateAccount.init();
});
