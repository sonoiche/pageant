<div class="card-body">
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" class="form-control" id="title" name="title" placeholder="Enter title of the contest" value="{{ $contest->title ?? '' }}" />
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description" rows="5" style="resize: none; width: 100%">{{ $contest->description ?? '' }}</textarea>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label for="venue">Venue / Location</label>
                <input type="text" class="form-control" id="venue" name="venue" value="{{ $contest->venue ?? '' }}" />
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="participants">Number of Participants</label>
                <input type="number" class="form-control" id="participants" name="participants" value="{{ $contest->participants ?? '' }}" />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label for="date_held">Date</label>
                <input type="date" class="form-control" id="date_held" name="date_held" value="{{ $contest->date_held ?? '' }}" />
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="custom-select">
                    <option value="">--</option>
                    <option value="Active" {{ (isset($contest->status) && $contest->status == 'Active') ? 'selected' : '' }}>Active</option>
                    <option value="Inactive" {{ (isset($contest->status) && $contest->status == 'Inactive') ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="logo">Contest Logo</label>
        @if (isset($contest->logo))
        <div class="input-group input-group col-6">
            <input type="text" class="form-control" value="{{ basename($contest->logo) }}" readonly>
            <span class="input-group-append">
                <button type="button" class="btn btn-outline-danger btn-flat" onclick="removeImage({{ $contest->id }})">Remove</button>
            </span>
        </div>
        @else
        <input type="file" name="logo" id="filer_input_single" class="form-control">
        @endif
    </div>
</div>