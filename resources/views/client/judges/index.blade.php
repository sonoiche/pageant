@extends('layouts.app', ['currentPage' => 'Judges'])
@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex align-items-center">
                            <h3 class="card-title">List of Active Judges</h3>
                        </div>
                        <div class="d-flex justify-content-end align-items-center">
                            <a href="{{ url('client/judges/create') }}" class="btn btn-primary btn-sm">Add New Judge</a>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap" id="judge-table">
                        <thead>
                            <tr>
                                <th style="width: 15%">Fullname</th>
                                <th style="width: 15%">Email</th>
                                <th style="width: 20%">Contest</th>
                                <th style="width: 15%">Contact Number</th>
                                <th style="width: 10%" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($judges as $key => $item)
                            <tr>
                                <td>{{ $item->fullname }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ isset($item->contest) ? $item->contest->title : '' }}</td>
                                <td>{{ $item->contact_number }}</td>
                                <td class="text-center">
                                    <div>
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            Action
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ url('client/judges', $item->id) }}/edit">Edit</a>
                                            <a class="dropdown-item" href="javascript:;" onclick="removeJudge({{ $item->id }})">Delete</a>
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
    $("#judge-table").DataTable({
        "responsive": true, 
        "lengthChange": false, 
        "autoWidth": false,
        buttons: [
            { 
                extend: "print", 
                title: "List of Judges", 
                exportOptions: { columns: [0, 1, 2, 3, 4] }
            }
        ],
        columnDefs: [
            { orderable: false, targets: [0, 3, 4, 5] }
        ],
        order: [[1, 'asc']]
    }).buttons().container().appendTo('#judge-table_wrapper .col-md-6:eq(0)');
});

function removeJudge(id) {
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
                url: "{{ url('client/judges') }}/"+id,
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