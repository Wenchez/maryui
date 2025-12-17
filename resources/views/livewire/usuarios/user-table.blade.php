<div>
    <x-card title="Usuarios" shadow separator class="border-5 shadow rounded-xl bg-base-200">

        <x-table :headers="$headers" :rows="$users" :sort-by="$sortBy" with-pagination per-page="perPage" :per-page-values="[5,10,20]">
            @scope('cell_role', $user)
                @php
                    // Mapear roles a etiquetas y colores
                    $roles = [
                        'cashier' => ['label' => 'Cajero', 'class' => 'badge-warning text-black p-4 font-bold'],
                        'manager' => ['label' => 'Gerente', 'class' => 'badge-success p-4 font-bold'],
                    ];
                    $role = $roles[$user->role] ?? ['label' => $user->role, 'class' => 'badge-primary p-4 font-bold'];
                @endphp

                <x-badge value="{{ $role['label'] }}" class="{{ $role['class'] }}" />
            @endscope

            @scope('cell_actions', $user)
                <div class="flex gap-2">
                    <x-button
                        icon="o-pencil"
                        wire:click.prevent="editUser({{ $user->user_id }})"
                        tooltip="Editar"
                        class="btn-warning btn-circle"
                    />

                    <x-button
                        icon="o-trash"
                        wire:click.prevent="deleteUser({{ $user->user_id }})"
                        tooltip="Eliminar"
                        class="btn-error btn-circle"
                    />
                </div>
            @endscope


        </x-table>

    </x-card>
</div>
