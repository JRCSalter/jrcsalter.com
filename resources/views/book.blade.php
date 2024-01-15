<x-layout title="{{ $book->book_title }}">
  <x-header />
  <x-primary-nav />
  
  <main id="main">
    @if ( $book->series_id != NULL )
    <p>
      {{ $book->series()->title }}@if ( $book->position_in_series != NULL ): Book {{ $book->position_in_series }}@endif
    </p>
    @endif
  
    <h1>{{ $book->title }}</h1>
    
    @if ( $book->cover() )
      <img
        src="{{ asset( 'storage/' . $book->cover()->location ) }}"
        alt="{{ $book->cover()->title }} Cover"
      >
    @endif
  
    <p id="praise">{{ $book->praise }}</p>
    <p id="blurb">{{ $book->blurb }}</p>
    <p id="excerpt">{{ $book->excerpt }}</p>
    <p id="word_count">{{ $book->word_count }}</p>
    <p id="pages">{{ $book->pages }}</p>
    <p id="chapters">{{ $book->chapters }}</p>
    <p id="published">{{ $book->published }}</p>
    <p id="isbn">{{ $book->isbn }}</p>
    <p id="isbn_13">{{ $book->isbn_13 }}</p>
    <p id="asin">{{ $book->asin }}</p>
  
    @foreach( $book->getKeywords() as $keyword )
      <a href="/books/keywords/{{ strtolower( str_replace( ' ', '-', trim( $keyword ) ) ) }}">
        {{ trim( $keyword ) }}
      </a><br>
    @endforeach
    
    <p id="prices">
      @foreach ( $book::$formats as $format )
        <h4>{{ $format }}</h4>
        @foreach ( $book::$currencies as $currency )
          @if ( $book->getPrice( $format, $currency ) )
            {{ $book->getPrice( $format, $currency, true ) }}<br>
          @endif
        @endforeach
      @endforeach
    </p>
    
  </main>
  
  <x-primary-sidebar />
  <x-secondary-sidebar />
  <x-footer />
</x-layout>