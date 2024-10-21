<x-guestLayout>
    
    <div class="max-w-3xl m-auto">
        <div class="text-2xl font-bold my-4">Professores: {{ $teachers->count() }}</div>

        <div class="grid grid-cols-3 gap-3">
    
            @foreach ($teachers as $teacher)
                <div class="border rounded p-2">
                    <div>{{ $teacher->user->name }}</div>
                    <div>Grupo: {{ $teacher->code }}</div>
                    <div>Teacher ID: {{ $teacher->id }}</div>
                    <div>User  ID: {{ $teacher->user->id }}</div>
                </div>            
            @endforeach
        </div>
    </div>
</x-guestLayout>