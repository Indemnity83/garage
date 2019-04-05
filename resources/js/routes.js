import NotFound from './components/NotFound';
import Home from './components/Home';
import Vehicle from './components/Vehicle';

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
            path: '/vehicles/:id',
            name: 'vehicles.show',
            component: Vehicle,
        },

    ]
}
