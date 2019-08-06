import index from './pages/index';
import login from './pages/login';
import clientParams from './pages/clientParams';
import clientPartions from './pages/clientPartions';
import clientLinks from './pages/clientLinks';
import clientLinksWithUID from './pages/clientLinksWithUID';
import addClient from './pages/addClient';

export const routes = [
    {
        path: '/',
        component: index,
        name: 'index',
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/login',
        component: login,
        name: 'login'
    },
    {
        path: '/client/new',
        component: addClient,
        name: 'addClient',
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/client/:name/params',
        component: clientParams,
        name: 'clientParams',
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/client/:name/partions',
        component: clientPartions,
        name: 'clientPartions',
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/client/:name/links',
        component: clientLinks,
        name: 'clientLinks',
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/client/:name/linksWithUid',
        component: clientLinksWithUID,
        name: 'clientLinksWithUID',
        meta: {
            requiresAuth: true
        }
    },
];