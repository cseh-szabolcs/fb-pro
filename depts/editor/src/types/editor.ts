import {ReactEditor} from 'slate-react';
import {HistoryEditor} from 'slate-history';
import type {BaseEditor} from 'slate';

export type CustomText = {
  text: string;
  bold?: true;
  italic?: true;
  underline?: true;
  // add marks
};

interface Node {
  type: string;
  children?: CustomText[];
}

interface Paragraph extends Node {
  type: 'paragraph';
}

interface Heading extends Node {
  type: 'heading';
  level: 1 | 2 | 3 | 4 | 5 | 6;
}

export type CustomElement =
  | Paragraph
  | Heading
;

declare module 'slate' {
  interface CustomTypes {
    Editor: BaseEditor & ReactEditor & HistoryEditor
    Element: CustomElement
    Text: CustomText
  }
}
