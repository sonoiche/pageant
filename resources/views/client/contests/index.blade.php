@extends('layouts.app', ['currentPage' => 'Contests'])
@section('content')
<section class="content">
    <div class="card card-primary card-outline">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <div class="d-flex align-items-center">
                    <h3 class="card-title">List of Active Contests</h3>
                </div>
                <div class="d-flex justify-content-end align-items-center">
                    <a href="{{ url('client/contests/create') }}" class="btn btn-primary btn-sm">Create Contest</a>
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
                    @foreach ($contests as $key => $item)
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
                                    <a class="dropdown-item" href="javascript:;" onclick="removeContest({{ $item->id }})">Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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