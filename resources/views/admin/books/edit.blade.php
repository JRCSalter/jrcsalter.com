@php
  $series   = App\Models\Series::all();
  $seriesId = $book->series() !== NULL ? old( 'series_id', $book->series()->id) : NULL;
@endphp

<x-layout title="About the Author - JRCSalter.com">
  <x-header />
  <x-primary-nav />
  <h1>Edit {{ $book->title }}</h1>
  <main>
    <div>
      <h1>Add file</h1>
        
      <form action="/admin/books/{{ $book->slug }}" method="post" enctype="multipart/form-data">
        @csrf
        @method( 'PATCH' )

        <x-file name="cover" />
        @if ( $book->cover() )
          <img src="/storage/{{ $book->cover()->location }}" alt="{{ $book->title }} Cover">
        @endif

        <x-input input="text" name="Supertitle"          :value="$book->supertitle"/>
        <x-input input="text" name="Title"      required :value="$book->title"     />
        <x-input input="text" name="Subtitle"            :value="$book->subtitle"  />
        
        <x-select name="Series ID" optionvalue="title" :options=$series :selected="$seriesId"/>

        <x-input
          input="number"
          name="Position in Series"
          :value="$book->position_in_series ?? 0"
        />

        <x-textarea name="Blurb"   >{{ old( 'blurb',   $book->blurb   ) }}</x-textarea>
        <x-textarea name="Praise"  >{{ old( 'priase',  $book->praise  ) }}</x-textarea>
        <x-textarea name="Excerpt" >{{ old( 'excerpt', $book->excerpt ) }}</x-textarea>
        
        <x-input input="date"   name="Published"  :value="$book->published"      />
        <x-input input="text"   name="Keywords"   :value="$book->keywords"       />
        <x-input input="text"   name="Chapters"   :value="$book->chapters"       />
        <x-input input="number" name="Word Count" :value="$book->word_count ?? 0"/>
        <x-input input="number" name="Pages"      :value="$book->pages      ?? 0"/>
        <x-input input="text"   name="ISBN"       :value="$book->isbn"           />
        <x-input input="text"   name="ISBN 13"    :value="$book->isbn_13"        />
        <x-input input="text"   name="ASIN"       :value="$book->asin"           />
        
        @foreach ( App\Models\Book::$formats as $format )
          @foreach ( App\Models\Book::$currencies as $currency )
            @php $name = 'Cost ' . $format . ' ' . $currency; @endphp
            <x-input
              input=text
              :name="'Cost ' . $format . ' ' . $currency"
              :value="$book->getPrice( $format, $currency ) ?? '0.00'"
            />
          @endforeach
        @endforeach
        
        <button type="submit">Save</button>

      </form>
    </div>
  </main>
  <x-primary-sidebar />
  <x-secondary-sidebar />
  <x-footer />
</x-layout>