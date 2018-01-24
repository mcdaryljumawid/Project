@if(sizeof($services) > 0)
<option disabled selected><i>Choose a service</i></option>
  @foreach($services as $service)
    <option value="{{ $service->id }}">{{ $service->servicename }}</option>
  @endforeach
@else
	<option>No Services Found</option>
@endif