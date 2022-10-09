import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import { InertiaProgress } from '@inertiajs/progress'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m'
import Notifications from '@kyvg/vue3-notification'
import AuthenticatedLayout from '../js/Layouts/Authenticated.vue';
import Guest from '../js/Layouts/Guest.vue';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel'

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {
        const page = resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        );
        page.then((module) => {
            if (name.startsWith('Auth') || name.startsWith('Welcome')) {
                module.default.layout = module.default.layout || Guest;
            }else{
                module.default.layout = module.default.layout || AuthenticatedLayout;
            }

        });
        return page;
    },
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(Notifications)
            .mount(el);
    },
});

InertiaProgress.init({ color: '#581c87' });
