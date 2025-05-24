@inject('roles', 'Modules\Authorization\Repositories\Dashboard\RoleRepository')

{!! field()->text('name', __('trainer::dashboard.trainers.create.form.name')) !!}
{!! field()->email('email', __('trainer::dashboard.trainers.create.form.email')) !!}
{!! field()->text('mobile', __('trainer::dashboard.trainers.create.form.mobile')) !!}
{!! field()->password('password', __('trainer::dashboard.trainers.create.form.password')) !!}
{!! field()->password('confirm_password', __('trainer::dashboard.trainers.create.form.confirm_password')) !!}
{!! field()->file('image', __('trainer::dashboard.trainers.create.form.image'), $model->image ? asset($model->image) : '') !!}

<div class="form-group">
    <label class="col-md-2">
        {{ __('trainer::dashboard.trainers.create.form.roles') }}
    </label>
    <div class="col-md-9">
        <div class="mt-checkbox-list">
            @php $user = Modules\User\Entities\User::find($model->id); @endphp
            @foreach ($roles->getAllTrainersRoles('id', 'asc') as $role)
            <label class="mt-checkbox">
                <input type="checkbox" name="roles[]" @if ($user && $user->hasRole($role->name)) checked @endif
                value="{{ $role->id }}">
                {{ $role->display_name }}
                <span></span>
            </label>
            @endforeach
        </div>
    </div>
</div>
