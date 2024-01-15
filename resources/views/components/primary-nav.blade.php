@php
  $menu = App\Models\Book::allWithSeries();
  $features = App\Models\Feature::all();
@endphp

<nav id="primary-nav">
  <ul>
    <li>
      <a href="/">
        Home
      </a>
    </li>
    <li>
      <a href="/books">
        Books
      </a>
      <ul>
      @foreach ( $menu as $key => $value ) 
      @if ( is_array( $value ) ) 
        <li>
          <a href="/series/{{ $value[0]->series()->slug }}">
            {{ $key }}
          </a>
          <ul>
          @foreach ( $value as $book ) 
            <li>
              <a href="/series/{{ $book->series()->slug }}/{{ $book->slug }}">
                {{ $book->title }}
              </a>
            </li>
          @endforeach 
          </ul>
        </li>
      @else 
        <li>
          <a href="/books/{{ $value->slug }}">
            {{ $value->title }}
          </a>
        </li>
      @endif 
      @endforeach 
      </ul>
    </li>
    <li>
      <a href="/features">
        Features
      </a>
      <ul>
        @foreach ( $features as $feature )
          <li>
            <a href="/features/{{ $feature->slug }}">{{ $feature->title }}</a>
          </li>
        @endforeach
      </ul>
    </li>
    <li>
      <a href="/blog">
        Blog
      </a>
    </li>
    <li>
      <a href="/about">
        About
      </a>
    </li>
  </ul>
</nav>