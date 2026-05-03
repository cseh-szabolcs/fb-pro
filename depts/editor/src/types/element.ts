import type {Corner, Side} from "app/types/element/props.ts";

interface ElementData {
  uuid: string;
  type: string;
  id?: string;
  parentId?: string;
  role?: string;
  position: number;
  backgroundColor?: string;
  color?: string;
  directionRow?: boolean;
  margin?: Side<number>;
  padding?: Side<number>;
  borderWidth?: Side<number>;
  borderColor?: Side<string>;
  borderRadius?: Corner;
  supportedTypes?: string[];
}

// element in editor (frontend)
interface BaseElement extends ElementData {
  children: string[];
}

// element from api (backend)
export interface ResponseElement extends ElementData {
  parent?: ResponseElement;
  children: ResponseElement[];
}

export interface Document extends BaseElement {
  type: 'document';
}

export interface Page extends BaseElement {
  type: 'page';
}

export interface View extends BaseElement {
  type: 'view';
}

export interface Input extends BaseElement {
  type: 'input';
  inputType: InputElementTypes;
  placeholder?: string;
  value?: string;
  label?: string;
  name?: string;
}

export type Element =
  | Document
  | Page
  | View
  | Input;

export type Node = {
  uuid: string
  type: Element['type'];
  label: string;
}

export type InputElementTypes =
  | 'color'
  | 'date'
  | 'datetime-local'
  | 'email'
  | 'file'
  | 'hidden'
  | 'number'
  | 'password'
  | 'radio'
  | 'select'
  | 'text'
  | 'textarea'
  | 'time'
  | 'url'
;
