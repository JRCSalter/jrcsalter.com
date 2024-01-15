<x-layout title="JRCSalter.com">
  <x-header />
  <x-primary-nav />
  <main id="main">
    <h1>Log in!</h1>
    <form action="/admin/login" method="post">
      @csrf

      <x-input input="email"    name="Email"    />
      <x-input input="password" name="Password" />

      <button type="submit">
        Submit
      </button>

    </form>
  </main>
  <x-primary-sidebar />
  <x-secondary-sidebar />
  <x-footer />
</x-layout>