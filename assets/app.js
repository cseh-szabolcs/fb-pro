import Alpine from 'alpinejs'
import persist from '@alpinejs/persist';
import {Tooltip} from 'bootstrap';
import core from "./js/core/index.js";
import 'bootstrap/dist/css/bootstrap.min.css';
import './styles/app.css';
import './styles/bs-overrides.css';

window.Tooltip = Tooltip;
window.Alpine = Alpine;
Alpine.plugin(persist);

export default {
    start: () => Alpine.start(),
    component(data, name = 'root', start = true) {
        const factory = typeof data !== 'function'
            ? () => data
            : function() { return data.apply(this, [this]); };

        Alpine.data(name, factory);
        if (start) Alpine.start();
    },
    extend(...objects) {
        const result = {};
        objects.forEach(obj => {
            Object.defineProperties(result, Object.getOwnPropertyDescriptors(obj));
        });
        return result;
    },
    delay: (callback, ms = undefined) => {
        window.setTimeout(callback, ms);
    },
    dispatch: (name, data = undefined) => {
        const event = data
            ? new CustomEvent(name, {detail: data})
            : new CustomEvent(name);

        window.dispatchEvent(event);
    },
    async fetch(path, method = 'GET', body = null, options = {}, headers = {}) {
        return fetch(path, {
            method,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                ...headers,
            },
            ...options,
            body: body || undefined,
        });
    },
    async get(path, options = {}, headers = {}) {
        return this.fetch(path, 'GET', null, options, headers);
    },
    async post(path, body, options = {}, headers = {}) {
        return this.fetch(path, 'POST', body, options, headers);
    },
    async delete(path, options = {}, headers = {}) {
        return this.fetch(path, 'DELETE', null, options, headers);
    },
    core,
    components: {},
    pages: {},
};
