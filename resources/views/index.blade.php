@extends('layout.main')

@section('content')
    <div class="container">
        <p>Среднее значение характеристик всех сотрудников: {{ number_format($mean, 3) }}</p>
    </div>
    <div class="container">
        <form class="form-inline">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" id="search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
        <table class="table table-bordered table-dark search-table">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Фамилия</th>
                <th scope="col">Имя</th>
                <th scope="col">Отчество</th>
            </tr>
        </table>
    </div>
    <div class="card-columns">
        @foreach($employees as $employee)
            <div class="card text-center item" id="product-{{$employee->id}}">
                @if ($employee->image == null)
                    <img class="card-img-top" src="{{asset('images/avatar.png')}}" alt="">
                @else
                    <img class="card-img-top" src="{{asset('images/'.$employee->image)}}" alt="">
                @endif
                <div class="card-body">
                    <h4 class="card-title">{{$employee->surname}}</h4>
                    <h5 class="card-title">{{$employee->name}} {{$employee->patronymic}}</h5>
                    <p class="card-text">Количество проектов: {{$employee->projects->count()}}</p>
                    @unless($employee->features->isEmpty())
                        <p class="card-text">Характеристики:
                            <ul>
                                @foreach($employee->features as $feature)
                                    <li>{{ $feature->title }}: {{ $feature->pivot->weight }}</li>
                                @endforeach
                            </ul>
                    @endunless
                </div>
            </div>
        @endforeach
    </div>
@endsection