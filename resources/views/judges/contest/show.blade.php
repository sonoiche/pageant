@extends('layouts.app', ['currentPage' => 'Breakdown of Points'])
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
                    <h3 class="card-title">Overall Points of {{ $participant->fullname }}</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Criteria</th>
                                <th class="text-center">Percentage</th>
                                <th class="text-center">Points</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($arr_results as $item)
                            <tr>
                                <td>{{ $item['name'] }}</td>
                                <td class="text-center">{{ $item['percentage'] }}%</td>
                                <td class="text-center">{{ $item['points'] }}%</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td><strong>Total</strong></td>
                                <td class="text-center">{{ $total_percent }}%</td>
                                <td class="text-center"><strong>{{ $total }}%</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>            
        </div>
    </div>
</section>
@endsection