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
        <input type="text" class="form-control" id="fname" name="fname" value="{{ $judge->fname ?? '' }}" />
    </div>
    <div class="form-group">
        <label for="mname">Middle Name (Optional)</label>
        <input type="text" class="form-control" id="mname" name="mname" value="{{ $judge->mname ?? '' }}" />
    </div>
    <div class="form-group">
        <label for="lname">Last Name</label>
        <input type="text" class="form-control" id="lname" name="lname" value="{{ $judge->lname ?? '' }}" />
    </div>
    <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ $judge->email ?? '' }}" />
    </div>
    <div class="form-group">
        <label for="contact_number">Contact Number</label>
        <input type="text" class="form-control" id="contact_number" name="contact_number" value="{{ $judge->contact_number ?? '' }}" />
    </div>
    <div class="form-group">
        <label for="position">Position</label>
        <input type="text" class="form-control" id="position" name="position" value="{{ $judge->position ?? '' }}" />
    </div>
    <div class="form-group">
        <label for="complete_address">Complete Address</label>
        <input type="text" class="form-control" id="complete_address" name="complete_address" value="{{ $judge->complete_address ?? '' }}" />
    </div>
</div>