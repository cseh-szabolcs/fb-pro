import type {Element, ResponseElement} from "app/types/element.ts";

export function extractElements(current: ResponseElement, state: Record<string, Element>) {
    state[current.uuid] = {
        ...current,
        children: current.children.map(child => child.uuid),
    }

    for (const child of current.children) {
        extractElements(child, state);
    }

    return state;
}
