@auth
    <form id="signout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
@endauth
