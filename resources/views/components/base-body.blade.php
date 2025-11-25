<div class="card">
    <div class="card-header mt-2 mb-0 d-flex flex-row align-items-center justify-content-between">
        <h5 class="m-0 font-weight-bold">
            {{ $title }}
        </h5>

        @if(isset($button))
            <button type="button"
                    class="btn btn-outline-primary btn-sm"
                    id="{{ $button['id'] ?? 'btnAdd' }}">
                <i class="fa fa-plus"></i> {{ $button['label'] ?? 'Tambah' }}
            </button>
        @endif
    </div>
    <div class="card-body ">
        {{ $slot }}
    </div>
</div>
