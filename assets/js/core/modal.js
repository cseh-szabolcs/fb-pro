import {Modal} from "bootstrap";
import app from "../../app.js";

export default {
    close: () => {
        const openModalEl = document.querySelector('.modal.show');

        if (openModalEl) {
            Modal.getOrCreateInstance(openModalEl).hide();
            app.dispatch('modal:close');
        }
    }
};
