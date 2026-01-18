import type {FC, ReactNode} from "react";
import type {Element as TElement} from "app/types/element.ts";

export type ElementProps = {
  element: TElement;
  parent?: TElement;
  children?: ReactNode;
};

export const elements: Record<string, FC<ElementProps>> = {};

export function registerRenderer(component: FC<ElementProps>, type: string) {
  elements[type] = component;
}
