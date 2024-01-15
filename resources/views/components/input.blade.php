@props( [ 'input', 'name', 'value' => '' ] )
@php
  $formattedname = str_replace(' ', '_', strtolower( $name ) );
  if ( $input == "date" ) $value = substr( $value, 0, 10 );
@endphp
        
<label for="{{ $formattedname }}">{{ $name }}</label>
<input
  type="{{ $input }}"
  name="{{ $formattedname }}"
  id="{{ $formattedname }}"
  value="{{ old( $formattedname, $value ) }}"
  {{ $attributes }}
>

<x-error :type=$formattedname />