<!doctype html>
<html lang="en">
@include('layout.head')

<body>

    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="#">{{ config('app.name') }}</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </header>

    <div class="container-fluid">
        <div class="row">
            @include('layout.sidebar')
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">
                        {{ Request::segment(1) == null ? 'DASHBOARD' : strtoupper(Request::segment(1)) }}
                    </h1>
                </div>
                @yield('contents')
            </main>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"
        integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"
        integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <style>
        table {
            font-size: 12px;
        }

        .borderless th,
        .borderless td {
            border: none;
            height: 5px !important;
            padding: 5px !important;
        }
    </style>
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script>
        function formatTanggal(oldTgl) {
            let t = new Date(oldTgl);
            let bulan = '';
            switch ((t.getMonth() + 1)) {
                case 1:
                    bulan = "Januari";
                    break;
                case 2:
                    bulan = "Februari";
                    break;
                case 3:
                    bulan = "Maret";
                    break;
                case 4:
                    bulan = "April";
                    break;
                case 5:
                    bulan = "Mei";
                    break;
                case 6:
                    bulan = "Juni";
                    break;
                case 7:
                    bulan = "Juli";
                    break;
                case 8:
                    bulan = "Agustus";
                    break;
                case 9:
                    bulan = "September";
                    break;
                case 10:
                    bulan = "Oktober";
                    break;
                case 11:
                    bulan = "November";
                    break;
                case 12:
                    bulan = "Desember";
                    break;
                default:
                    break;
            }
            return tanggal = t.getDate() + ' ' + bulan + ' ' + t.getFullYear();
        }

        function isKosong(x, satuan = '') {
            return x ? x + satuan : '-';
        }



        function pemberianObat(obat) {
            console.log(Object.keys(obat).length)
            if (Object.keys(obat).length > 0) {
                var pemberian = '<table class="table table-success borderless mb-0">';
                obat.forEach(function(o) {
                    console.log(o)
                    pemberian += '<tr><td>' + formatTanggal(o.tgl_perawatan) + ', Jam ' +
                        o.jam + '</td><td>: <strong>' + o.data_barang.nama_brng + '</strong></td><td> ' +
                        o.jml + ' ' + o.data_barang.kode_satuan.satuan + '</td><td>' +
                        (o.aturan_pakai != null ? o.aturan_pakai.aturan : '') + '</td><tr>';
                })
                pemberian += '</table>'
                return '<tr><td>Pemberian Obat</td><td>' + pemberian + '</td></tr>';
            }
            return '';
        }

        function diagnosaPasien(diagnosa) {
            if (Object.keys(diagnosa).length > 0) {
                var diagnosaPasien = '<table class="table table-success borderless mb-0">';
                diagnosa.forEach(function(d) {
                    diagnosaPasien +=
                        '<tr><td style="width:5%"><strong>' + d.kd_penyakit + '</strong></td><td>: ' + d
                        .penyakit
                        .nm_penyakit + '</td><tr>';
                })
                diagnosaPasien += '</table>'
                return '<tr><td>Diagnosa</td><td>' + diagnosaPasien + '</td></tr>';
            }
            return '';
        }

        function resume(d) {
            var detail = '';
            var pemeriksaan = '';
            var diagnosa = '';
            d.reg_periksa.forEach(function(i) {
                i.pemeriksaan_ralan.forEach(function(x) {
                    pemeriksaan = '<tr><td>Pemeriksaan</td><td>' +
                        '<div class="row">' +
                        '<div class="col-sm-4">' +
                        '<table class="table table-sm text-sm borderless table-success mb-2">' +
                        '<tr><td style="width=12%">Tanggal Rawat</td><td>: ' + formatTanggal(x
                            .tgl_perawatan) + ' ' + x
                        .jam_rawat + '</td></tr>' +
                        '<tr><td>Tinggi</td><td>: ' + isKosong(x.tinggi, ' cm') + '</td><tr>' +
                        '<tr><td>Berat Badan</td><td>: ' + isKosong(x.berat, ' Kg') + '</td><tr>' +
                        '<tr><td>Suhu</td><td>: ' + isKosong(x.suhu_tubuh, ' <sup>o</sup>C') + '</td><tr>' +
                        '<tr><td>Tensi</td><td>: ' + isKosong(x.tensi) + '</td><tr>' +
                        '<tr><td>Kesadaran</td><td>: ' + isKosong(x.kesadaran) + '</td><tr>' +
                        '<tr><td>Respirasi</td><td>: ' + isKosong(x.respirasi) +
                        '<tr><td>GCS(E,V,M)</td><td>: ' + isKosong(x.gcs) +
                        '<tr><td>Alergi</td><td>: ' + isKosong(x.alergi) +
                        '<tr><td>Imunisasi</td><td>: ' + isKosong(x.imun_ke) +
                        '</td><tr>' +
                        '</tr>' +
                        '</table>' +
                        '</div>' +
                        '<div class="col-sm-8">' +
                        '<table class="table table-sm text-sm borderless table-success">' +
                        '<tr>' +
                        '<tr><td style="width:10%">Subject</td><td>: ' + isKosong(x.keluhan) + '</td><tr>' +
                        '<tr><td>Object</td><td>: ' + isKosong(x.pemeriksaan) + '</td><tr>' +
                        '<tr><td>Assesment</td><td>: ' + isKosong(x.penilaian) + '</td><tr>' +
                        '<tr><td>Plan</td><td>: ' + isKosong(x.rtl) + '</td><tr>' +
                        '</table>' +
                        '</div>' +
                        '</td></tr>';
                    // console.log(x)
                })


                // var pemberianObat = '<table class="table table-success borderless mb-0">';

                // i.detail_pemberian_obat.forEach(function(o) {
                //     pemberianObat += '<tr><td>' + formatTanggal(o.tgl_perawatan) + ', Jam ' + o
                //         .jam + '</td><td>:<strong>' + o.data_barang.nama_brng + '</strong></td><td> ' + o
                //         .jml +
                //         ' ' + o.data_barang.kode_satuan.satuan + '</td><td>' + o.aturan_pakai
                //         .aturan + '</td><tr>';
                //     console.log(o);
                // })
                // pemberianObat += '</table>'
                // obat = '<tr><td>Pemberian Obat</td><td>' + pemberianObat + '</td></tr>';

                detail +=
                    '<tr>' +
                    '<td colspan="2" align="center" class="table-dark"><strong>' + i.status_lanjut +
                    '</strong></td>' +
                    '</tr>' +
                    '<tr><td style="width:15%">Tanggal Daftar</td><td>: ' + i.no_rawat + '</td></tr>' +
                    '<tr><td>No Rawat</td><td>: ' + formatTanggal(i.tgl_registrasi) + ' ' + i.jam_reg +
                    '</td></tr>' +
                    '<tr><td>Unit/Poliklinik</td><td>: ' + i.poliklinik.nm_poli + '</td></tr>' +
                    '<tr><td>Dokter</td><td>: ' + i.dokter.nm_dokter + '</td></tr>' +
                    '<tr><td>Cara Bayar</td><td>: ' + i.penjab.png_jawab + '</td></tr>' +

                    diagnosaPasien(i.diagnosa_pasien) + pemeriksaan + pemberianObat(i.detail_pemberian_obat) +
                    '</tr>'
                // console.log(i)
            });
            return (
                '<table class="table table-bordered table-responsive" cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +

                detail +
                '</table>'
            );
        }

        function tb_pasien() {
            var table = $('#tb_pasien').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "table/{{ Request::segment(2) }}?dokter={{ Request::get('dokter') }}",
                },
                columns: [{
                        className: 'dt-control',
                        orderable: false,
                        data: null,
                        defaultContent: '',
                    },
                    {
                        data: 'no_reg',
                        name: 'no_reg'
                    },
                    {
                        data: 'nm_pasien',
                        name: 'nm_pasien'

                    },
                    {
                        data: 'upload',
                        name: 'upload',
                    }

                ],
                order: [
                    [1, 'asc']
                ],
            });
            $('#tb_pasien tbody').on('click', 'td.dt-control', function() {
                var tr = $(this).closest('tr');
                var row = table.row(tr);
                var dataPeriksa = [];

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    // Open this row
                    $.ajax({
                        url: '/upload-erm/test/' + row.data().no_rkm_medis,
                        method: 'GET',
                        dataType: 'JSON',
                        success: function(data) {
                            data.forEach(function(item, index) {
                                dataPeriksa = item;
                                // console.log(dataPeriksa)
                                row.child(resume(dataPeriksa)).show();
                                tr.addClass('shown');
                                tr.removeClass('shown');
                            })
                        }
                    })


                }
            });
        }

        function detailPeriksa(no_rawat, status) {
            $('#upload-image').css('visibility', 'hidden')
            $('#form-upload').css('visibility', 'visible')
            $('#image .tmb').detach()
            $.ajax({
                url: '/upload-erm/periksa/detail?no_rawat=' + no_rawat,
                method: "GET",
                dataType: 'JSON',
                success: function(data) {
                    $('#no_rawat').val(data.no_rawat)
                    $('#no_rkm_medis').val(data.no_rkm_medis)
                    $('#tgl_masuk').val(data.tgl_registrasi)
                    $('#td_no_rawat').text(data.no_rawat)
                    $('#td_nm_pasien').text(data.pasien.nm_pasien)
                    $('#td_tgl_reg').text(data.tgl_registrasi)
                    if (data.kamar_inap != null) {
                        $('#td_tgl_pulang').text(data.kamar_inap.tgl_keluar)
                    } else {
                        $('#td_tgl_pulang').text("-")
                    }
                    $('#infoReg').css('visibility', 'visible')


                    $('#button-form label').detach()
                    $('#button-form input').detach()



                    if (status == "Ralan") {
                        html =
                            '<input type="radio" class="btn-check" name="kategori" id="opt-usg" autocomplete="off" onclick="showForm()" value="usg"><label class="btn btn-outline-primary btn-sm" for="opt-usg">USG</label>' +
                            '<input type="radio" class="btn-check" name="kategori" id="opt-laborat" autocomplete="off" onclick="showForm()" value="laborat"><label class="btn btn-outline-primary btn-sm" for="opt-laborat">Laboratorium</label>' +
                            '<input type="radio" class="btn-check" name="kategori" id="opt-radiologi" autocomplete="off" onclick="showForm()" value="radiologi"><label class="btn btn-outline-primary btn-sm" for="opt-radiologi">Radiologi</label>'
                        $('#button-form').append(html)
                    } else {
                        html =
                            '<input type="radio" class="btn-check" name="kategori" id="opt-resume" autocomplete="off" onclick="showForm()" value="resume"><label class="btn btn-outline-primary btn-sm" for="opt-resume">Resume Medis</label>' +
                            '<input type="radio" class="btn-check" name="kategori" id="opt-laborat" autocomplete="off" onclick="showForm()" value="laborat"><label class="btn btn-outline-primary btn-sm" for="opt-laborat">Laboratorium</label>' +
                            '<input type="radio" class="btn-check" name="kategori" id="opt-radiologi" autocomplete="off" onclick="showForm()" value="radiologi"><label class="btn btn-outline-primary btn-sm" for="opt-radiologi">Radiologi</label>' +
                            '<input type="radio" class="btn-check" name="kategori" id="opt-operasi" autocomplete="off" onclick="showForm()" value="operasi"><label class="btn btn-outline-primary btn-sm" for="opt-operasi">Operasi</label>' +
                            '<input type="radio" class="btn-check" name="kategori" id="opt-lain" autocomplete="off" onclick="showForm()" value="lainnya"><label class="btn btn-outline-primary btn-sm" for="opt-lain">Lainnya</label>'

                        $('#button-form').append(html)
                    }
                }
            })
        }

        function showForm(no_rawat = '', kategori = '') {
            $('#submit').hide()

            if (!no_rawat && !kategori) {
                no_rawat = $('#no_rawat').val();
                kategori = event.target.value;
            }


            var img = '';
            $('#image .tmb').detach()
            $.ajax({
                url: '/upload-erm/upload/show?no_rawat=' + no_rawat + '&kategori=' + kategori,
                method: 'GET',
                dataType: 'JSON',
                success: function(data) {
                    countData = Object.keys(data).length
                    if (countData > 0) {
                        img = data.file.split(',');
                        $.map(img, function(file) {
                            $('#image').append(
                                '<div class="tmb col-sm-4"><img class="img-thumbnail position-relative" src="{{ asset('erm') }}/' +
                                file +
                                '" /><span style="cursor:pointer" class="badge text-bg-danger" onclick=deleteImage(' +
                                data.id + ',"' + file + '")>Hapus</span></div>')
                        })
                    }
                    $('#upload-image').css('visibility', 'visible')
                }
            })

        }

        function previewImage(input) {
            if (input.files && input.files[0]) {

                $('input[name="kategori"]').each(function(index) {
                    if ($(this).prop('checked') != true) {
                        $(this).prop('disabled', true);
                    }
                })
                $('#submit').show()
                countImage = input.files.length;
                for (let index = 0; index < countImage; index++) {
                    var reader = new FileReader();
                    reader.readAsDataURL(input.files[index]);
                    reader.onload = function(e) {
                        var file = e.target;
                        var fileName = input.files[index].name
                        $('#preview').append('<div class="pip col-sm-3"><input type="hidden" name="images" value="' +
                            file.result + '" class="images"><img width="75%" src="' + file.result + '" title="' +
                            fileName + '" alt="' + fileName +
                            '"><br /><span class="remove badge text-bg-danger">Remove image</span></div>')
                        $(".remove").click(function() {
                            $(this).parent(".pip").remove();
                            if ($('.pip').length == 0) {
                                $('#images').val("");
                                $('#submit').hide()
                                $('input[name="kategori"]').each(function(index) {
                                    $(this).prop('disabled', false);
                                })
                            }
                        });
                    };
                }
            }
        }
        var data = {};

        function simpan() {
            var images = []

            $('input:hidden[name="images"]').each(function() {
                images.push($(this).val());
            })

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            data = {
                no_rawat: $('#no_rawat').val(),
                no_rkm_medis: $('#no_rkm_medis').val(),
                images: images,
                tgl_masuk: $('#tgl_masuk').val(),
                kategori: $('input[type="radio"]:checked').val(),
                username: '{{ auth()->user()->username }}',
                _token: "{{ csrf_token() }}"
            }

            $.ajax({
                url: '/upload-erm/upload',
                method: 'POST',
                data: data,
                dataType: 'JSON',
                success: function(msg) {
                    hiddenForm();
                    showHistory();
                    $(".pip").remove();
                    if ($('.pip').length == 0) {
                        $('#images').val("");
                        $('#submit').hide()
                        $('input[name="kategori"]').each(function(index) {
                            $(this).prop('disabled', false);
                        })

                    }
                    if ($('#tb_pasien').length > 0) {
                        $('#tb_pasien').DataTable().destroy();
                        tb_pasien();
                        countUploaded();
                    }
                    showForm(data.no_rawat, data.kategori);
                    Swal.fire(
                        'Berhasil!', 'Berkas sudah terupload di server', 'success'
                    )

                },
                fail: function(jqXHR, status) {
                    console.log(status)
                }
            })

        }
        $('#submit').click(function() {})

        function hiddenForm() {
            $('#upload-image').css('visibility', 'hidden')
        }

        function showHistory() {
            var no_rkm_medis = $('.search option:selected').val();
            $('#upload-image').css('visibility', 'hidden');
            $.ajax({
                url: '/upload-erm/periksa/show/' + no_rkm_medis,
                dataType: 'JSON',
                success: function(data) {
                    $('#ralan tbody').empty();
                    $('#ranap tbody').empty();
                    $.map(data, function(item) {
                        if (item.upload.length > 0) {
                            button = '<a href="#form-upload" onclick="detailPeriksa(\'' + item.no_rawat
                                .toString() + '\',\'' + item.status_lanjut +
                                '\')" class="btn btn-success btn-sm"><i class="bi bi-check2-circle"></i></a>'


                        } else {
                            button = '<a href="#form-upload" onclick="detailPeriksa(\'' + item.no_rawat
                                .toString() + '\',\'' + item.status_lanjut +
                                '\')" class="btn btn-primary btn-sm"><i class="bi bi-cloud-upload"></i></a>'
                        }

                        html = '<tr>' +
                            '<td>' + item.no_rawat + '</td>' +
                            '<td>' + item.tgl_registrasi + '</td>' +
                            '<td>' + button + '</td>' +
                            '</tr>'

                        if (item.status_lanjut == 'Ralan') {
                            $('#ralan').append(html);
                        } else {
                            $('#ranap').append(html);
                        }
                    })
                }
            });

        }

        function deleteImage(id, img) {
            kategori = $('input[type="radio"]:checked').val();
            no_rawat = $('#no_rawat').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            Swal.fire({
                title: 'Yakin hapus file ini ?',
                text: "anda tidak bisa mengembalikan file yang dihapus",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'DELETE',
                        url: '/upload-erm/upload/delete/' + id + '?image=' + img,
                        dataType: 'JSON',
                        data: {
                            _token: "{{ csrf_token() }}",
                        },
                        success: function(data) {
                            showForm(no_rawat, kategori);
                            if ($('#tb_pasien').length > 0) {
                                $('#tb_pasien').DataTable().destroy();
                                tb_pasien();
                                countUploaded();
                            }
                            Swal.fire(
                                'Berhasil!', 'Berkas telah dihapus', 'success'
                            )
                        },

                    })
                }
            })
        }



        function hiddenForm() {
            $('#upload-image').css('visibility', 'hidden')

        }
    </script>
    @stack('script')
</body>

</html>
