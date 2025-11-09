import app from "app";

export default {
    path: '',
    items: [],
    count: 0,
    initialized: false,
    loading: false,
    version: 0,

    async fetch() {
        if (this.loading || !this.path) return;
        this.loading = true;
        this.error = false;

        const response = await app.get(this.path, {redirect: 'manual'});
        if (response.status === 302 || response.type === 'opaqueredirect') {
            window.location.reload();
        }
        try {
            const result = await response.json();
            this.initialized = true;
            this.items = result.items;
            this.count += result.count;
            this.loading = false;
            this.version++;
        } catch (e) {
            this.error = true;
        }
    },

    async remove(item, path, id = 'id') {
        app.remove
    },

    async reload() {
        this.initialized = true;
        await this.fetch();
    },
};

const pagination = {

}

const filters = {

}

const options = {

}
