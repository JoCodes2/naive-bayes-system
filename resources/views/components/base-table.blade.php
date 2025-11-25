<table id="{{ $initId }}" class="table table-borderless">
    <thead>
        <tr>
            @foreach($columns as $col)
                <th>{{ $col }}</th>
            @endforeach
        </tr>
    </thead>

    {{ $slot }}
</table>
