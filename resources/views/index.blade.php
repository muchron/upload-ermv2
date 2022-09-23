<!doctype html>
<html lang="en">
@include('layout.head')
<body>

    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="#">{{config('app.name')}}</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </header>

    <div class="container-fluid">
        <div class="row">
            @include('layout.sidebar')
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">
                        {{Request::segment(1)==null ? 'DASHBOARD': strtoupper(Request::segment(1))}}
                    </h1>
                </div>
                @yield('contents')
            </main>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <script src="{{ asset('js/dashboard.js') }}"></script>
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
        $('.search').select2({
            placeholder: 'Cari pasien',
            allowClear: true
            , ajax: {
                url: 'pasien/cari'
                , dataType: 'json'
                , delay: 250
                , processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            // console.log(item)
                            return {
                                text: item.no_rkm_medis+' - '+item.nm_pasien,
                                id: item.no_rkm_medis
                            }
                        })
                    };
                }
                , cache: true
            }
        });

        $('.search').change(function(){
            let no_rkm_medis = $('.search option:selected').val();
            $.ajax({
                url : 'periksa/'+no_rkm_medis,
                dataType:'JSON',
                success:function(data){
                    $.map(data, function(item){
                        console.log(item)
                    })
                }
            });
        });

    </script>
</body>

</html>
