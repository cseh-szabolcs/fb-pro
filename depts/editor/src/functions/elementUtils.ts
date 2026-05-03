import type {Element} from "app/types/element.ts";

export function getElementLabel(element: Pick<Element, 'type'>) {
  switch (element.type) {
    case 'document':
      return 'Document';
    case 'page':
      return 'Page';
    case "view":
      return "View";
    case 'input':
      return 'Input';
    default:
      return '???';
  }
}
