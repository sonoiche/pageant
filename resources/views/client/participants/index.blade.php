@extends('layouts.app', ['currentPage' => 'Participants'])
@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex align-items-center">
                            <h3 class="card-title">List of Participants</h3>
                        </div>
                        <div class="d-flex justify-content-end align-items-center">
                            <a href="{{ url('client/participants/create') }}" class="btn btn-primary btn-sm">Add New Participant</a>
                        </div>
                    </div>
                </div>
                <div class="filter">
                    <form action="{{ url('client/participants') }}" method="get" id="filter-submit">
                        <select name="contest_id" id="contest_id" class="custom-select">
                            <option value="">All Contests</option>
                            @foreach ($contests as $item)
                            <option value="{{ $item->id }}" {{ (isset($contest_id) && $contest_id == $item->id) ? 'selected' : '' }}>{{ $item->title }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="is_contest" value="1">
                    </form>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap" id="participant-table">
                        <thead>
                            <tr>
                                <th style="width: 15%">Fullname</th>
                                <th style="width: 20%">Contest</th>
                                <th style="width: 15%">Contact Number</th>
                                <th style="width: 15%">Address</th>
                                <th class="text-center">Overall Points</th>
                                <th style="width: 10%" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($participants as $key => $item)
                            <tr>
                                <td><a href="{{ url('client/participants', $item->id) }}">{{ $item->fullname }}</a></td>
                                <td>{{ isset($item->contest) ? $item->contest->title : '' }}</td>
                                <td>{{ $item->contact_number }}</td>
                                <td>{{ $item->complete_address }}</td>
                                <td class="text-center"><strong>{{ $item->overall_points }}%</strong></td>
                                <td class="text-center">
                                    <div>
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            Action
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ url('client/participants', $item->id) }}/edit">Edit</a>
                                            <a class="dropdown-item" href="javascript:;" onclick="removeParticipant({{ $item->id }})">Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
    padding-top: 20px;
    padding-right: 15px;
}
.dataTables_info {
    margin: 10px 0 5px 10px;
}
.dataTables_paginate {
    display: flex;
    justify-content: end;
    margin-right: 15px !important;
}
.filter {
    position: absolute;
    top: 66px;
    left: 80px;
    z-index: 100;
}
</style>
@endsection

@section('page-js')
@include('layouts.components.datatable');
<script>
$(document).ready(function () {
    $("#participant-table").DataTable({
        "responsive": true, 
        "lengthChange": false, 
        "autoWidth": false,
        buttons: [
            { 
                extend: "print", 
                title: "List of Participants", 
                exportOptions: { columns: [0, 1, 2, 3, 4] }
            }
        ],
        columnDefs: [
            { orderable: false, targets: [0, 3, 4, 5] }
        ],
        order: [[4, 'desc']]
    }).buttons().container().appendTo('#participant-table_wrapper .col-md-6:eq(0)');

    $('#contest_id').change(function (e) { 
        e.preventDefault();
        $('#filter-submit').submit();
    });
});

function removeParticipant(id) {
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
                url: "{{ url('client/participants') }}/"+id,
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