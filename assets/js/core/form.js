export default {
    async submit(selector) {
        const form = document.querySelector(selector);
        if (!form) {
            return;
        }

        const data = new FormData(form);
        await fetch(form.action, {
            method: form.method,
            body: data,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            },
        });
    }
};
