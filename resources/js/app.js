import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';

import { createInertiaApp } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

window.route = route;

function getOrCreateGuestToken() {
  let token = sessionStorage.getItem('guest_token');
  if (!token) {
    token = 'guest_' + crypto.randomUUID();
    sessionStorage.setItem('guest_token', token);
  }
  return token;
}

window.guestToken = getOrCreateGuestToken();

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true });
    return pages[`./Pages/${name}.vue`];
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .mount(el);
  },
});
