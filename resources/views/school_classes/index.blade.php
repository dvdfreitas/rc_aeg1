<x-guestLayout>
    
    <div class="max-w-3xl m-auto">
        <div class="text-2xl font-bold my-4">Turmas: {{ $school_classes->count() }}</div>

        <div class="grid grid-cols-3 gap-3">
    
            @foreach ($school_classes as $school_class)
                <div class="border rounded p-2">
                    <div>{{ $school_class->name }}</div>
                    <div>{{ $school_class->year }}</div>                    
                    @if ($school_class->teacher->first())
                        <div>{{ $school_class->teacher->first()->user->name }}</div>                    
                    @endif
                </div>            
            @endforeach
        </div>
    </div>
</x-guestLayout>