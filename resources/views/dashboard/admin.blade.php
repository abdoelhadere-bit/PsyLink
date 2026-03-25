<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($nonValidPros as $pro)
            <tr>
                <td>{{ $pro->user->name }}</td>
                <td>{{ $pro->user->email }}</td>
                <td>
                    <form action="{{ route('admin.validate', $pro->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">Validate</button>
                    </form>                
                </td>
            </tr>
        @endforeach
    </tbody>
</table>