export function objectIntersects(a: object, b: object): boolean {
    for (const key in a) {
        if (Object.hasOwn(b, key) && (a as any)[key] === (b as any)[key]) {
            return true;
        }
    }
    return false;
}