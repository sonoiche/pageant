@extends('layouts.app', ['currentPage' => 'Dashboard'])
@section('content')
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                {{ $contest->title ?? '' }} Participants
            </h3>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Address</th>
                        <th class="text-center">Overall Points</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contest->contest_participants as $item)
                    <tr>
                        <td></td>
                        <td>{{ $item->fullname }}</td>
                        <td>{{ $item->age }}</td>
                        <td>{{ $item->complete_address }}</td>
                        <td class="text-center">
                            <a href="{{ url('judge/contest', $item->id) }}?what=single">{{ $item->getOverallPoints($judge->id, $contest->id) }}</a>
                        </td>
                        <td class="text-center">
                            <a href="{{ url('judge/contest/create') }}?participant_id={{ $item->id }}" class="btn btn-outline-primary">Generate Points</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.card -->
</section>
@endsection
