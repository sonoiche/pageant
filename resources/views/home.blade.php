@extends('layouts.app', ['currentPage' => 'Dashboard'])
@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $contestCount }}</h3>
                        <p>Active Contests</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ url('client/contests') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $judgesCount }}</h3>
                        <p>Judges</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{ url('client/judges') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $participantsCount }}</h3>
                        <p>Participants</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="{{ url('client/participants') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>1</h3>
                        <p>Welcome {{ auth()->user()->fname }}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="{{ url('client/settings') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex align-items-center">
                                <h3 class="card-title">Latest Contests</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap" id="contest-table">
                            <thead>
                                <tr>
                                    <th style="width: 3%" class="text-center">#</th>
                                    <th style="width: 20%">Title</th>
                                    <th style="width: 20%">Venue</th>
                                    <th style="width: 5%" class="text-center"># of Participants</th>
                                    <th style="width: 10%">Date</th>
                                    <th style="width: 10%" class="text-center">Status</th>
                                    <th style="width: 10%" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($contests as $key => $item)
                                <tr>
                                    <td class="text-center">{{ $key+1 }}</td>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ $item->venue }}</td>
                                    <td class="text-center">{{ $item->participants }}</td>
                                    <td>{{ $item->date_held_display }}</td>
                                    <td class="text-center">{{ $item->status }}</td>
                                    <td class="text-center">
                                        <div>
                                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                Action
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ url('client/contests', $item->id) }}/edit">Edit</a>
                                                <a class="dropdown-item" href="{{ url('client/judges/create') }}?contest_id={{ $item->id }}">Add Judges</a>
                                                <a class="dropdown-item" href="{{ url('client/criteria/create') }}?contest_id={{ $item->id }}">Add Criteria</a>
                                                <a class="dropdown-item" href="{{ url('client/participants/create') }}?contest_id={{ $item->id }}">Add Participant</a>
                                                <a class="dropdown-item" href="javascript:;" onclick="removeContest({{ $item->id }})">Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">No active contests available</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('page-css')
<link rel="stylesheet" href="{{ url('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ url('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ url('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<style>
.dt-buttons {
    margin: 10px 0 5px 10px;
}
.dataTables_filter {
    position: absolute;
    top: 25%;
    right: 15px;
}
.dataTables_info {
    margin: 10px 0 5px 10px;
}
.dataTables_paginate {
    display: flex;
    justify-content: end;
    margin-right: 15px !important;
}
</style>
@endsection

@section('page-js')
@include('layouts.components.datatable');
<script>
$(document).ready(function () {
    $("#contest-table").DataTable({
        "responsive": true, 
        "lengthChange": false, 
        "autoWidth": false,
        "buttons": ["print"],
        columnDefs: [
            { orderable: false, targets: [0, 3, 6] }
        ],
        order: [[4, 'desc']]
    }).buttons().container().appendTo('#contest-table_wrapper .col-md-6:eq(0)');
});

function removeContest(id) {
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
                type: "DELETE",
                url: "{{ url('client/contests') }}/"+id,
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
