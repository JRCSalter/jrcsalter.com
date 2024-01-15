<x-layout title="About the Author - JRCSalter.com">
  <x-header />
  <x-primary-nav />
  <h1>Features</h1>
  <main>
    @foreach ( $features as $feature )
      <p>
        {{ $feature->title }}
        <a href="/admin/features/{{ $feature->slug }}"     >View</a> |
        <a href="/admin/features/{{ $feature->slug }}/edit">Edit</a> |
        <form method="POST" action="/admin/features/{{ $feature->slug }}">
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
