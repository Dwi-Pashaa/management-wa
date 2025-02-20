@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Oppss</strong>
        <ul>
            @foreach ($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif