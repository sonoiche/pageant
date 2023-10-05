@extends('layouts.app', ['currentPage' => 'Generate Points'])
@section('content')
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-5 col-sm-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Generate Points for {{ $participant->fullname }}</h3>
                </div>
                <form method="POST" action="{{ url('judge/contest') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        @foreach ($criterias as $item)
                        <div class="form-group">
                            <label for="{{ $item->slug_name }}">{{ $item->name }} - {{ $item->percentage }}%</label>
                            <input type="number" class="form-control" id="{{ $item->slug_name }}" name="{{ $item->slug_name }}" />
                        </div>
                        @endforeach
                    </div>
                    <div class="card-footer">
                        <div class="float-right">
                            <a href="{{ url('judge/contest') }}" class="btn btn-outline-danger mr-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                            <input type="hidden" name="participant_id" value="{{ $participant->id }}" />
                            <input type="hidden" name="contest_id" value="{{ $participant->contest_id }}" />
                        </div>
                    </div>
                </form>
            </div>            
        </div>
    </div>
</section>
@endsection