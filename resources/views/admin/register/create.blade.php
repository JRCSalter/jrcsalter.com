<x-layout title="About the Author - JRCSalter.com">
  <x-header />
  <x-primary-nav />
  <h1>Register User</h1>
  <main id="main">
    <form action="/admin/store" method="post">
      @csrf

      <x-input input="text"     name="Name"     />
      <x-input input="email"    name="Email"    />
      <x-input input="password" name="Password" />

      <x-button>Submit</x-button>

    </form>
  </main>
  <x-primary-sidebar />
  <x-secondary-sidebar />
  <x-footer />
</x-layout>