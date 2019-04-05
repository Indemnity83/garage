<template>
    <nav class="navbar navbar-expand-md navbar-dark bg-primary">
        <div class="container">
            <router-link class="navbar-brand" to="/">
                Garage
            </router-link>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Vehicles
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <router-link
                                v-for="vehicle in vehicles"
                                :key="vehicle.id"
                                class="dropdown-item"
                                :to="{ name: 'vehicles.show', params: { id: vehicle.id }}"
                            >
                                {{vehicle.name}}
                            </router-link>
                            <div class="dropdown-divider"></div>
                            <button type="button" class="dropdown-item" data-toggle="modal" data-target="#addVehicleModel">
                                Add new
                            </button>
                        </div>
                    </li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">

                </ul>
            </div>
        </div>

        <div class="modal fade" id="addVehicleModel" tabindex="-1" role="dialog" aria-labelledby="addVehicleModelLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addVehicleModelLabel">Add a Vehicle</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form v-on:submit.prevent="createVehicle">
                            <div class="alert alert-success" v-if="form.successful">
                                Vehicle has been updated!
                            </div>

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" v-model="form.name" :class="{'is-invalid': form.errors.has('name')}">
                                <span class="invalid-feedback" v-for="error in form.errors.get('name')">{{ error }}</span>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="year">Year</label>
                                    <input type="text" class="form-control" id="year" v-model="form.year" :class="{'is-invalid': form.errors.has('year')}">
                                    <span class="invalid-feedback" v-for="error in form.errors.get('year')">{{ error }}</span>
                                </div>

                                <div class="form-group col-md-5">
                                    <label for="make">Make</label>
                                    <input type="text" class="form-control" id="make" v-model="form.make" :class="{'is-invalid': form.errors.has('make')}">
                                    <span class="invalid-feedback" v-for="error in form.errors.get('make')">{{ error }}</span>
                                </div>

                                <div class="form-group col-md-5">
                                    <label for="model">Model & Trim</label>
                                    <input type="text" class="form-control" id="model" v-model="form.model" :class="{'is-invalid': form.errors.has('model')}">
                                    <span class="invalid-feedback" v-for="error in form.errors.get('model')">{{ error }}</span>
                                </div>
                            </div>

                            <div class="form-row">

                                <div class="form-group col-md-4">
                                    <label for="license">License</label>
                                    <input type="text" class="form-control" id="license" v-model="form.license" :class="{'is-invalid': form.errors.has('license')}">
                                    <span class="invalid-feedback" v-for="error in form.errors.get('license')">{{ error }}</span>
                                </div>

                                <div class="form-group col-md-8">
                                    <label for="vin">VIN</label>
                                    <input type="text" class="form-control" id="vin" v-model="form.vin" :class="{'is-invalid': form.errors.has('vin')}">
                                    <span class="invalid-feedback" v-for="error in form.errors.get('vin')">{{ error }}</span>
                                </div>

                            </div>

                            <button type="submit" class="btn btn-primary" :disabled="form.errors.any()">Add</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
    import Form from "form-backend-validation";
    
    export default {
        data: function () {
            return {
                vehicles: [],
                form: new Form(['name', 'vin', 'license', 'make', 'model', 'year', 'notes']),
            }
        },

        created() {
            this.read();

            this.$eventBus.$on('updateVehicles', () => {
                this.read();
            });
        },

        methods: {
            read: function () {
                window.axios.get('/api/vehicles').then(({ data }) => {
                    this.vehicles = data;
                });
            },

            createVehicle: function() {
                this.form.post('/api/vehicles').then(data => {
                    $('#addVehicleModel').modal('hide');
                    this.$router.push({ name: 'vehicles.show', params: { id: data.id }});
                    this.$eventBus.$emit('updateVehicles');
                });
            }
        }
    }
</script>
