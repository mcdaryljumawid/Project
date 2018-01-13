@if(sizeof($workers) > 0)
  @foreach($workers as $worker)
    <option value="{{ $worker->id }}">{{ $worker->workerlname }}, {{ $worker->workerfname }}</option>
  @endforeach
@else
	<option>No Workers Found</option>
@endif