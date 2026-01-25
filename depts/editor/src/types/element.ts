
interface ElementData {
  uuid: string;
  type: string;
  role?: string;
  position: number;
  backgroundColor?: string;
  color?: string;
  directionRow?: boolean;
  margin?: Side;
  padding?: Side;
  borderWidth?: Side;
  borderColor?: Side;
  borderRadius?: Corner;
  supportedTypes?: string[];
}

// element in editor (frontend)
export interface Element extends ElementData {
  children: string[];
}

// element from api (backend)
export interface ResponseElement extends ElementData {
  parent?: ResponseElement;
  children: ResponseElement[];
}

export interface Document extends Element {
  type: 'document';
}

export interface Page extends Element {
  type: 'page';
}

export interface View extends Element {
  type: 'view';
}

type Side<T = number|string> = {
  equal: boolean;
  top?: T;
  right?: T;
  bottom?: T;
  left?: T;
}

type Corner<T = number|string> = {
  equal: boolean;
  topLeft?: T;
  topRight?: T;
  bottomRight?: T;
  bottomLeft?: T;
}
