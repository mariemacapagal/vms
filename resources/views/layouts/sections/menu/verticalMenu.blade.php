<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

  <!-- ! Hide app brand if navbar-full -->
  <div class="app-brand demo">
    <a href="{{url('/')}}" class="app-brand-link">
      <span class="app-brand-logo demo">
        <img src="{{ asset('assets/img/favicon/favicon.png') }}" style="width: 50px;">
      </span>
      <span class="app-brand-text demo menu-text fw-bold ms-2">{{config('variables.templateName')}}</span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    {{-- Check if the user is authenticated --}}
    @auth
      {{-- Check if the user type is admin --}}
      @if(auth()->user()->type == "Admin")
        {{-- Iterate over admin menu --}}
        @foreach ($menuData[0]->menu as $menu)
          {{-- Add active and open class if child is active --}}
          {{-- Menu headers --}}
          @if (isset($menu->menuHeader))
            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">{{ __($menu->menuHeader) }}</span>
            </li>
          @else
            {{-- Active menu method --}}
            @php
            $activeClass = null;
            $currentRouteName = Route::currentRouteName();

            if ($currentRouteName === $menu->slug) {
              $activeClass = 'active';
            }
            elseif (isset($menu->submenu)) {
              if (gettype($menu->slug) === 'array') {
                foreach($menu->slug as $slug){
                  if (str_contains($currentRouteName,$slug) and strpos($currentRouteName,$slug) === 0) {
                    $activeClass = 'active open';
                  }
                }
              }
              else{
                if (str_contains($currentRouteName,$menu->slug) and strpos($currentRouteName,$menu->slug) === 0) {
                  $activeClass = 'active open';
                }
              }
            }
            @endphp

            {{-- Main menu --}}
            <li class="menu-item {{$activeClass}}">
              <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}" class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}" @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
                @isset($menu->icon)
                <i class="{{ $menu->icon }}"></i>
                @endisset
                <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
                @isset($menu->badge)
                  <div class="badge bg-{{ $menu->badge[0] }} rounded-pill ms-auto">{{ $menu->badge[1] }}</div>
                @endisset
              </a>

              {{-- Submenu --}}
              @isset($menu->submenu)
                @include('layouts.sections.menu.submenu',['menu' => $menu->submenu])
              @endisset
            </li>
          @endif
        @endforeach

      {{-- If user type is not admin (assume it's a regular user) --}}
      @else
        {{-- Iterate over user menu --}}
        @foreach ($userMenu[0]->menu as $menu)
          {{-- Add active and open class if child is active --}}
          {{-- Menu headers --}}
          @if (isset($menu->menuHeader))
            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">{{ __($menu->menuHeader) }}</span>
            </li>
          @else
            {{-- Active menu method --}}
            @php
            $activeClass = null;
            $currentRouteName = Route::currentRouteName();

            if ($currentRouteName === $menu->slug) {
              $activeClass = 'active';
            }
            elseif (isset($menu->submenu)) {
              if (gettype($menu->slug) === 'array') {
                foreach($menu->slug as $slug){
                  if (str_contains($currentRouteName,$slug) and strpos($currentRouteName,$slug) === 0) {
                    $activeClass = 'active open';
                  }
                }
              }
              else{
                if (str_contains($currentRouteName,$menu->slug) and strpos($currentRouteName,$menu->slug) === 0) {
                  $activeClass = 'active open';
                }
              }
            }
            @endphp

            {{-- Main menu --}}
            <li class="menu-item {{$activeClass}}">
              <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}" class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}" @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
                @isset($menu->icon)
                <i class="{{ $menu->icon }}"></i>
                @endisset
                <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
                @isset($menu->badge)
                  <div class="badge bg-{{ $menu->badge[0] }} rounded-pill ms-auto">{{ $menu->badge[1] }}</div>
                @endisset
              </a>

              {{-- Submenu --}}
              @isset($menu->submenu)
                @include('layouts.sections.menu.submenu',['menu' => $menu->submenu])
              @endisset
            </li>
          @endif
        @endforeach
      @endif
    {{-- If user is not authenticated --}}
    @else
      {{-- Default menu content --}}
      {{-- Output default menu --}}
    @endauth
  </ul>
</aside>
