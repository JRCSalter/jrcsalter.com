@props( [ 'name' ] )
@php
  $formattedname = str_replace( ' ', '_', strtolower( $name ) );
@endphp

<label for="{{ $formattedname }}">{{ $name }}</label>
<textarea
  name="{{ $formattedname }}"
  id="{{ $formattedname }}"
  {{ $attributes }}
>{{ $slot }}</textarea>

<x-error :type=$formattedname />