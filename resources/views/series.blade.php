<x-layout title="{{ $series->title }}">
  <x-header />
  <x-primary-nav />
  
  <main id="main">
    <h1>{{ $series->title }}</h1>

    @foreach( $series->books as $book )
      <p><a href="/series/{{ $series->slug }}/{{ $book->slug }}">
        Book {{ $book->position_in_series }}: {{ $book->title }}
      </a></p>
    @endforeach
  </main>
  
  <x-primary-sidebar />
  <x-secondary-sidebar />
  <x-footer />
</x-layout>

