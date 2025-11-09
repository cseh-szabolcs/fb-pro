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
    start: () => Alpine.start(),
    delay: (callback, ms = undefined) => {
        window.setTimeout(callback, ms);
    },
    dispatch: (name, data = undefined) => {
        const event = data
            ? new CustomEvent(name, {detail: data})
            : new CustomEvent(name);

        window.dispatchEvent(event);
    },
    core,
    components: {},
    pages: {},
};
