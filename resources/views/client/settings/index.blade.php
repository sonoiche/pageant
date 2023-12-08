@extends('layouts.app', ['currentPage' => 'Account Settings'])
@section('content')
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Account Information</h3>
                </div>
                <form method="POST" action="{{ url('client/settings') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="fname">First Name</label>
                            <input type="text" class="form-control" id="fname" name="fname" value="{{ auth()->user()->fname }}" />
                        </div>
                        <div class="form-group">
                            <label for="mname">Middle Name (Optional)</label>
                            <input type="text" class="form-control" id="mname" name="mname" value="{{ auth()->user()->mname }}" />
                        </div>
                        <div class="form-group">
                            <label for="lname">Last Name</label>
                            <input type="text" class="form-control" id="lname" name="lname" value="{{ auth()->user()->lname }}" />
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" id="email" readonly value="{{ auth()->user()->email }}" />
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" />
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" />
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="float-right">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>            
        </div>
    </div>
</section>
@endsection

@section('page-js')
{!! JsValidator::formRequest('App\Http\Requests\AccountRequest') !!}
@endsection