@if ($item['submenu'] == [])
    <li class="nav-item">
        <a href="{{ url($item['url']) }}" class="nav-link {{ MayoHelper::getMenuActivo($item['url']) }}"
            >
            <i class="nav-icon {{ $item['icono'] }}"></i>
            <p>
                <font style="vertical-align: inherit;">
                    <font style="vertical-align: inherit;">
                        {{ utf8_decode(utf8_encode($item['nombre'])) }}</font>
                </font>
            </p>
        </a>
    </li>
@else
    <li class="nav-item has-treeview">
        <a href="#" class="nav-link" >
            <i class="nav-icon {{ $item['icono'] }}"></i>
            <p>
                {{ utf8_decode(utf8_encode($item['nombre'])) }}
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            @foreach ($item['submenu'] as $submenu)
                @include("intranet.layout.menu-item", ["item" => $submenu])
            @endforeach
        </ul>
    </li>

@endif
