<aside class="sidebar @if(getSetting('sidebar_theme')=='light') sidebar--style2 @endif">
  <div class="sidebar__logo text-center">
    <a href="{{route('admin')}}">
      @if(getSetting('sidebar_theme')=='light')
      <img src="{{asset(getSetting('dark_logo','assets/images/logo/logo-dark.png'))}}" alt="logo" />
      @else
      <img src="{{asset(getSetting('light_logo','assets/images/logo/logo.png'))}}" alt="logo" />
      @endif
    </a>
  </div>
  <div class="sidebar__body data-simplebar">
    <nav class="sidebar__nav">
      {{-- {{dd(config('left_sidebar_menus'))}} --}}
        {{ AdminSidebar::renderVerMenu(config('left_sidebar_menus')) }}
    </nav>
  </div>
  <div class="sidebar__close">
    <i class="lni lni-close"></i>
  </div>
</aside>