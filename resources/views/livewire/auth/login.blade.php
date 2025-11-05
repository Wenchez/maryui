<div class="grow flex items-center justify-center bg-base-100">
    <div class="card w-full max-w-md shadow-xl bg-base-200">
        <div class="card-body">
            <h2 class="card-title justify-center mb-4">Iniciar sesión</h2>

            <x-form wire:submit.prevent="login" first-error-only>
                <x-errors title="Oops!" description="Corrige los errores." icon="o-face-frown" />

                <x-input label="Correo electrónico" type="email" wire:model.defer="email" placeholder="tu@correo.com"
                    first-error-only />

                <x-password label="Contraseña" wire:model.defer="password" placeholder="********" first-error-only />

                {{-- Recordarme --}}
                <div class="form-control mt-2">
                    <label class="label cursor-pointer justify-start gap-2">
                        <x-checkbox wire:model="remember" />
                        <span class="label-text">Recordarme</span>
                    </label>
                </div>

                <x-slot:actions>
                    <x-button label="Iniciar sesión" class="btn-primary w-full" type="submit" spinner="login" />
                </x-slot:actions>
            </x-form>

            <p class="text-center text-sm mt-4">
                ¿No tienes cuenta?
                <a href="{{ route('register') }}" class="link link-primary">Regístrate aquí</a>
            </p>
        </div>
    </div>
</div>
