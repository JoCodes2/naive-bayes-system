@props(['modalId', 'modalLabelId', 'formId', 'submitId', 'title', 'submitText'])
<div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="{{ $modalLabelId }}"
    aria-hidden="true">
    <div class="modal-dialog {{ $modalSize ?? 'modal-lg' }}">
        <div class="modal-content">

            {{-- HEADER --}}
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $modalLabelId }}">
                    {{ $title ?? 'Form Modal' }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            {{-- BODY --}}
            <div class="modal-body">
                <form id="{{ $formId }}" method="POST">
                    @csrf
                    {{ $slot }}   {{-- tempat isian form --}}
                    {{-- FOOTER --}}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="{{ $submitId }}">
                            {{ $submitText ?? 'Simpan' }}
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
