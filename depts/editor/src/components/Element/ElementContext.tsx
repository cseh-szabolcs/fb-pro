import {createContext, useContext} from "react";
import type {Element} from "app/types/element.ts";

export const ElementContext = createContext<Element|null>(null);

export function useElementContext(): Element|null {
  return useContext(ElementContext)!;
}
