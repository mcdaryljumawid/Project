@if(sizeof($services) > 0)
<option><i>--choose a service</i></option>
  @foreach($services as $service)
    <option value="{{ $service->id }}">{{ $service->servicename }}</option>
  @endforeach
@else
	<option>No Services Found</option>
@endif