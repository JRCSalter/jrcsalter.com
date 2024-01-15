@props( [ 'name' ] )
@php
  $formattedname = str_replace(' ', '_', strtolower( $name ) );
@endphp
        
<label for="{{ $name }}">{{ $name }}</label>
<input
  type="file"
  name="{{ $formattedname }}"
  id="{{ $formattedname }}"
  accept=".jpg,.jpeg,.bmp,.png,.gif,.doc,.docx,.csv,.rtf,.xlsx,.xls,.txt,.pdf,.zip"
  {{ $attributes }}
>

<x-error :type=$formattedname/>