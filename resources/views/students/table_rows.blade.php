@forelse ($students as $student)
    <tr id="student-row-{{ $student->id }}">
        <td>{{ $student->id }}</td>
        <td>{{ $student->name }}</td>
        <td>{{ $student->email }}</td>
        <td>{{ $student->age }}</td>
        <td>{{ $student->date_of_birth }}</td>
        <td>
            @if(strtoupper($student->gender) === 'M')
                Male
            @elseif(strtoupper($student->gender) === 'F')
                Female
            @else
                {{ $student->gender }}
            @endif
        </td>
        <td>{{ $student->score }}</td>
        <td>
          
            <button class="btn btn-edit full-edit-student-btn" data-id="{{ $student->id }}">Edit</button>
            
            <button class="btn btn-quick-edit quick-edit-student-btn" data-id="{{ $student->id }}">Quick Edit</button>
            
            <button class="btn btn-delete delete-student-btn" data-id="{{ $student->id }}">Delete</button>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="8" style="text-align: center; color: #721c24; font-weight: bold;">No Students Found!</td>
    </tr>
@endforelse