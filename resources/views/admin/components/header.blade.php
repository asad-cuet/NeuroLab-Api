<header class="header">
    <div class="container-fluid">
        <div class="header__wrapper">
            <div class="header__left d-flex align-items-center">
                <div class="menu-toggle mr-20">
                    <button id="menu-toggle" class="menu-toggle__btn">
                        Menu
                        <span></span>
                    </button>
                </div>
                <div class="header__search d-none d-md-flex">
                    <form action="#">
                        <input type="text" placeholder="Search..." />
                        <button><i class="lni lni-search-alt"></i></button>
                    </form>
                </div>
            </div>
            <div class="header__right">

                <div class="header__actions">
                    <!-- language start -->
                    <div class="header__language ml-15">
                        <button class="dropdown-toggle flag-toggle" type="button" id="language"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset(currentLangFlag()) }}" alt="country icon" />
                        </button>




                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="language">
                            <li>
                                <a href="{{ url('/admin/language/en') }}">
                                    <div class="header__language-image">
                                        <img src="{{ asset('assets/images/flags/en.svg') }}" alt="country icon" />
                                    </div>
                                    <div class="header__language-name">
                                        <p>English</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/admin/language/bn') }}">
                                    <div class="header__language-image">
                                        <img src="{{ asset('assets/images/flags/bn.svg') }}" alt="country icon" />
                                    </div>
                                    <div class="header__language-name">
                                        <p>Bengali</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#0">
                                    <div class="header__language-image">
                                        <img src="{{ asset('assets/images/flags/es.svg') }}" alt="country icon" />
                                    </div>
                                    <div class="header__language-name">
                                        <p>Spanish</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#0">
                                    <div class="header__language-image">
                                        <img src="{{ asset('assets/images/flags/de.svg') }}" alt="country icon" />
                                    </div>
                                    <div class="header__language-name">
                                        <p>German</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#0">
                                    <div class="header__language-image">
                                        <img src="{{ asset('assets/images/flags/fr.svg') }}" alt="country icon" />
                                    </div>
                                    <div class="header__language-name">
                                        <p>French</p>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- Language end -->

                    <!-- notification start, temporay comment -->
                    <div class="notification-box ml-15">
                        @php
                            $notification_data = myNotifications();
                        @endphp
                        <button class="dropdown-toggle" type="button" id="notification" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="lni lni-alarm"></i>
                            <span>{{ $notification_data['unseen_count'] }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notification">
                            @if (count($notification_data['all']))
                                @foreach ($notification_data['all'] as $notification)
                                    <li>
                                        <a href="#0">
                                            @if ($notification->image != '')
                                                <div class="image">
                                                    <img src="{{ asset('assets/images/author/1.png') }}"
                                                        alt="author img" />
                                                </div>
                                            @endif
                                            <div class="content">
                                                <h6>
                                                    {{ $notification->title }}
                                                    {{-- <span class="text-regular">
                                                        comment on a product.
                                                    </span> --}}
                                                </h6>
                                                <p>
                                                    {{ $notification->description }}
                                                </p>
                                                <span>{{ $notification->created_at->diffForHumans() }}</span>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            @else
                                <li class="text-center">
                                    No Notifications
                                </li>
                            @endif
                        </ul>
                    </div>
                    <!-- notification end -->
                </div>



                <!-- profile start -->
                <div class="profile ml-15">
                    <button class="dropdown-toggle author-toggle bg-transparent border-0" type="button" id="profile"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="profile__info">
                            <div class="profile__avatar">
                                @if (Auth::user()->avatar)
                                    <img src="{{ asset(Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" />
                                @else
                                    <img src="{{ asset('assets/images/author/author.png') }}"
                                        alt="{{ Auth::user()->name }}" />
                                @endif
                                <span class="status"></span>
                            </div>
                            <div class="profile__name">
                                <h6>{{ Auth::user()->name }}</h6>
                                <p>{{ showRoleName(Auth::user()) }}</p>
                            </div>
                            <i class="lni lni-chevron-down"></i>
                        </div>

                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profile">
                        <li>
                            <a href="{{ url('admin/profile') }}">
                                <i class="lni lni-user"></i>Profile
                            </a>
                        </li>
                        {{-- <li>
                            <a href="#0">
                                <i class="lni lni-alarm"></i> Notifications
                            </a>
                        </li> --}}
                        @can('setting-view')
                            <li>
                                <a href="{{ route('admin.settings.index') }}"> <i class="lni lni-cog"></i> Settings </a>
                            </li>
                        @endcan
                        <li>
                            <a href="javascript:;"
                                onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <i class="lni lni-share-alt"></i> Sign Out </a>
                        </li>
                    </ul>
                </div>
                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
                <!-- profile end -->
            </div>
        </div>

    </div>
</header>
