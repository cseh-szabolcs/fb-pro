
export default {
    path: '',
    items: [],
    count: 0,
    initialized: false,
    loading: false,
    version: 0,

    fetch() {
        if (this.loading || !this.path) return;
        this.loading = true;
        this.error = false;

        fetch(this.path, {redirect: 'manual'})
            .then(response => {
                if (response.status === 302 || response.type === 'opaqueredirect') {
                    window.location.reload();
                }
                return response.json();
            })
            .then(({items, count}) => {
                this.initialized = true;
                this.items = items;
                this.count += count;
                this.loading = false;
                this.version++;
            })
            .catch(() => {
                this.error = true;
            });
    },

    reload() {
        this.initialized = true;
        this.loading = true;
        this.fetch();
    },
};

const pagination = {

}

const filters = {

}

const options = {

}
