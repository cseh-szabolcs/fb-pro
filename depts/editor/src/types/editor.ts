import {ReactEditor} from 'slate-react';
import {HistoryEditor} from 'slate-history';
import type {BaseEditor} from 'slate';

export type EText = {
  text: string;
  bold?: true;
  italic?: true;
  underline?: true;
  // add marks
};

export type MarkTypes = keyof Omit<EText, 'text'>;

export interface BaseElement {
  type: string;
  children?: EText[];
  align?: AlignTypes;
}

export interface Paragraph extends BaseElement {
  type: 'paragraph';
}

export interface Heading extends BaseElement {
  type: 'heading';
  level: 1 | 2 | 3 | 4 | 5 | 6;
}

export type EElement =
  | Paragraph
  | Heading
;

export type AlignTypes = 'left' | 'center' | 'justify' | 'right';
export type ElementTypes = EElement['type'];
export type FormatTypes = AlignTypes | ElementTypes;

declare module 'slate' {
  interface CustomTypes {
    Editor: BaseEditor & ReactEditor & HistoryEditor
    Element: EElement
    Text: EText
  }
}
