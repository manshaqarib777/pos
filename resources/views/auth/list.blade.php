@extends('layouts.master')
@section('title')
    {{ __('user.userManagement') }}
@endsection
@push('breadcrumbs')
    @include('./partials.breadcrumbs',['group'=>__('user.users'),'links'=> [
    ['url' =>'','name' => __('user.userManagement')],
    ]])
@endpush
@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <caption>User List</caption>
                        <thead>
                            <tr>
                                <th scope="row" class="th-width-5"></th>
                                <th scope="row" class="th-width-10">{{ __('user.createdOn') }}</th>
                                <th scope="row" class="th-width-10">{{ __('user.group') }}</th>
                                <th scope="row" class="th-width-10">{{ __('user.name') }}</th>
                                <th scope="row" class="th-width-10">{{ __('user.email') }}</th>
                                <th scope="row" class="th-width-10">{{ __('user.phone') }}</th>
                                <th scope="row" class="th-width-10">{{ __('user.company') }}</th>
                                <th scope="row" class="th-width-25">{{ __('user.address') }}</th>
                                <th scope="row" class="th-width-10">{{ __('user.authPin') }}</th>
                                <th scope="row">{{ __('user.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $key => $user)
                                <tr>
                                    <td>
                                        <img src="/storage/{{ $user->image }}" class="logo-img-30wh" alt="User logo">
                                    </td>
                                    <td>{{ $user->created_at }}</td>
                                    <td>
                                        <a href="{{ route('permission.edit', $user->group->permissions) }}"
                                            class="btn-default" data-toggle="tooltip"
                                            title="{{ __('user.viewPermissionsBatch') }}">
                                            {{ $user->group->name }}
                                        </a>
                                    </td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>{{ $user->company }}</td>
                                    <td>{{ $user->address }}</td>
                                    <td title=" {{ __('user.clickToUpdateUserAuthenticaterFor') }}">
                                        <button onclick="userAuth('{{ $user->id }}')" class="btn btn-link btn-sm p-0">
                                            <i class="fa fa-key fa-lg text-success" aria-hidden="true"></i>
                                        </button>
                                        | <strong>{{ $user->pin }}</strong>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a class="btn btn-sm p-0" title="{{ __('user.editUser') }}"
                                                href="{{ route('user.edit', $user->id) }}">
                                                <i class="fa fa-edit fa-fw" aria-hidden="true"></i>
                                            </a>
                                            <div class="btn btn-sm text-danger p-0" title="{{ __('common.remove') }}"
                                                onclick="deleteUser('{{ $user->id }}')">
                                                <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="float-right"> {{ $users->links() }}</div>
                </div>
            </div>
        </div>
    </div>
    <!-- Pin -->
    <div class="modal fade" id="userPinModal" tabindex="-1" role="dialog" aria-labelledby="userPinModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header p-2">
                    <h4 class="modal-title">{{ __('user.authControl') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="auth_form">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="form-group" data-toggle="tooltip" title="{{ __('user.authPinTItle') }}">
                            <label>{{ __('user.autherizePin') }}</label>
                            <input type="text" name="pin" class="form-control" size="5" pattern="[0-9]{5}"
                                placeholder="{{ __('user.enterPin') }}" required>
                        </div>
                        <div class="form-group pt-0 permissionGroups" data-toggle="tooltip"
                            title="{{ __('user.groupTitle') }}">
                            <label for="group">{{ __('user.permissionGroup') }}</label> | <a
                                href="{{ route('group.create') }}"
                                class="btn btn-link btn-sm btn-info">{{ __('user.newGroup') }}</a>
                            <select class="form-control selectpicker" data-live-search="true" data-style="form-control"
                                id="group" name="group">
                                <option value="" selected>{{ __('user.keepExistingPermissionGroupNoNeedToChange') }}
                                </option>
                                @foreach ($groups as $group)
                                    <option value="{{ $group->id }}">{{ $group->name }}
                                        {{ __('user.permissionGroup') }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="button" class="btn btn-sm pull-left"
                            data-dismiss="modal">{{ __('common.cancel') }}</button>
                        <button class="float-right btn btn-sm btn-success btn-submit"
                            type="submit">{{ __('common.update') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--Del Modal -->
    <div class="modal fade" id="userDeleteModal" tabindex="-1" role="dialog" aria-labelledby="userDeleteModal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content text-danger">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('user.delWarning') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="delete_form">
                        {{ csrf_field() }}
                        <p>{{ __('user.areYouSure') }}</p>
                        {{ method_field('DELETE') }}
                        <button type="button" class="btn btn-sm pull-left"
                            data-dismiss="modal">{{ __('common.cancel') }}</button>
                        <button class="float-right btn btn-sm btn-danger"
                            type="submit">{{ __('common.yes.delete') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        function userAuth(user) {
            var from = document.getElementById('auth_form');
            from.action = '/user/' + user + '/pin';
            $('#userPinModal').modal('show');


        }

        function deleteUser(id) {
            var from = document.getElementById('delete_form');
            from.action = '/user/' + id;
            $('#userDeleteModal').modal('show');

        }

    </script>
@endpush
