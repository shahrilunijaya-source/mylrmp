<x-layouts.officer title="Kawalan Akses">
    <div class="pg-title">Kawalan Akses</div>
    @foreach($permissionGroups ?? [] as $group => $permissions)
        @foreach($permissions as $permission)
            <span>{{ $permission->name }}</span>
        @endforeach
    @endforeach
</x-layouts.officer>
