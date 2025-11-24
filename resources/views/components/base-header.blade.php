<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
    <h3 class="m-0 font-weight-bold">
        <i class="{{ $icon ?? 'fa-solid fa-list' }} pr-2"></i> {{ $title }}
    </h3>

    @if(isset($button))
        <button type="button"
                class="btn btn-outline-primary"
                id="{{ $button['id'] ?? 'btnAdd' }}">
            <i class="fa fa-plus"></i> {{ $button['label'] ?? 'Tambah' }}
        </button>
    @endif
</div>
