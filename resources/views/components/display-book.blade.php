@props( [ 'series' => NULL, 'book' ] )

<section class="book-section">
  <h3>{{ $book->book_title }}</h3>
  @if ( $series )
  <a href="/series/{{ $series->slug }}/{{ $book->slug }}">
  @else
  <a href="/books/{{ $book->slug }}">
  @endif
  <img src="{{ asset( 'storage/' . $book->cover()->location ) }}" alt="{{ $book->title }} Cover">
  </a>
</section>