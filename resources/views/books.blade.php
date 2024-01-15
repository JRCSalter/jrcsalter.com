<x-layout title="Books - JRCSalter.com">
  <x-header />
  <x-primary-nav />
  
  <main id="main">
  
    <h1>Books</h1>
    @foreach( $books as $key => $value )
      @if ( is_array( $value ) )
        <hr>
        <h2>{{ $key }}</h2>
        @foreach( $value as $book )
          <x-display-book :series="$book->series()" :book="$book" />
        @endforeach
      @else
        <hr>
        <x-display-book :book="$value" />
      @endif
    @endforeach
  
  </main>
  
  <x-primary-sidebar />
  <x-secondary-sidebar />
  <x-footer />
</x-layout>