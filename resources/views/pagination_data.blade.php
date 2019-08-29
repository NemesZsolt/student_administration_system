@if(count($students) > 0)
    @foreach($students as $student)
        <tr class="tr-element">
            <td><a href="{{route('students.edit', $student->id)}}">{{ $student->name }}</a></td>
            <td>@if(isset($student->gender->name)){{ $student->gender->name }}@else - @endif</td>
            <td>{{ $student->place_of_birth.','.$student->date_of_birth }}</td>
            <td>
                @if(count($student->enrolled) > 0)
                    @foreach($student->enrolled as $enrolledStudent)
                        {{$enrolledStudent->group->name}},
                    @endforeach
                @else
                    -
                @endif
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td>Empty</td>
        <td>Empty</td>
        <td>Empty</td>
        <td>Empty</td>
    </tr>
@endif
<tr>
    <td colspan="3" align="center">
        {!! $students->links() !!}
    </td>
</tr>

