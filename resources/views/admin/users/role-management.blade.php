<div class="card">
  <div class="container">
    <h1>Role Management</h1>

    {{-- Display success message --}}
    @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif

    {{-- Form for assigning a role --}}
    <form action="{{ route('users.assignRole', $user) }}" method="POST">
      @csrf
      <div class="form-group">
        <label for="role">Assign Role</label>
        <select name="role" id="role" class="form-control">
          @foreach ($roles as $role)
            <option value="{{ $role }}">{{ $role }}</option>
          @endforeach
        </select>
      </div>
      <button type="submit" class="btn btn-primary mt-2">Assign Role</button>
    </form>

    {{-- List current roles and remove option --}}
    <h2>Current Roles</h2>
    @foreach ($user->getRoleNames() as $role)
      <div>{{ $role }}
        <form action="{{ route('users.removeRole', [$user, $role]) }}" method="POST" style="display:inline">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger btn-sm">Remove</button>
        </form>
      </div>
    @endforeach
  </div>
</div>
