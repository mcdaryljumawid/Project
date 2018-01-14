@if(sizeof($workers) > 0)
<option value=""><i> --choose a worker </i></option>
  @foreach($workers as $worker)
    <option value="{{ $worker->id }}">{{ $worker->workerlname }}, {{ $worker->workerfname }}</option>
  @endforeach
@else
	<option>No Workers Found</option>
@endif