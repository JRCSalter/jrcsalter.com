<x-layout title="About the Author - JRCSalter.com">
  <x-header />
  <x-primary-nav />
  <h1>Create new Series</h1>
  <main>
    <div>
      <form action="/admin/series/store" method="post" enctype="multipart/form-data">
        @csrf
        
        <x-input input="text" name="Title" required />

        <x-textarea name="Description" />
        
        <x-file name="Image" />

        <x-button>Save</x-button>
      </form>
    </div>
  </main>
  <x-primary-sidebar />
  <x-secondary-sidebar />
  <x-footer />
</x-layout>