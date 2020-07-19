@extends('admin.layout')

@section('title', 'Roles & Permissions')

@section('content')

    <!-- Modal -->
    <div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" id="roleForm">
                    @csrf

                    <div class="modal-header">
                        <h4 class="modal-title" id="roleModalLabel">Role</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name :</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Role Name">

                            <div class="text-danger my-2 p-2">
                                <p class="help-block"></p>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    @if($errors->has('name'))
        <script>
            $(function() {
                $('#roleModal').modal({
                    show: true
                });
            });
        </script>
    @endif

    <div class="card card-default">

        <div class="card-header card-header-border-bottom">
            <h5>Roles and Permissions</h5>
        </div>

        <div class="card-body">

            <div class="ajaxMessage"></div>

            @include('alert-message')

            <div id="accordion-role-permission" class="accordion accordion-bordered ">
                @forelse ($roles as $role)
                    <form action="{{ route('roles.update', $role->id) }}" method="POST" class="m-b">
                        @csrf
                        @method('PUT')

                        @if($role->name === 'Admin')
                            @include('admin.roles._permissions', [
                                    'title' => $role->name .' Permissions',
                                    'options' => ['disabled'],
                                    'showButton' => true
                                ])
                        @else
                            @include('admin.roles._permissions', [
                                    'title' => $role->name .' Permissions',
                                    'model' => $role,
                                    'showButton' => true
                                ])
                        @endif
                    </form>

                @empty
                    <p>No Roles defined, please run <code>php artisan db:seed</code> to seed some dummy data.</p>
                @endforelse
            </div>
        </div>

        @can('add_roles')
            <div class="card-footer text-right">
                <a href="#" class="btn btn-success pull-right" data-toggle="modal" data-target="#roleModal">
                    <i class="glyphicon glyphicon-plus"></i> New Role</a>
            </div>
        @endcan
    </div>
@endsection

@section('js')
<script>
    $(function () {
        $('.destroyRole').on('click', function (e) {
            if (!confirm("Do you want to remove this?")){
                return false;
            }
            e.preventDefault();
            var id = $(this).data("id");
            var token = $("meta[name='csrf-token']").attr("content");
            var url = e.target;
            $.ajax({
                url: url.href,
                type: 'DELETE',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id,
                },
                success: function(response) {
                    // console.log(response);
                    location.reload();
                },
                error: (response) => {
                    return false;
                }
            })
        });

        $('#roleForm').submit(function (e) {
            e.preventDefault();
            let formData = $(this).serializeArray();
            $(".help-block").text("");
            $("#registerForm input").removeClass("has-error");
            $.ajax({
                method: "POST",
                headers: {
                    Accept: "application/json"
                },
                url: "{{ route('roles.store') }}",
                data: formData,
                success: function(response) {
                    var successHtml = '<div class="alert alert-success">'+
                        '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
                        response.message +
                        '</div>';
                    $('.ajaxMessage').html(successHtml);
                    // $('#roleModal').modal('hide');
                    location.reload();
                },
                error: (response) => {
                    if(response.status === 422) {
                        let errors = response.responseJSON.errors;
                        Object.keys(errors).forEach(function (key) {
                            $("#" + key).addClass("has-error");
                            $(".help-block").text(errors[key][0]);
                        });
                    } else {
                        window.location.reload();
                    }
                }
            })
        });
    })
</script>
@endsection
