<template>
    <div class="container">

        <div class="d-flex justify-content-between align-items-center pb-4">
            <h3>Vehicle Details</h3>
            <div>
                <ul class="list-group list-group-horizontal text-uppercase">
                    <li class="list-group-item border-0 bg-transparent">{{ label }}</li>
                </ul>
            </div>
        </div>

        <div class="row pb-4">
            <div class="col-3">
                <div class="nav flex-column nav-pills" id="vehicle-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" id="vehicle-meta-tab" data-toggle="pill" href="#vehicle-meta" role="tab" aria-controls="vehicle-meta" aria-selected="true">
                        <i class="fas fa-tag fa-fw"></i> Meta
                    </a>
                </div>
            </div>
            <div class="col-9">
                <div class="tab-content" id="vehicle-tabContent">
                    <div class="tab-pane fade show active" id="vehicle-meta" role="tabpanel" aria-labelledby="vehicle-meta-tab">
                        <div class="card">
                            <h5 class="card-header">Vehicle Metadata</h5>
                            <div class="card-body">
                                <form
                                    @submit.prevent="update"
                                    @keydown="form.errors.clear($event.target.name)"
                                >

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
                                            <label for="model">Model &amp; Trim</label>
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

                                    <div class="form-group">
                                        <label for="notes">Notes</label>
                                        <textarea class="form-control" id="notes" v-model="form.notes" :class="{'is-invalid': form.errors.has('notes')}"></textarea>
                                        <span class="invalid-feedback" v-for="error in form.errors.get('notes')">{{ error }}</span>
                                    </div>

                                    <button type="submit" class="btn btn-primary" :disabled="form.errors.any()">Update</button>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-row-reverse">
            <button type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#vehicleDeleteModal">Delete</button>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="vehicleDeleteModal" tabindex="-1" role="dialog" aria-labelledby="vehicleDeleteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="vehicleDeleteModalLabel">Are you sure</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Do you really want to delete this record? This process cannot be undone.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" @click="destroy">Delete</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import Form from "form-backend-validation";

    export default {
        data: function () {
            return {
                vehicle: {},
                form: new Form(['name', 'vin', 'license', 'make', 'model', 'year', 'notes']),
            }
        },

        created() {
            this.read();
        },

        watch: {
            '$route' () {
                this.read();
                this.form.reset();
                this.form.successful = false;
            }
        },

        computed: {
            label: function () {
                return [
                    this.vehicle.year, this.vehicle.make, this.vehicle.model
                ].filter(Boolean).join(" ");
            }
        },

        methods: {
            read: function () {
                window.axios.get(`/api/vehicles/${this.$route.params.id}`).then(({ data }) => {
                    this.vehicle = data;
                    this.form.populate(data);
                });
            },

            update: function () {
                this.form.put(`/api/vehicles/${this.$route.params.id}`).then(data => {
                    this.vehicle = data;
                    this.form.populate(data);
                    this.$eventBus.$emit('updateVehicles');
                })
            },

            destroy: function () {
                window.axios.delete(`/api/vehicles/${this.$route.params.id}`).then(() => {
                    $('#vehicleDeleteModal').modal('hide');
                    this.$router.push('/');
                    this.$eventBus.$emit('updateVehicles');
                });
            }
        }
    }
</script>
