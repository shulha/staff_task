<template>
    <div>
        <h2>Создать карточку сотрудника</h2>
        <form v-on:submit="saveForm()">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-8">
                    <hr>
                    <div class="form-group">
                        <label class="control-label" for="surname">Фамилия</label>
                        <input class="form-control" type="text" id="surname" required
                               v-model="employee.surname"/>
                    </div>
                    <div class="row">
                        <div class="col form-group">
                            <label class="control-label" for="name">Имя</label>
                            <input class="form-control" type="text" id="name" required
                                   v-model="employee.name"/>
                        </div>
                        <div class="col form-group">
                            <label class="control-label" for="patronymic">Отчество</label>
                            <input class="form-control" type="text" id="patronymic" required
                                   v-model="employee.patronymic"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="image">Фото сотрудника</label>
                        <input class="form-control" name="image" id="image"
                               ref="image" type="file" />
                    </div>
                    <div class="form-inline form-group">
                        <label class="control-label">Характеристика сотрудника</label> <br>
                        <div class="col form-group" v-for="(feature, key) in employee.features">
                            <label class="control-label">{{ feature }}:</label>
                            <input class="form-control feat" type="number" min="0" max="10" required
                                   v-model="employee.weight[key]"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="project">Назначить проект</label>
                        <select class="form-control custom-select" id="project" required
                                v-model="employee.selected" multiple>
                            <option v-for="(value, key) in employee.projects" v-bind:value="key">
                                {{ value }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col form-group">
                    <button class="btn btn-primary btn-lg" type="submit">Создать</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                employee: {
                    surname: '',
                    name: '',
                    patronymic: '',
                    features: {},
                    weight: {},
                    projects: {},
                    selected: '',
                },
                image: ''
            }
        },
        mounted() {
            var app = this;
            axios.get('/create')
                .then(function (resp) {
                    app.employee.features = resp.data.features;
                    app.employee.projects = resp.data.projects;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Не удалось загрузить");
                });
        },
        methods: {
            saveForm() {
                event.preventDefault();
                const formData = new FormData();
                const files = this.$refs.image.files;
                if (files.length != 0) {
                    formData.append('image', files[0]);
                }
                var app = this;
                var newEmployee = JSON.stringify(app.employee);
                formData.append('employee', newEmployee);
                axios.post('/store', formData)
                    .then(function (resp) {
                        console.log(resp.data);
                        app.$router.push({path: '/'});
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Не удалось создать");
                    });
            },
        }
    }
</script>