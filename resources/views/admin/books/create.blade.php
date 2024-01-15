@php
  $series   = App\Models\Series::all();
  $seriesId = isset( $book->series ) ? old( 'series_id', $book->series->id) : NULL;
  $date     = date_format( date_create(), "Y-m-d" );
@endphp

<x-layout title="About the Author - JRCSalter.com">
  <x-header />
  <x-primary-nav />
  <h1>Create new Book</h1>
  <main>
    <div class="bg-light p-5 rounded">
      <h1>Add file</h1>
        
      <form action="/admin/books/store" method="post" enctype="multipart/form-data">
        @csrf

        <x-file name="cover"/>

        <x-input input="text" name="Supertitle"         />
        <x-input input="text" name="Title"      required/>
        <x-input input="text" name="Subtitle"           />
        
        <x-select
          name="Series ID"
          optionvalue="title"
          :options="App\Models\Series::all()"
        />
        
        <x-input
          input="number"
          name="Position in Series"
          :value="old( 'position_in_series', 0)"
        />

        <x-textarea name="Blurb"   >{{ old( 'blurb',   '') }}</x-textarea>
        <x-textarea name="Praise"  >{{ old( 'praise',  '') }}</x-textarea>
        <x-textarea name="Excerpt" >{{ old( 'excerpt', '') }}</x-textarea>
        
        <x-input input="date"   name="Published"  :value="$date"/>
        <x-input input="text"   name="Keywords"                 />
        <x-input input="text"   name="Chapters"                 />
        <x-input input="number" name="Word Count" :value="0"    />
        <x-input input="number" name="Pages"      :value="0"    />
        <x-input input="text"   name="ISBN"                     />
        <x-input input="text"   name="ISBN 13"                  />
        <x-input input="text"   name="ASIN"                     />
        
        @foreach ( App\Models\Book::$formats as $format )
          @foreach ( App\Models\Book::$currencies as $currency )
            @php $name = 'Cost ' . $format . ' ' . $currency @endphp
            <x-input input=text :name=$name value="0.00"/>
          @endforeach
        @endforeach
        
        <x-button>Submit</x-button>

      </form>
    </div>
  </main>
  <x-primary-sidebar />
  <x-secondary-sidebar />
  <x-footer />
</x-layout>