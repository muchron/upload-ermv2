@extends('index')

@section('contents')
    <div class="card">
        <div class="card-header text-bg-primary">
            RESUME MEDIS
        </div>
        <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data">
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


@endsection

@push('script')

@endpush
