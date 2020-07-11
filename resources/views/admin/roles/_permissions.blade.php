<?php
$disabled = isset($options) ?  $options[0] : '';
$disabled = false;
$user = Auth::user();
?>

<div class="card">

    <div class="card-header" id="heading-{{ isset($title) ? Str::slug($title) : 'permission-heading' }}">
        <div class="btn btn-link collapsed d-flex align-items-center justify-content-between" data-toggle="collapse"
           data-target="#collapse-{{ isset($title) ? Str::slug($title) : 'permission-heading' }}" aria-expanded="false"
           aria-controls="collapse-{{ isset($title) ? Str::slug($title) : 'permission-heading' }}">
            <span>{{ ucfirst($title) }}</span>
            <a href="{{ route('roles.destroy', $role->id) }}" data-id="{{ $role->id }}" data-token="{{ csrf_token() }}" class="destroyRole text-right btn btn-primary btn-sm">Delete {{ ucfirst($role->name) }}</a>

        </div>
    </div>

    <div id="collapse-{{ isset($title) ? Str::slug($title) : 'permission-heading' }}" class="collapse"
         aria-labelledby="heading-{{ isset($title) ? Str::slug($title) : 'permission-heading' }}"
         data-parent="#accordion-role-permission" style="">
        <div class="card-body">
            <div class="row">
                @foreach($permissions as $perm)
                    <?php
                        $has_perm = false;
                        if (isset($role)) {
                            $has_perm = $role->hasPermissionTo($perm->name); // true or false
                        }
                    ?>

                    <div class="col-md-3">
                        <div class="form-check checkbox">
                            <label class="form-check-label {{ Str::contains($perm->name, 'delete') ? 'text-danger' : '' }}">
                                <input type="checkbox" {{ $has_perm ? ' checked' :  '' }} class="form-check-input" name="permissions[]" value="{{ $perm->name }}" {{ $disabled }}>{{ $perm->name }}
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @can('edit_roles')
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        @endcan
    </div>
</div>
