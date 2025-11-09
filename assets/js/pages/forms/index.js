import app from "app";
import {List} from 'app/components'

app.pages.formList = ({
    name,
    path,
    editAction,
    deleteAction,
}) => app.component(app.extend(List, {
    foo: "Bar",
    path,
    init() {
        this.fetch();
    },
    async createNew() {
        await app.core.form.submit('form[name="create"]');

        app.core.input.read('#create_title');
        app.core.modal.close();
        this.reload();
    },
    editForm(form) {
        return editAction.replace('__UUID__', form.uuid);
    },
    async deleteForm(form) {
        await fetch(deleteAction.replace('__UUID__', form.uuid), {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            },
        });
    }
}), name);
