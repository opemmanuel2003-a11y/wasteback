@if (session('success'))
    <div class="alert alert-success" role="status"><x-icon name="check-circle" size="20" /> <span>{{ session('success') }}</span></div>
@endif
@if (session('error'))
    <div class="alert alert-error" role="alert"><x-icon name="alert" size="20" /> <span>{{ session('error') }}</span></div>
@endif
@if ($errors->any())
    <div class="alert alert-error" role="alert">
        <x-icon name="alert" size="20" />
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
