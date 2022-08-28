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
            <div class="col-4">
                @include('front.elements.search')
            </div>
            <div class="col-4 text-end">
                @auth('web')
                    <div class="btn-group">
                        <a href="{{ route('profile') }}" type="button" class="btn btn-outline-primary d-flex align-items-center">
                            <span class="avatar-image-wrapper">
                                @if(auth('web')->user()->getFirstMedia('avatars'))
                                    <img src="{{ auth('web')->user()->getFirstMedia('avatars')->getUrl('thumb') }}"
                                         class="" alt="user avatar">
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><path fill="#e9ecef" d="M248
                                    8C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm128 421.6c-35.9 26.5-80.1 42.4-128 42.4s-92.1-15.9-128-42.4V416c0-35.3 28.7-64 64-64 11.1 0 27.5 11.4 64 11.4 36.6 0 52.8-11.4 64-11.4 35.3 0 64 28.7 64 64v13.6zm30.6-27.5c-6.8-46.4-46.3-82.1-94.6-82.1-20.5 0-30.4 11.4-64 11.4S204.6 320 184 320c-48.3 0-87.8 35.7-94.6 82.1C53.9 363.6 32 312.4 32 256c0-119.1 96.9-216 216-216s216 96.9 216 216c0 56.4-21.9 107.6-57.4 146.1zM248 120c-48.6 0-88 39.4-88 88s39.4 88 88 88 88-39.4 88-88-39.4-88-88-88zm0 144c-30.9 0-56-25.1-56-56s25.1-56 56-56 56 25.1 56 56-25.1 56-56 56z"/></svg>
                                @endif
                            </span>

                            <span>{{ auth('web')->user()->name }}</span>
                        </a>
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
                            <li><a class="dropdown-item" href="{{ route('profile') }}">Profile</a></li>
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

{{--Toasts--}}
<div class="toast-container position-absolute top-0 end-0 p-3">
    @if(session('success'))
        <div class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive"
             aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session()->get('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    @endif
        @if(session('info'))
        <div class="toast align-items-center text-white bg-info border-0" role="alert" aria-live="assertive"
             aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session()->get('info') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    @endif
    @if($errors->any())
        <div class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive"
             aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    {{ $errors->first() }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    @endif


</div>
