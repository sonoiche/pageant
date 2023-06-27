@extends('layouts.app', ['currentPage' => 'Contests'])
@section('content')
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-8 col-sm-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Update Contest Information</h3>
                </div>
                <form method="POST" action="{{ url('client/contests', $contest->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('client.contests.form')         
                    <div class="card-footer">
                        <div class="float-right">
                            <input type="hidden" name="id" value="{{ $contest->id }}">
                            <a href="{{ url('client/contests') }}" class="btn btn-outline-danger mr-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>            
        </div>
    </div>
</section>
@endsection

@section('page-css')
<link href="{{ url('assets/plugins/jquery.filer/css/jquery.filer.css') }}" type="text/css" rel="stylesheet" />
<link href="{{ url('assets/plugins/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css') }}" type="text/css" rel="stylesheet" />
@endsection

@section('page-js')
<script src="{{ url('assets/plugins/jquery.filer/js/jquery.filer.min.js') }}"></script>
<script src="{{ url('assets/plugins/filer/custom-filer.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/filer/jquery.fileuploads.init.js') }}" type="text/javascript"></script>
{!! JsValidator::formRequest('App\Http\Requests\ContestRequest') !!}

<script>
function removeImage(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "GET",
                url: "{{ url('client/contests') }}/"+id+"/edit?what=deleteImage",
                dataType: "json",
                success: function (response) {
                    Swal.fire(
                        'Deleted!',
                        response.success,
                        'success'
                    );
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                }
            });
        }
    })
}
</script>
@endsection