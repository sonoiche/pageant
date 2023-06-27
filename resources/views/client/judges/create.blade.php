@extends('layouts.app', ['currentPage' => 'Judges'])
@section('content')
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    @if (isset($contest->title))
                    <h3 class="card-title">Add New Judge for {{ $contest->title }}</h3>
                    @else
                    <h3 class="card-title">Add New Judge</h3>
                    @endif
                </div>
                <form method="POST" action="{{ url('client/judges') }}" enctype="multipart/form-data">
                    @csrf
                    @include('client.judges.form')         
                    <div class="card-footer">
                        <div class="float-right">
                            <a href="{{ url('client/judges') }}" class="btn btn-outline-danger mr-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Submit</button>
                            @if(isset($contest->id))
                            <input type="hidden" name="contest_id" value="{{ $contest->id ?? '' }}">
                            @endif
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
{!! JsValidator::formRequest('App\Http\Requests\JudgeRequest') !!}
@endsection