<x-guestLayout>
    
    <div class="max-w-3xl m-auto">
        <div class="text-2xl font-bold my-4">Alunos: {{ $students->count() }}</div>

        <div class="grid grid-cols-3 gap-3">
    
            @foreach ($students as $student)
                <div class="border rounded p-2">
                    <div>{{ $student->name }}</div>                    
                    <div>{{ $student->id }}</div>                    
                </div>            
            @endforeach
        </div>
    </div>
</x-guestLayout>