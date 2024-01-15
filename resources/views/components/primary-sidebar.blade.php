<x-sidebar id="primary-sidebar">
  Primary Sidebar
  @auth
    <form method="POST" action="/admin/logout">
      @csrf
      <button type="submit">Logout</button>
    </form>
  @endauth
</x-sidebar>