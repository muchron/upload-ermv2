@extends('index')

@section('contents')
<div class="d-grid gap-3">
    <div class="card">
        <div class="card-header text-bg-primary">
            RESUME MEDIS
        </div>
        <div class="card-body">
            <table width="100%">
                <tr>
                    <td>No. RM</td>
                    <td>:</td>
                    <td><strong>{{$no_rkm_medis}}<strong></td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td><strong>{{$nm_pasien}}<strong></td>
                </tr>
                <tr>
                    <td>Tanggal lahir</td>
                    <td>:</td>
                    <td><strong>{{$tgl_lahir}}<strong></td>
                </tr>
            </table>

        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <form action="upload" method="post" enctype="multipart/form-data">
                @csrf

                <div class="d-grid gap-2">
                    <label for="no_rkm_medis"></label>
                    <input type="hidden" id="no_rkm_medis" name="no_rkm_medis" value="{{$no_rkm_medis}}">
                    <input type="hidden" id="no_rawat" name="no_rawat" value="{{$no_rawat}}">
                    <input type="hidden" id="tgl_masuk" name="tgl_masuk" value="{{$tgl_masuk}}">
                    <input type="hidden" id="usermane" name="username" value="admin">
                </div>
                <label>Anda dapat mengupload lebih dari satu gambar</label>
                <div class="mb-3">
                    <input class="form-control" type="file" id="images" name="file" multiple onchange="previewImage(this)" style="display: none">

                </div>
                <div class="mb-2 text-center">
                    <div class="row" id="preview">
                    </div>
                </div>
                <div class="d-grid gap-2">
                    <label type="button" class="btn btn-success" width="100%" for="images">Tambah</label>
                    <button type="submit" class="btn btn-primary btn-sm" id="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    @if ($upload)
    <div class="card">
        <div class="card-header text-bg-primary">
            Hasil Upload
        </div>
        <div class="card-body">
            {{$upload->no_rawat}}
        </div>
    </div>
    @endif

</div>


@endsection

@push('script')
<script>
    $(document).ready(function() {
        if ($('.pip').length == 0) {
            $('#submit').hide()
        }
    })
    const previewImage = (input) => {
        if (input.files && input.files[0]) {
            $('#submit').show()
            countImage = input.files.length;
            for (let index = 0; index < countImage; index++) {
                var reader = new FileReader();
                reader.readAsDataURL(input.files[index]);
                reader.onload = function(e) {
                    var file = e.target;
                    var fileName = input.files[index].name
                    $('#preview').append('<div class="pip col-sm-3"><input type="hidden" name="images[]" value="' + file.result + '"><img src="' + file.result + '" title="' + fileName + '" alt="' + fileName + '"><br /><span class="remove badge text-bg-danger">Remove image</span></div>')

                    $(".remove").click(function() {
                        $(this).parent(".pip").remove();
                        if ($('.pip').length == 0) {
                            $('#images').val("");
                            $('#submit').hide()
                        }
                    });
                };
            }
        } else {
            $('#submit').hide()
        }
    }

</script>
@endpush
