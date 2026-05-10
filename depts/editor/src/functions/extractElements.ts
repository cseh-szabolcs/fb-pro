import type {BaseElement, ResponseElement} from "app/types/element.ts";

export function extractElements(current: ResponseElement, state: Record<string, BaseElement>) {
    state[current.id] = {
        ...current,
        children: current.children.map(child => child.id),
    }

    for (const child of current.children) {
        extractElements(child, state);
    }

    return state;
}
