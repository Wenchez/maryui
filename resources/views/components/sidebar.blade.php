<div class="sticky top-0 bg-base-100 shadow px-4 py-2 flex items-center justify-between">
    <div class="text-xl font-bold">Ximenabags</div>
    <label for="main-drawer" class="cursor-pointer btn btn-ghost btn-circle">
        <x-icon name="o-x-mark" class="w-6 h-6" />
    </label>
</div>

<x-menu activate-by-route>
    <x-menu-item title="Home" icon="o-home" link="#" />
    <x-menu-item title="Messages" icon="o-envelope" link="#" />
    
    <x-menu-sub title="Settings" icon="o-cog-6-tooth">
        <x-menu-item title="Wifi" icon="o-wifi" link="#" />
    <x-menu-item title="Archives" icon="o-archive-box" link="#" />
  </x-menu-sub>
</x-menu>