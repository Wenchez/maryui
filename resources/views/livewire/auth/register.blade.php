<div class="grow flex items-center justify-center bg-base-100">
    <div class="card w-full max-w-md shadow-xl bg-base-200">
        <div class="card-body">
            <h2 class="card-title justify-center mb-4">Crear cuenta</h2>

            <x-form wire:submit.prevent="register" first-error-only>
                <x-errors title="Oops!" description="Corrige los errores." icon="o-face-frown" />

                <x-input label="Nombre completo" wire:model.defer="name" first-error-only />
                <x-input label="Correo electrónico" wire:model.defer="email" type="email" first-error-only />
                <x-password label="Contraseña" wire:model.defer="password" first-error-only />
                <x-password label="Confirmar contraseña" wire:model.defer="password_confirmation" first-error-only />
                <x-select 
                    label="Rol" 
                    wire:model.defer="role" 
                    :options="[
                        ['value' => 'manager', 'label' => 'Gerente'],
                        ['value' => 'cashier', 'label' => 'Cajero'],
                    ]"
                    option-value="value" {{-- Indica que el valor real es la clave 'value' --}}
                    option-label="label" {{-- Indica que la etiqueta visible es la clave 'label' --}}
                    placeholder="Selecciona un rol" 
                    first-error-only 
                />

                <x-slot:actions>
                    <x-button label="Registrarse" class="btn-primary w-full" type="submit" spinner="register" />
                </x-slot:actions>
            </x-form>

            <p class="text-center text-sm mt-4">
                ¿Ya tienes una cuenta?
                <a href="{{ route('login') }}" class="link link-primary">Inicia sesión</a>
            </p>
        </div>
    </div>
</div>
