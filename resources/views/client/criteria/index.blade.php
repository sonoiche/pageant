@extends('layouts.app', ['currentPage' => 'Criteria'])
@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex align-items-center">
                            <h3 class="card-title">List of Criteria</h3>
                        </div>
                        <div class="d-flex justify-content-end align-items-center">
                            <a href="{{ url('client/criteria/create') }}" class="btn btn-primary btn-sm">Add New Criteria</a>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap" id="criteria-table">
                        <thead>
                            <tr>
                                <th style="width: 3%" class="text-center">#</th>
                                <th style="width: 50%">Criteria</th>
                                <th style="width: 10%" class="text-center">Percentage</th>
                                <th style="width: 20%">Contest</th>
                                <th style="width: 10%" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($criterias as $key => $item)
                            <tr>
                                <td class="text-center">{{ $key+1 }}</td>
                                <td>{{ $item->name }}</td>
                                <td class="text-center">{{ $item->percentage }}%</td>
                                <td>{{ isset($item->contest) ? $item->contest->title : '' }}</td>
                                <td class="text-center">
                                    <div>
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            Action
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ url('client/criteria', $item->id) }}/edit">Edit</a>
                                            <a class="dropdown-item" href="javascript:;" onclick="removeCriteria({{ $item->id }})">Delete</a>
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
    $("#criteria-table").DataTable({
        "responsive": true, 
        "lengthChange": false, 
        "autoWidth": false,
        buttons: [
            { 
                extend: "print", 
                title: "List of Criteria", 
                exportOptions: { columns: [0, 1, 2, 3] }
            }
        ],
        columnDefs: [
            { orderable: false, targets: [0, 3, 4] }
        ],
        order: [[1, 'asc']]
    }).buttons().container().appendTo('#criteria-table_wrapper .col-md-6:eq(0)');
});

function removeCriteria(id) {
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
                url: "{{ url('client/criteria') }}/"+id,
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