<!DOCTYPE html>
<html>

<head>
  <title>Assign Grades</title>
</head>

<body>
  <h1>Assign Grades for {{ $student->name }}</h1>
  <form action="{{ route('assign-grades', $student->id) }}" method="POST">
    @csrf
    @method('PUT')
    <table>
      <tr>
        <th>Course</th>
        <th>Grade</th>
      </tr>
      @foreach ($student->courses as $course)
        <tr>
          <td>{{ $course->mk }}</td>
          <td>
            <input type="text" name="grades[{{ $course->id }}]" value="{{ $course->pivot->grade }}">
          </td>
        </tr>
      @endforeach
    </table>
    <button type="submit">Save Grades</button>
  </form>
</body>

</html>
