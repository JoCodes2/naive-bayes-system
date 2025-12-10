@props(['initId', 'columns', 'col'])
<div class="table-responsive">
    <table id="{{ $initId }}" class="table table-striped table-bordered">
        <thead>
            <tr>
                @foreach ($columns as $col)
                    <th>{{ $col }}</th>
                @endforeach
            </tr>
        </thead>

        {{ $slot }}
    </table>
</div>
