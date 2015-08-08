@extends('layout.master')
@section('title','ซื้อคอร์ส')
@section('content')

        <div class="row">
            <div class="col-md-4">
                <div class="box box-solid box-success">
                    <div class="box-header with-border">
                        <h2 class="box-title">ข้อมูลลูกค้า</h2>
                    </div>

                    <div class="box-body">
                        {!! Form::open(['url' => '/permission/update']) !!}

                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>&nbsp;</th>
                                @foreach($roles as $role)
                                    <th class="text-center">{{ $role->display_name }}</th>
                                @endforeach
                            </tr>
                            <tr>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                                <th colspan="{{ count($roles) }}">&nbsp;</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($permissions as $permission)
                                <tr>
                                    <td width="150">{{ $permission->display_name }}</td>
                                    @foreach ($roles as $role)
                                        <td width="150" class="text-center">
                                            @if ($permission->hasRole($role->name) && $role->name == 'admin')
                                                <input type="checkbox" checked="checked" name="roles[{{ $role->id}}][permissions][]" value="{{ $permission->id }}" disabled="disabled">
                                                <input type="hidden" name="roles[{{ $role->id}}][permissions][]" value="{{ $permission->id }}">
                                            @elseif($permission->hasRole($role->name))
                                                <input type="checkbox" checked="checked" name="roles[{{ $role->id}}][permissions][]" value="{{ $permission->id }}">
                                            @else
                                                <input type="checkbox" name="roles[{{ $role->id }}][permissions][]" value="{{ $permission->id }}">
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                        <div class="form-group">
                            {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                        </div>
                        {!! Form::close() !!}
                </div>
            </div>

        </div>

    <script type="text/javascript">
        $(document).ready(function () {

        });

    </script>
@stop
