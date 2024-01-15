<x-layout title="About the Author - JRCSalter.com">
  <x-header />
  <x-primary-nav />
  <h1>Edit {{ $feature->title }}</h1>
  <main>
    <div>
      <form action="/admin/features/{{ $feature->slug }}" method="post" enctype="multipart/form-data">
        @csrf
        @method( 'PATCH' )

        <x-input input="text" name="Title"      required :value="$feature->title"     />
        
        <x-textarea name="Contents"   >{{ old( 'contents', $feature->contents() ) }}</x-textarea>

        <label for="stand_alone">Stand Alone</label>
        <select name="stand_alone" id="stand_alone">
          <option value="0" {{ $feature->stand_alone == 0 ? 'selected' : '' }} >No</option>
          <option value="1" {{ $feature->stand_alone == 1 ? 'selected' : '' }}>Yes</option>
        </select>
        <x-error type="stand_alone"/>
        
        <x-input input="text" name="From" :value="$feature->from"/>
        

        <button type="submit">Save</button>

      </form>
    </div>
  </main>
  <x-primary-sidebar />
  <x-secondary-sidebar />
  <x-footer />
</x-layout>
