import Alpine from 'alpinejs'
import persist from '@alpinejs/persist';
import {Tooltip} from 'bootstrap';
import {component} from "./js/app/component.js";
import {extend} from "./js/app/exdend.js";
import 'bootstrap/dist/css/bootstrap.min.css';
import './styles/app.css';

window.Tooltip = Tooltip;
window.Alpine = Alpine;
Alpine.plugin(persist);

export default {
    component,
    extend,
    start: () => Alpine.start(),
    delay: (callback, ms = undefined) => {
        window.setTimeout(callback, ms);
    },
    components: {},
    pages: {},
};
