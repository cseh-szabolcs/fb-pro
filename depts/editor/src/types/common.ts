export type RequireOne<T, Keys extends keyof T = keyof T> =
    Keys extends any
        ? Required<Pick<T, Keys>> & Partial<Record<Exclude<keyof T, Keys>, never>>
        : never
        & { [key in Exclude<keyof T, Keys>]?: never }
;
