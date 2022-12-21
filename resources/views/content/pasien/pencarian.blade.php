@extends('index')

@section('contents')
    <div class="input-group mb-3">
        <select class="search form-control" name="keyword"></select>
    </div>


    <div class="row gy-2">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header text-bg-warning">
                    Histori Kunjungan Rawat Jalan
                </div>
                <div class="card-body">
                    <table id="ralan" class="table table-responsive text-sm table-sm">
                        <thead>
                            <tr>
                                <th>No. Rawat</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header text-bg-danger">
                    Histori Kunjungan Rawat Inap
                </div>
                <div class="card-body">
                    <table id="ranap" class="table table-responsive text-sm table-sm">
                        <thead>
                            <tr>
                                <th>No. Rawat</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            @include('content.upload.inforegistrasi')
        </div>
        <div class="col-sm-12">
            @include('content.upload.resume')
        </div>
    </div>
@endsection

@push('script')
    <script>
        var btnName;
        $('.search').select2({
            placeholder: 'Cari pasien',
            allowClear: true,
            ajax: {
                url: 'pasien/cari',
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            // console.log(item)
                            return {
                                text: item.no_rkm_medis + ' - ' + item.nm_pasien,
                                id: item.no_rkm_medis
                            }
                        })
                    };
                },
                cache: true
            }
        });
        $(".search").on("select2:unselecting", function(e) {
            $('#button-form label').detach()
            $('#button-form input').detach()
        });


        // function showHistory() {
        //     var no_rkm_medis = $('.search option:selected').val();
        //     $('#upload-image').css('visibility', 'hidden');
        //     $.ajax({
        //         url: 'periksa/show/' + no_rkm_medis
        //         , dataType: 'JSON'
        //         , success: function(data) {
        //             $('#ralan tbody').empty();
        //             $('#ranap tbody').empty();
        //             $.map(data, function(item) {
        //                  if (item.upload.length > 0) {
        //                     button = '<a href="#form-upload" onclick="detailPeriksa(\'' + item.no_rawat.toString() + '\',\'' + item.status_lanjut + '\')" class="btn btn-success btn-sm"><i class="bi bi-check2-circle"></i></a>'


        //                 } else {
        //                     button = '<a href="#form-upload" onclick="detailPeriksa(\'' + item.no_rawat.toString() + '\',\'' + item.status_lanjut + '\')" class="btn btn-primary btn-sm"><i class="bi bi-cloud-upload"></i></a>'
        //                 }

        //                 html = '<tr>' +
        //                     '<td>' + item.no_rawat + '</td>' +
        //                     '<td>' + item.tgl_registrasi + '</td>' +
        //                     '<td>' + button + '</td>' +
        //                     '</tr>'

        //                 if (item.status_lanjut == 'Ralan') {
        //                     $('#ralan').append(html);
        //                 } else {
        //                     $('#ranap').append(html);
        //                 }
        //             })
        //         }
        //     });

        // }

        $('.search').change(function() {
            $('#infoReg').css('visibility', 'hidden')
            $('#form-upload').css('visibility', 'hidden')
            showHistory();
        });

        // function detailPeriksa(no_rawat, status) {
        //     $('#form-upload').css('visibility', 'visible')
        //     $('#image .tmb').detach()
        //     $.ajax({
        //         url: 'periksa/detail?no_rawat=' + no_rawat
        //         , method: "GET"
        //         , dataType: 'JSON'
        //         , success: function(data) {
        //             $('#no_rawat').val(data.no_rawat)
        //             $('#no_rkm_medis').val(data.no_rkm_medis)
        //             $('#tgl_masuk').val(data.tgl_registrasi)
        //             $('#td_no_rawat').text(data.no_rawat)
        //             $('#td_tgl_reg').text(data.tgl_registrasi)
        //             if (data.kamar_inap != null) {
        //                 $('#td_tgl_pulang').text(data.kamar_inap.tgl_keluar)
        //             } else {
        //                 $('#td_tgl_pulang').text("-")
        //             }
        //             $('#infoReg').css('visibility', 'visible')


        //             $('#button-form label').detach()
        //             $('#button-form input').detach()



        //             if (status == "Ralan") {
        //                 html = '<input type="radio" class="btn-check" name="kategori" id="opt-usg" autocomplete="off" onclick="showForm()" value="usg"><label class="btn btn-outline-primary btn-sm" for="opt-usg">USG</label>' +
        //                     '<input type="radio" class="btn-check" name="kategori" id="opt-laborat" autocomplete="off" onclick="showForm()" value="laborat"><label class="btn btn-outline-primary btn-sm" for="opt-laborat">Laboratorium</label>' +
        //                     '<input type="radio" class="btn-check" name="kategori" id="opt-radiologi" autocomplete="off" onclick="showForm()" value="radiologi"><label class="btn btn-outline-primary btn-sm" for="opt-radiologi">Radiologi</label>'
        //                 $('#button-form').append(html)
        //             } else {
        //                 html = '<input type="radio" class="btn-check" name="kategori" id="opt-resume" autocomplete="off" onclick="showForm()" value="resume"><label class="btn btn-outline-primary btn-sm" for="opt-resume">Resume Medis</label>' +
        //                     '<input type="radio" class="btn-check" name="kategori" id="opt-laborat" autocomplete="off" onclick="showForm()" value="laborat"><label class="btn btn-outline-primary btn-sm" for="opt-laborat">Laboratorium</label>' +
        //                     '<input type="radio" class="btn-check" name="kategori" id="opt-radiologi" autocomplete="off" onclick="showForm()" value="radiologi"><label class="btn btn-outline-primary btn-sm" for="opt-radiologi">Radiologi</label>' +
        //                     '<input type="radio" class="btn-check" name="kategori" id="opt-operasi" autocomplete="off" onclick="showForm()" value="operasi"><label class="btn btn-outline-primary btn-sm" for="opt-operasi">Operasi</label>' +
        //                     '<input type="radio" class="btn-check" name="kategori" id="opt-lain" autocomplete="off" onclick="showForm()" value="lainnya"><label class="btn btn-outline-primary btn-sm" for="opt-lain">Lainnya</label>'

        //                 $('#button-form').append(html)
        //             }
        //         }
        //     })
        // }

        // function showForm(no_rawat='', kategori='') {
        //     if(!no_rawat && !kategori){
        //         no_rawat = $('#no_rawat').val();
        //         kategori = event.target.value;
        //     }

        //     console.log(no_rawat, ' ', kategori)

        //     var img = '';
        //     $('#image .tmb').detach()
        //     $.ajax({
        //         url: 'upload/show?no_rawat=' + no_rawat + '&kategori=' + kategori
        //         , method: 'GET'
        //         , dataType: 'JSON'
        //         , success: function(data) {
        //             countData = Object.keys(data).length
        //             if (countData > 0) {
        //                 img = data.file.split(',');
        //                 $.map(img, function(file) {
        //                     $('#image').append('<div class="tmb col-sm-4"><img class="img-thumbnail position-relative" src="{{ asset('erm') }}/' + file + '" /><span class="badge text-bg-danger" onclick=deleteImage(' + data.id + ',"' + file + '")>Hapus</span></div>')
        //                 })
        //                 // $('#upload-image').css('visibility', 'hidden')
        //             }
        //                 $('#upload-image').css('visibility', 'visible')
        //             // }
        //         }
        //     })

        // }

        // function deleteImage(id, img) {
        //    kategori = $('input[type="radio"]:checked').val();
        //    no_rawat= $('#no_rawat').val();

        //     $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        //     });
        //     Swal.fire({
        //         title: 'Yakin hapus file ini ?'
        //         , text: "anda tidak bisa mengembalikan file yang dihapus"
        //         , icon: 'warning'
        //         , showCancelButton: true
        //         , confirmButtonColor: '#d33'
        //         , cancelButtonColor: '#3085d6'
        //         , confirmButtonText: 'Ya, Hapus!'
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             $.ajax({
        //                 type: 'DELETE'
        //                 , url: 'upload/delete/' + id + '?image=' + img
        //                 , dataType: 'JSON'
        //                 , data: {
        //                     _token: "{{ csrf_token() }}"
        //                 , }
        //                 , success: function(data) {
        //                     showForm(no_rawat, kategori);
        //                     Swal.fire(
        //                         'Berhasil!'
        //                         , 'Berkas telah dihapus'
        //                         , 'success'
        //                         )
        //                 },

        //             })
        //         }
        //     })
        // }



        // function hiddenForm() {
        //     $('#upload-image').css('visibility', 'hidden')

        // }

        $(document).ready(function() {
            if ($('.pip').length == 0) {
                $('#submit').hide()
            }
        })
        // function previewImage(input){
        //     if (input.files && input.files[0]) {

        //         $('input[name="kategori"]').each(function(index) {
        //             if ($(this).prop('checked') != true) {
        //                 $(this).prop('disabled', true);
        //             }
        //         })

        //         $('#submit').show()
        //         countImage = input.files.length;
        //         for (let index = 0; index < countImage; index++) {
        //             var reader = new FileReader();
        //             reader.readAsDataURL(input.files[index]);
        //             reader.onload = function(e) {
        //                 var file = e.target;
        //                 var fileName = input.files[index].name
        //                 $('#preview').append('<div class="pip col-sm-3"><input type="hidden" name="images" value="' + file.result + '" class="images" ><img width="75%" src="' + file.result + '" title="' + fileName + '" alt="' + fileName + '"><br /><span class="remove badge text-bg-danger">Remove image</span></div>')
        //                 $(".remove").click(function() {
        //                     $(this).parent(".pip").remove();
        //                     if ($('.pip').length == 0) {
        //                         $('#images').val("");
        //                         $('#submit').hide()
        //                         $('input[name="kategori"]').each(function(index) {
        //                             $(this).prop('disabled', false);
        //                         })
        //                     }
        //                 });
        //             };
        //         }
        //     }
        // }

        // var data = {};
        // $('#submit').click(function() {

        //     var images = []

        //     $('input:hidden[name="images"]').each(function() {
        //         images.push($(this).val());
        //     })

        //     $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        //     });

        //     data = {
        //         no_rawat: $('#no_rawat').val()
        //         , no_rkm_medis: $('#no_rkm_medis').val()
        //         , images: images
        //         , tgl_masuk: $('#tgl_masuk').val()
        //         , kategori: $('input[type="radio"]:checked').val()
        //         , username: 'admin'
        //         , _token: "{{ csrf_token() }}"
        //     }

        //     $.ajax({
        //         url: 'upload'
        //         , method: 'POST'
        //         , data: data
        //         , dataType: 'JSON'
        //         , success: function(msg) {
        //             hiddenForm();
        //             showHistory();
        //             $(".pip").remove();
        //             if ($('.pip').length == 0) {
        //                 $('#images').val("");
        //                 $('#submit').hide()
        //                 $('input[name="kategori"]').each(function(index) {
        //                     $(this).prop('disabled', false);
        //                 })

        //             }
        //             // console.log(data.no_rawat)
        //             showForm(data.no_rawat, data.kategori);
        //             Swal.fire(
        //                 'Berhasil!'
        //                 , 'Berkas sudah terupload di server'
        //                 , 'success'
        //             )

        //         }
        //         , fail: function(jqXHR, status) {
        //             console.log(status)
        //         }
        //     })


        // })
    </script>
@endpush
