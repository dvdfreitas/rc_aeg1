<x-guestLayout>
    
    <div class="max-w-3xl m-auto">
        <div class="text-2xl font-bold my-4">Diretores de Turma: {{ $school_class_teachers->count() }}</div>

        <div class="grid grid-cols-1 gap-3">
    
            @foreach ($school_class_teachers as $school_class_teacher)
                <div class="border rounded p-2">
                    <div>{{ $school_class_teacher->teacher->user->name }}</div>                    
                    <div>{{ $school_class_teacher->schoolClass->name }}</div>                    
                    
                </div>            
            @endforeach
        </div>
    </div>
</x-guestLayout>