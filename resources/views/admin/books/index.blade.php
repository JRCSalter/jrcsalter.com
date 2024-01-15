<x-layout title="About the Author - JRCSalter.com">
  <x-header />
  <x-primary-nav />
  <h1>Books</h1>
  <main>
    @foreach ( $books as $book )
      @php $series = $book->series(); @endphp
      <p>
        @if( $series === NULL )
          {{ $book->title }}
        @else
          {{ $series->title }} - Book {{ $book->position_in_series }}: {{ $book->title }}
        @endif
        <a href="/books/{{ $book->slug }}"     >View</a> |
        <a href="/admin/books/{{ $book->slug }}/edit">Edit</a> |
        <form method="POST" action="/admin/books/{{ $book->slug }}">
          @csrf
          @method('DELETE')
          <x-button>Delete</x-button>
        </form>
      </p>
    @endforeach
  </main>
  <x-primary-sidebar />
  <x-secondary-sidebar />
  <x-footer />
</x-layout>