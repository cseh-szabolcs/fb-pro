import {useAppDispatch, useAppSelector} from "app/store";
import {getActiveElementId, setActiveElementId} from "app/store/slice/mainSlice.ts";
import {selectById} from "app/store/slice/elementSlice.ts";
import {getElementLabel} from "app/functions/elementUtils.ts";
import type {Node, Element} from "app/types/element.ts";

export function useGetActiveElement() {
  const elementId = useAppSelector(getActiveElementId);

  return useAppSelector(state => {
    if (elementId === undefined) {
      return undefined;
    }

    return selectById(state, elementId);
  });
}

export function useSetActiveElement() {
  const dispatch = useAppDispatch();

  return (element: string|Element) => {
    dispatch(setActiveElementId(
      typeof element === 'object'
        ? element.id
        : element
    ));
  }
}

export function useGetActiveElementBreadcrumbs(): Node[] {
  const elementId = useAppSelector(getActiveElementId);

  return useAppSelector(state => {
    if (elementId === undefined) {
      return [];
    }

    let currentElement = selectById(state, elementId);

    if (!currentElement) {
      return [];
    }

    const elements: Node[] = [{
      id: currentElement.id,
      type:currentElement.type,
      label: getElementLabel(currentElement),
    }];

    while (currentElement.parentId !== undefined) {
      const parent = selectById(state, currentElement.parentId);

      if (!parent) {
        break;
      }

      elements.push({
        id: parent.id,
        type: parent.type,
        label: getElementLabel(parent),
      });

      currentElement = parent;
    }

    return elements.reverse();
  });
}
