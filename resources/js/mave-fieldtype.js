import ky from 'ky';
window.ky = ky

import MaveFieldtype from './compontents/MaveFieldtype.vue';

Statamic.booting(() => {
    Statamic.$components.register('mave-fieldtype', MaveFieldtype);
});
