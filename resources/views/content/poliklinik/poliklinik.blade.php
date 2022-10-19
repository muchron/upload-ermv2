@extends('index')

@section('contents')
<div class="row">
    <div class="col-sm-6">
        <div class="card">
            <div class="card-body text-center">
                <h5 class="card-title">Poliklinik Obgyn</h5>
                <div class="d-grid gap-2">
                    @foreach ( $data as $d )
                    <a href="#" class="btn btn-primary">{{$d->dokter->nm_dokter}}</a>
                    {{-- {{$d->dokter->nm_dokter}} --}}
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    
@endpush