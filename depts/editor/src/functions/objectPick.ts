export function objectPick<T, K extends keyof T>(obj: T, keys: K[]){
    return Object.fromEntries(
        keys.map(key => [key, obj[key]])
    ) as Pick<T, K>;
}
