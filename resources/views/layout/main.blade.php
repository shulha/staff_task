<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">

    <title>Test task</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset("css/style.css") }}" rel="stylesheet"/>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
            <a class="navbar-brand" href="/">TEST Task</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav mr-auto">
                    <router-link tag="li" to="/" exact class="nav-item">
                        <a class="nav-link">Сотрудники<span class="sr-only">(current)</span></a>
                    </router-link>
                    <router-link tag="li" :to="{name: 'createEmployee'}" exact class="nav-item">
                        <a class="nav-link">Создать</a>
                    </router-link>
                </ul>
            </div>
        </nav>

        <section class="section">
            <div class="container">
                <router-view name="employeesIndex"></router-view>
                <router-view></router-view>
            </div>
        </section>

    </div>

    <!-- Scripts -->
    <script src="{{asset("js/bootstrap.min.js")}}"></script>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>