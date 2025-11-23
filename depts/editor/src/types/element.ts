
export interface Element {
  uuid: string;
  type: string;
  role?: string;
  children: string[];
  backgroundColor?: string;
  color?: string;
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
