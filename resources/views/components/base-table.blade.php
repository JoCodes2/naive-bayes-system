<table class="table table-bordered table-striped">
    <thead>
        <tr>
            @foreach($columns as $col)
                <th>{{ $col }}</th>
            @endforeach
        </tr>
    </thead>

    {{ $slot }}
</table>
