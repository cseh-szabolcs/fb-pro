export default {
    read(selector, reset = true) {
        const value = this.get(selector).value.trim();
        if (reset) this.get(selector).value = '';

        return value;
    },

    get(selector) {
        return selector.startsWith('#')
            ? document.getElementById(selector.substring(1))
            : document.querySelector(selector);
    },
};
