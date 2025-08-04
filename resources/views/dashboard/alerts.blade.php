@if (isset($data) && is_array($data) && array_key_exists('within_range', $data) && array_key_exists('distance', $data))
    @if ($data['within_range'])
        <p style="color: green;"> Delivery is within {{ $data['distance'] }} meters!</p>
    @else
        <p style="color: red;"> Delivery is {{ $data['distance'] }} meters away.</p>
    @endif
@elseif (isset($data['error']))
    <p style="color: red;">Error: {{ $data['error'] }}</p>
@else
    <p>No result received from the API.</p>
@endif