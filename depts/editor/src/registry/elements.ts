import type {FC, ReactNode} from "react";
import type {Element as TElement} from "app/types/element.ts";

export type ElementProps<T extends TElement = TElement> = {
  element: T;
  parent?: TElement;
  children?: ReactNode;
};

export const elements: Record<string, FC<ElementProps>> = {};

export function registerElement<T extends TElement>(component: FC<ElementProps<T>>, type: string) {
  elements[type] = component as FC<ElementProps>;
}
