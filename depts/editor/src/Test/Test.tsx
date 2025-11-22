import css from './Test.module.css';

export function Test() {
    return (
        <>
            <h1 className={css.color}>Hola</h1>
            <p>APP_URL: <b>{window.APP_URL}</b></p>
            <p>DATA_SRC: <b>{window.DATA_SRC}</b></p>
        </>
    );
}
