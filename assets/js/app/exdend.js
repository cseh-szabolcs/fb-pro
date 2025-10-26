export function extend(...objects) {
    const result = {};
    objects.forEach(obj => {
        Object.defineProperties(result, Object.getOwnPropertyDescriptors(obj));
    });
    return result;
}
