<template>
    <div>
        <div class="container">
            <p>Среднее значение характеристик всех сотрудников: {{ employees.mean }}</p>
        </div>
        <div class="container">
            <form class="form-inline" v-on:submit="search()">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" v-model="sea">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"></div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Фото</th>
                        <th>Фамилия</th>
                        <th>Имя</th>
                        <th>Отчество</th>
                        <th>Характеристики</th>
                        <th>Количество проектов</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="employee in employees.employees">
                        <td style="max-width: 250px"><img width="100%" height="auto" :src="'/images/'+employee.image" alt=""></td>
                        <td>{{ employee.surname }}</td>
                        <td>{{ employee.name }}</td>
                        <td>{{ employee.patronymic }}</td>
                        <td>
                            <ul v-for="( value, feature ) in  employee.features">
                                <li >{{ feature }}: {{ value }}</li>
                            </ul>
                        </td>
                        <td>{{ employee.projects.length }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                employees: [],
                sea: ''
            }
        },
        mounted() {
            var app = this;
            axios.get('/index')
                .then(function (resp) {
                    console.log(resp);
                    app.employees = resp.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Не удалось загрузить");
                });
        },
        methods: {
            search() {
                event.preventDefault();
                var app = this;
                var fio = {searchString: app.sea};
                axios.post('/search', fio)
                    .then(function (resp) {
                        console.log(resp);
                        app.employees = resp.data;
                    })
                    .catch(function (resp) {
                        alert("Не удалось загрузить");
                    });
            }
        }
    }
</script>