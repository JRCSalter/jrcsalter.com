<x-layout title="About the Author - JRCSalter.com">
  <x-header />
  <x-primary-nav />
  <h1>Edit {{ $series->title }}</h1>
  <main>
    <div>
      <form action="/admin/series/{{ $series->slug }}" method="post" enctype="multipart/form-data">
        @csrf
        @method( 'PATCH' )

        <x-input input="text" name="Title" required :value="$series->title"/>

        <x-textarea name="Description">{{ old( 'description', $series->description ) }}</x-textarea>

        <x-file name="image" :value="isset( $series->image()->name ) ?? ''"/>
        
        @if ( $series->image() )
          <img src="/storage/{{ $series->image()->location }}" alt="{{ $series->title }} Image">
        @endif

        <button type="submit">Save</button>

      </form>
    </div>
  </main>
  <x-primary-sidebar />
  <x-secondary-sidebar />
  <x-footer />
</x-layout>