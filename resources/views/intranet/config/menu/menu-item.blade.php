@if ($item['submenu'] == [])
    <li class="dd-item dd3-item" data-id="{{ $item['id'] }}">
        <div class="dd-handle dd3-handle"></div>
        <div class="dd3-content {{ $item['url'] == 'javascript:;' ? 'font-weight-bold' : '' }}">
            <a href="{{ route('menu.edit', ['id' => $item['id']]) }}"
                class="mr-4">{{ $item['nombre'] . ' || Url->' . $item['url'] }} Icono -> <i style="font-size:20px;"
                    class="{{ isset($item['icono']) ? $item['icono'] : '' }}"></i></a>
            <a href="{{ route('menu.destroy', ['id' => $item['id']]) }}"
                class="eliminar-menu pull-right tooltipsC" title="Eliminar este menú"><i
                    class="text-danger fas fa-trash"></i></a>
        </div>
    </li>
@else
    <li class="dd-item dd3-item" data-id="{{ $item['id'] }}">
        <div class="dd-handle dd3-handle"></div>
        <div class="dd3-content {{ $item['url'] == 'javascript:;' ? 'font-weight-bold' : '' }}">
            <a href="{{ route('menu.edit', ['id' => $item['id']]) }}"
                class="mr-4">{{ $item['nombre'] . ' | Url->' . $item['url'] }} Icono -> <i style="font-size:20px;"
                    class="{{ isset($item['icono']) ? $item['icono'] : '' }}"></i></a>
            <a href="{{ route('menu.destroy', ['id' => $item['id']]) }}"
                class="eliminar-menu pull-right tooltipsC" title="Eliminar este menú"><i
                    class="text-danger fas fa-trash"></i></a>
        </div>
        <ol class="dd-list">
            @foreach ($item['submenu'] as $submenu)
                @include("intranet.config.menu.menu-item",[ "item" => $submenu ])
            @endforeach
        </ol>
    </li>
@endif
