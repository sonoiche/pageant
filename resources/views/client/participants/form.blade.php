<div class="card-body">
    @if (!isset($contest->id))
    <div class="form-group">
        <label for="contest_id">Contest</label>
        <select name="contest_id" id="contest_id" class="custom-select">
            @foreach ($contests as $item)
            <option value="{{ $item->id }}">{{ $item->title }}</option>
            @endforeach
        </select>
    </div>
    @endif
    <div class="form-group">
        <label for="fname">First Name</label>
        <input type="text" class="form-control" id="fname" name="fname" value="{{ $participant->fname ?? '' }}" />
    </div>
    <div class="form-group">
        <label for="mname">Middle Name (Optional)</label>
        <input type="text" class="form-control" id="mname" name="mname" value="{{ $participant->mname ?? '' }}" />
    </div>
    <div class="form-group">
        <label for="lname">Last Name</label>
        <input type="text" class="form-control" id="lname" name="lname" value="{{ $participant->lname ?? '' }}" />
    </div>
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label for="birthdate">Birthdate</label>
                <input type="date" class="form-control" name="birthdate" id="birthdate" max="{{ $maxDate }}" value="{{ $participant->birthdate ?? '' }}" />
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="gender">Gender</label>
                <select class="custom-select" name="gender" id="gender">
                    <option value="">--</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="contact_number">Contact Number</label>
        <input type="text" class="form-control" id="contact_number" name="contact_number" value="{{ $participant->contact_number ?? '' }}" />
    </div>
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label for="address">Address (Street / Barangay)</label>
                <input type="text" class="form-control" name="address" id="address" value="{{ $participant->address ?? '' }}" />
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="city">City</label>
                <input type="text" class="form-control" name="city" id="city" value="{{ $participant->city ?? '' }}" />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label for="status">Status</label>
                <select class="custom-select" name="status" id="status">
                    <option value="">--</option>
                    <option value="Qualified" {{ (isset($participant->status) && $participant->status == 'Qualified') ? 'selected' : '' }}>Qualified</option>
                    <option value="Disqualified" {{ (isset($participant->status) && $participant->status == 'Disqualified') ? 'selected' : '' }}>Disqualified</option>
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="photo">Photo</label>
        @if (isset($participant->photo))
        <div class="input-group input-group col-6">
            <input type="text" class="form-control" value="{{ basename($participant->photo) }}" readonly>
            <span class="input-group-append">
                <button type="button" class="btn btn-outline-danger btn-flat" onclick="removeImage({{ $participant->id }})">Remove</button>
            </span>
        </div>
        @else
        <input type="file" name="photo" id="filer_input_single" class="form-control">
        @endif
    </div>
</div>