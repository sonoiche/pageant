@extends('layouts.app', ['currentPage' => 'Generate Points'])
@section('content')
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">{{ $participant->fullname }} candidates of {{ $contest->title }}</h3>
                </div>
                <div class="card-body">
                    <div class="text-center mb-5">
                        <img src="{{ $participant->photo }}" style="width: 30%">
                    </div>
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <td>Overall Points</td>
                                <td>{{ $participant->overall_points }}%</td>
                            </tr>
                            <tr>
                                <td>Fullname</td>
                                <td>{{ $participant->fullname }}</td>
                            </tr>
                            <tr>
                                <td>Birthdate</td>
                                <td>{{ $participant->birthdate_display }}</td>
                            </tr>
                            <tr>
                                <td>Contact Number</td>
                                <td>{{ $participant->contact_number }}</td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td>{{ $participant->complete_address }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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
                            <input type="number" class="form-control" id="{{ $item->slug_name }}" name="{{ $item->slug_name }}" min="1" max="{{ $item->percentage }}" onblur="checkPoints('{{ $item->slug_name }}',{{ $item->percentage }})" />
                            <span class="text-danger" style="font-size: 13px; display: none" id="error-{{ $item->slug_name }}">Value must be less than or equal to {{ $item->percentage }}</span>
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

@section('page-js')
<script>
function checkPoints(idname, percentage) {
    var points = $('#'+idname).val();
    var isActive = false;
    if(points && points > percentage) {
        $('#error-'+idname).show();
    }
}
</script>
@endsection