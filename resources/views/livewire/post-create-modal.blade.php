<div>
    {{-- The best athlete wants his opponent at his best. --}}
    <button type="button" wire:click="showModal">
        Download Invoice
    </button>

    <x-dialog-modal wire:model.live="modalOpen">
        <x-slot name="title">
            {{ __('Create post') }}
        </x-slot>

        <x-slot name="content">
            <div class="mt-4" x-data="{}" x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
                <!-- Title -->
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="title" value="{{ __('Title') }}" />
                    <x-input id="title" type="text" class="mt-1 block w-full" wire:model="state.title" required />
                    <x-input-error for="title" class="mt-2" />
                </div>

                <!-- content -->
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="content" value="{{ __('Content') }}" />
                    <x-textarea id="contet" class="mt-1 block w-full" wire:model="state.content" required />
                    <x-input-error for="content" class="mt-2" />
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('modalOpen')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-button class="ms-3" wire:click="createPost" wire:loading.attr="disabled">
                {{ __('Create') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>
</div>
