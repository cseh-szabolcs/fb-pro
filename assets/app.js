import Alpine from 'alpinejs'
import persist from '@alpinejs/persist';
import {Tooltip} from 'bootstrap';
import {component} from "./js/component.js";
import 'bootstrap/dist/css/bootstrap.min.css';
import './styles/app.css';

window.Tooltip = Tooltip;
window.Alpine = Alpine;
Alpine.plugin(persist);

export default {
    component,
    start: () => Alpine.start(),
};
