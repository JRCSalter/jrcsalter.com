<x-layout title="{{ $feature->title }}">
  <x-header />
  <x-primary-nav />
  
  <main id="main">
    <h1>{{ $feature->title }}</h1>
    @if ( ! $feature->stand_alone )
      <p>from {{ $feature->from }}</p>
    @endif

    <p>{!! $file !!}</p>
  
  </main>
  
  <x-primary-sidebar />
  <x-secondary-sidebar />
  <x-footer />
</x-layout>
