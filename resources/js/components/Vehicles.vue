<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Vehicles</div>
                    <ul class="list-group list-group-flush" v-for="vehicle in vehicles">
                        <router-link
                            class="list-group-item list-group-item-action"
                            :to="{ name: 'vehicles.show', params: { id: vehicle.id }}"
                        >
                            {{vehicle.name}}
                        </router-link>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                vehicles: []
            }
        },

        created() {
            this.read()
        },

        methods: {
            read: function () {
                window.axios.get('/api/vehicles').then(({ data }) => {
                    data.forEach(vehicle => {
                        this.vehicles.push(vehicle);
                    });
                });
            },
        }
    }
</script>
