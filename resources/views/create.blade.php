@extends('layout.main')

@section('content')
    <h1>Создать карточку сотрудника</h1>
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" enctype="multipart/form-data" action="{{route('store_employee')}}">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-8">
                <hr>
                <div class="form-group">
                    <label class="control-label" for="surname">Фамилия</label>
                    <input class="form-control" type="text" id="surname" required
                           name="surname" value="{{ old('surname') }}"/>
                </div>
                <div class="row">
                    <div class="col form-group">
                        <label class="control-label" for="name">Имя</label>
                        <input class="form-control" type="text" id="name" required
                               name="name" value="{{ old('name') }}"/>
                    </div>
                    <div class="col form-group">
                        <label class="control-label" for="programName">Отчество</label>
                        <input class="form-control" type="text" id="patronymic" required
                               name="patronymic" value="{{ old('patronymic') }}"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="image">Фото сотрудника</label>
                    <input class="form-control" type="file" id="image"
                           name="image" value="{{ old('image') }}"/>
                </div>
                <div class="form-inline form-group">
                    <label class="control-label">Характеристика сотрудника</label> <br>
                    @foreach($features as $id => $feature)
                        <div class="col form-group">
                            <label class="control-label" for="feature_list[{{ $id }}]">{{ $feature }}: </label>
                            <input class="form-control feat" type="number" id="feature_list[{{ $id }}]" min="0" max="10" required
                                   name="feature_list[{{ $id }}]" value=""/>
                        </div>
                    @endforeach
                </div>
                <div class="form-group">
                    <label class="control-label" for="project">Назначить проект</label>
                    <select class="form-control custom-select" id="project" required
                            name="project_list[]" >
                        <option selected value="">Выберите проект</option>
                        @foreach($projects as $id => $project)
                            <option value="{{ $id }}">{{ $project }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="row">
            <div class="col form-group">
                <button class="btn btn-primary btn-lg" type="submit">Submit</button>
            </div>
        </div>
    </form>
    <div id="my_div"></div>
@endsection