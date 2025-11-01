import {Modal} from "bootstrap";

export default {
    close: () => {
        const openModalEl = document.querySelector('.modal.show');

        if (openModalEl) {
            Modal.getOrCreateInstance(openModalEl).hide();
        }
    }
};
