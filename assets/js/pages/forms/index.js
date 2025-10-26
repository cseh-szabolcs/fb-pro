import app from "app";

app.pages.formList = ({
    name,
    path,
}) => app.component(() => app.extend(app.components.list, {
    foo: "Bar",
    path,
    init() {
        this.fetch()
    },
}), name);
