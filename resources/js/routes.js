import NotFound from './components/NotFound';
import Home from './components/Home';
import Vehicles from './components/Vehicles';

export default {
    mode: 'history',

    routes: [
        {
            path: '*',
            component: NotFound
        },

        {
            path: '/',
            component: Home
        },

        {
            path: '/vehicles',
            component: Vehicles
        },

        {
            path: '/vehicles/:id',
            name: 'vehicles.show',
            component: Vehicles
        },

    ]
}
