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
        <label for="name">Criteria</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ $criteria->name ?? '' }}" />
    </div>
    <div class="form-group">
        <label for="percentage">Percentage</label>
        <input type="number" class="form-control" id="percentage" name="percentage" value="{{ $criteria->percentage ?? '' }}" maxlength="2" />
    </div>
</div>