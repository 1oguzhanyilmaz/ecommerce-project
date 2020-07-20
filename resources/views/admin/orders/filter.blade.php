<form action="{{ url(Request::path()) }}" method="GET" class="my-2">
    <div class="d-flex align-items-center justify-content-between">
        <div class="">
            <input type="text" name="q" class="form-control" placeholder="Type code or name" value="{{ !empty(request()->input('q')) ? request()->input('q') : '' }}">
        </div>
        <div class="">
            <input type="date" name="start" class="form-control datepicker" placeholder="Start Date" value="{{ !empty(request()->input('start')) ? request()->input('start') : '' }}">
        </div>
        <div class="">
            <input type="date" name="end" class="form-control datepicker" placeholder="End Date" value="{{ !empty(request()->input('end')) ? request()->input('end') : '' }}">
        </div>

        <div class="">
            <select class="form-control" name="status">
                <option value="0" selected disabled>All Status:</option>
                @foreach($statuses as $key => $value)
                    <option {{ (request()->input('status') == $key) ? 'selected' : '' }} value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>

        <div class="">
            <button type="submit" class="btn btn-primary">Show</button>
        </div>
    </div>
</form>
