@if(sizeof($services) > 0)
  @foreach($services as $service)
    <option value="{{ $service->id }}">{{ $service->servicename }}</option>
  @endforeach
@else
	<option>No Services Found</option>
@endif