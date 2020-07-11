<!-- Name Form Input -->
<div class="form-group @if ($errors->has('name')) has-error @endif">
    <label for="name">Name :</label>
    <input type="text" class="form-control" name="name" id="name" value="{{ isset($user) ? $user->name : '' }}" placeholder="Name">
    @if ($errors->has('name'))
        <p class="help-block text-danger">{{ $errors->first('name') }}</p>
    @endif
</div>

<!-- email Form Input -->
<div class="form-group @if ($errors->has('email')) has-error @endif">
    <label for="email">Email :</label>
    <input type="email" class="form-control" name="email" id="email" value="{{ isset($user) ? $user->email : '' }}" placeholder="Email">
    @if ($errors->has('email'))
        <p class="help-block text-danger">{{ $errors->first('email') }}</p>
    @endif
</div>

<!-- password Form Input -->
<div class="form-group @if ($errors->has('password')) has-error @endif">
    <label for="password">Password :</label>
    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
    @if ($errors->has('password'))
        <p class="help-block text-danger">{{ $errors->first('password') }}</p>
    @endif
</div>

<!-- Roles Form Input -->
<div class="form-group @if ($errors->has('roles')) has-error @endif">
    <label for="roles[]">Roles :</label>
    <select class="form-control" name="roles[]" multiple>
        @foreach($roles as $role)
            <option {{ isset($user) && (in_array($role->id, $userRoleIds)) ?  'selected' : '' }} value="{{ $role->id }}">{{ $role->name }}</option>
        @endforeach
    </select>
    @if ($errors->has('roles')) <p class="help-block text-danger">{{ $errors->first('roles') }}</p> @endif
</div>
