@if(session('success'))
<div class="admin-alert admin-alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
<div class="admin-alert admin-alert-error">{{ session('error') }}</div>
@endif
@if(isset($errors) && $errors->any())
<div class="admin-alert admin-alert-error">
    <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
