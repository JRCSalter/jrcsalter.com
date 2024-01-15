@props( [ 'name', 'options', 'optionvalue', 'selected' => '' ] )
@php
  $formattedname = str_replace(  ' ',      '_', strtolower( $name ) );
  $name          = preg_replace( '/ ID$/', '',  $name               );

  if ( old( $formattedname ) ) $selected = old( $formattedname );
@endphp

<label for="{{ $formattedname }}">{{ $name }}</label>
<select
  name="{{ $formattedname }}"
  id="{{ $formattedname }}"
  {{ $attributes }}
>
  <option value="0">No Option</option>

  @foreach ( $options as $key => $value )
    @if ( $value->id )
    <option value="{{ $value->id }}" {{ $selected == $value->id ? 'selected' : '' }}>{{ $value->$optionvalue }}</option>
    @endif
  @endforeach
</select>

<x-error :type=$formattedname />