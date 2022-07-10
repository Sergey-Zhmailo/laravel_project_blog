<header class="shadow-sm py-4">
    <div class="container">
        <div class="row">
            <div class="col-4">
                <h3 class="m-0">
                    @if(Route::currentRouteName() == 'home')
                        Laravel blog
                    @else
                        <a href="{{ route('home') }}" style="text-decoration: none; color: inherit;">Laravel blog</a>
                    @endif
                </h3>
            </div>
            <div class="col-8 text-end">
                @auth('web')
                    <div class="btn-group">
                        <a href="{{ route('dashboard') }}" type="button" class="btn btn-outline-primary">{{ auth('web')
                        ->user()->name }}</a>
                        <button type="button" class="btn btn-outline-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <span class="dropdown-item">{{ auth('web')->user()->email }}
                                    @if(auth('web')->user()->email_verified_at)
                                        Verified
                                    @endif
                                </span>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                        </ul>
                    </div>
                @endauth
                @guest('web')
                    <div class="btn-group">
                        <a href="{{ route('login') }}" type="button" class="btn btn-outline-secondary">Guest</a>
                        <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('login') }}">Login</a></li>
                            <li><a class="dropdown-item" href="{{ route('register') }}">Register</a></li>
                        </ul>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</header>
