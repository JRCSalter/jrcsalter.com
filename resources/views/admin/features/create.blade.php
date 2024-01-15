<x-layout title="About the Author - JRCSalter.com">
  <x-header />
  <x-primary-nav />
  <h1>Create new Feature</h1>
  <main>
    <div>
      <form action="/admin/features/store" method="post" enctype="multipart/form-data">
        @csrf
        
        <x-input input="text" name="Title" required />

        <label for="stand_alone">Stand Alone</label>
        <select name="stand_alone" id="stand_alone">
          <option value="0">No</option>
          <option value="1">Yes</option>
        </select>
        <x-error type="stand_alone"/>
        
        <x-input input="text" name="From" />
        
        <x-file name="file" />

        <x-button>Save</x-button>
      </form>
    </div>
  </main>
  <x-primary-sidebar />
  <x-secondary-sidebar />
  <x-footer />
</x-layout>
