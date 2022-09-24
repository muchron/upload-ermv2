@extends('index')

@section('contents')
{{-- @if(!empty($data))
<div class="alert alert-success"> {{ $success }}</div>
@endif --}}

{{-- <div class="d-grid gap-3"> --}}

<div class="input-group mb-3">
    <select class="search form-control" name="keyword"></select>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header text-bg-warning">
                Histori Kunjungan Rawat Jalan
            </div>
            <div class="card-body">
                <table id="ralan" class="table table-responsive">
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
                <table id="ranap" class="table table-responsive">
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
</div>
@endsection

@push('script')
<script>
    $('.search').select2({
        placeholder: 'Cari pasien'
        , allowClear: true
        , ajax: {
            url: 'pasien/cari'
            , dataType: 'json'
            , delay: 250
            , processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        // console.log(item)
                        return {
                            text: item.no_rkm_medis + ' - ' + item.nm_pasien
                            , id: item.no_rkm_medis
                        }
                    })
                };
            }
            , cache: true
        }
    });

    $('.search').change(function() {
        let no_rkm_medis = $('.search option:selected').val();
        $.ajax({
            url: 'periksa/' + no_rkm_medis
            , dataType: 'JSON'
            , success: function(data) {
                $('#ralan tbody').empty();
                $('#ranap tbody').empty();
                $.map(data, function(item) {

                    if (item.upload) {
                        button = '<a href="javascript:void(0)" class="btn btn-success btn-sm"><i class="bi bi-check-circle-fill"></i></a>'
                    } else {
                        button = '<a href="upload?no_rawat=' + item.no_rawat + '&no_rkm_medis=' + item.no_rkm_medis + '&tgl_masuk=' + item.tgl_registrasi + '" class="btn btn-primary btn-sm"><i class="bi bi-cloud-upload"></i></a>'
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
    });

</script>
@endpush
