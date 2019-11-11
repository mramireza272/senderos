
<!--Profile Widget-->
<!--================================-->
<div id="mainnav-profile" class="mainnav-profile">
    <div class="profile-wrap text-center">
        <div class="pad-btm">
            @if(is_null(auth()->user()->avatar))
                <img class="img-circle img-md" src="/img/profile-photos/1.png" alt="Foto de perfil">
            @else
                <img class="img-circle img-md" src="{{ '/avatar/' . auth()->user()->id }}" alt="Foto de perfil">
            @endif

        </div>
        <a href="#profile-nav" class="box-block" data-toggle="collapse" aria-expanded="false">
            <span class="pull-right dropdown-toggle">
                <i class="dropdown-caret"></i>
            </span>
            <p class="mnp-name">{{ auth()->user()->name }}</p>
            <span class="mnp-desc"><b></b></span><br>
            <span class="mnp-desc">{{ auth()->user()->email }}</span>

        </a>
    </div>
    <div id="profile-nav" class="collapse list-group bg-trans">
        <a href="#{{-- route('usuarios.edit', app.user.id) --}}" class="list-group-item">
            <i class="pli-male icon-lg icon-fw"></i> Ver perfil
        </a>
        <a href="#" class="list-group-item">
            <i class="pli-gear icon-lg icon-fw"></i> Configuración
        </a>
        <a href="#" class="list-group-item">
            <i class="pli-information icon-lg icon-fw"></i> Ayuda
        </a>
        <a href="{{ url('/logout') }}" class="list-group-item">
            <i class="pli-unlock icon-lg icon-fw"></i> Salir
        </a>
    </div>
</div>


<!--Shortcut buttons-->
<!--================================-->
<div id="mainnav-shortcut" class="hidden">
    <ul class="list-unstyled shortcut-wrap">
        <li class="col-xs-3" data-content="My Profile">
            <a class="shortcut-grid" href="#">
                <div class="icon-wrap icon-wrap-sm icon-circle bg-mint">
                <i class="pli-male"></i>
                </div>
            </a>
        </li>
        <li class="col-xs-3" data-content="Messages">
            <a class="shortcut-grid" href="#">
                <div class="icon-wrap icon-wrap-sm icon-circle bg-warning">
                <i class="pli-speech-bubble-3"></i>
                </div>
            </a>
        </li>
        <li class="col-xs-3" data-content="Activity">
            <a class="shortcut-grid" href="#">
                <div class="icon-wrap icon-wrap-sm icon-circle bg-success">
                <i class="pli-thunder"></i>
                </div>
            </a>
        </li>
        <li class="col-xs-3" data-content="Lock Screen">
            <a class="shortcut-grid" href="#">
                <div class="icon-wrap icon-wrap-sm icon-circle bg-purple">
                <i class="pli-lock-2"></i>
                </div>
            </a>
        </li>
    </ul>
</div>
<!--================================-->
<!--End shortcut buttons-->


<ul id="mainnav-menu" class="list-group">

    <!--Category name-->
    <li class="list-header">Menú</li>

    <!--Menu list item-->
    {{--<li>
        <a href="#" class="active-sub">
            <i class="pli-home"></i>
            <span class="menu-title">Principal</span>
			<i class="arrow"></i>
        </a>

        <!--Submenu-->
        <ul class="collapse">
            <li><a href="index.html">Dashboard 1</a></li>
			<li><a href="dashboard-2.html">Dashboard 2</a></li>
			<li><a href="dashboard-3.html">Dashboard 3</a></li>

        </ul>
    </li>--}}

    @foreach(Session::get('Current.menu') as $key => $menu)
        <li{!! $menu['active'] !!}>
            <a href="{{ $menu['url'] }}"{{ isset($menu['target'])?$menu['target']:'' }}>
                <i class="{{ $menu['icon'] }}"></i>
                <span class="menu-title">{{ $key }}</span>
                @if(isset($menu['submenu']))
                    <i class="arrow"></i>
                @endif
            </a>
            @if(isset($menu['submenu']))
                <ul class="collapse">
                @foreach($menu['submenu'] as $submenu_key => $submenu)
                    <li>
                        <a href="{{ $submenu['url'] }}"{{ isset($submenu['target'])?$submenu['target']:'' }}>
                            <i class="{{ $submenu['icon'] }}"></i>
                            {{ $submenu_key }}
                        </a>
                    </li>
                @endforeach
                </ul>
            @endif
        </li>
    @endforeach

    {{--
    @php($url = str_replace(url('/'),'',url()->current()))
    <!--Menu list item-->
    <li
        @if($url == '')
            class="active-sub"
        @endif
    >
        <a href="{{ url('/') }}">
            <i class="pli-home"></i>
            <span class="menu-title">Principal</span>
        </a>
    </li>
    <li
        @if(strpos($url,str_replace(url('/'),'',route('proyectos.index'))) !== false)
            class="active-sub"
        @endif
    >
        <a href="#">
            <i class="pli-file-clipboard-file-text"></i>
            <span class="menu-title">Programas</span>
            <i class="arrow"></i>
        </a>

        <ul class="collapse">
            <li><a href="{{ route('proyectos.index') }}">100 días</a></li>
            <li><a href="{{ route('proyectos.primero') }}">Primer año</a></li>
            <li><a href="{{ route('proyectos.prioritario') }}">Prioritarios</a></li>

        </ul>
    </li>
    <li
        @if(strpos($url,str_replace(url('/'),'','/usuarios')) !== false)
            class="active-sub"
        @endif
    >
        <a href="{{ url('/usuarios') }}">
            <i class="pli-male-female"></i>
            <span class="menu-title">Usuarios</span>
        </a>
    </li>
    <li
        @if(strpos($url,str_replace(url('/'),'','/estructuras')) !== false)
            class="active-sub"
        @endif
    >
        <a href="{{ url('/estructuras') }}">
            <i class="pli-id-3"></i>
            <span class="menu-title">Estructuras</span>
        </a>
    </li>
    <li
        @if(strpos($url,str_replace(url('/'),'','/reuniones')) !== false)
            class="active-sub"
        @endif
    >
        <a href="{{ url('/reuniones') }}">
            <i class="pli-calendar-3"></i>
            <span class="menu-title">Reuniones</span>
        </a>
    </li>

    <li
        @if(strpos($url,str_replace(url('/'),'','/formulario')) !== false)
            class="active-sub"
        @endif
    >
        <a target="_blank" href="{{ url('/formulario') }}">
            <i class="pli-file-copy"></i>
            <span class="menu-title">Formulario</span>
        </a>
    </li>
    --}}
   	<li class="list-divider"></li>
    <li>
        <a href="{{ url('/logout') }}">
            <i class="pli-power-3"></i>
            <span class="menu-title">Salir</span>
        </a>
    </li>
</ul>
<!--================================-->
<!--End widget-->
