<x-layout title="About the Author - JRCSalter.com">
  <x-header />
  <x-primary-nav />
  <h1>Series</h1>
  <main>
    @foreach ( $series as $item )
      <p>
        {{ $item->title }}
        <a href="/admin/series/{{ $item->slug }}"     >View</a> |
        <a href="/admin/series/{{ $item->slug }}/edit">Edit</a> |
        <form method="POST" action="/admin/series/{{ $item->slug }}">
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