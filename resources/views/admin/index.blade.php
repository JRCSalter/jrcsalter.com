<x-layout title="JRCSalter.com">
  <x-header />
  <x-primary-nav />
  <main id="main">
    <h1>Admin</h1>
    @auth
    <ul>
      <li><a href="/admin/series/create"  >Add new Series</a></li>
      <li><a href="/admin/series/index"   >View Series</a></li>
      <li><a href="/admin/books/create"   >Add new Book</a></li>
      <li><a href="/admin/books/index"    >View Books</a></li>
      <li><a href="/admin/features/create">Add new Feature</a></li>
      <li><a href="/admin/features/index" >View Features</a></li>
    </ul>
    @else
      
    <form action="/admin/login" method="post">
      @csrf

      <x-input input="email"    name="Email"    />
      <x-input input="password" name="Password" />

      <x-button>Submit</x-button>

    </form>
    @endauth
  </main>
  <x-primary-sidebar />
  <x-secondary-sidebar />
  <x-footer />
</x-layout>