import {registerElement, type ElementProps} from "app/registry/elements.ts";
import {DefaultInput} from "./DefaultInput.tsx";
import type {Input, InputElementTypes} from "app/types/element.ts";

registerElement<Input>(({element}: ElementProps<Input>) => {
  if (DefaultTypes.includes(element.inputType)) {
    return <DefaultInput {...element} />;
  }

  return null;
}, 'input');

const DefaultTypes: InputElementTypes[] = [
  'text',
  'email',
  'password',
  'number',
  'date',
  'time',
  'datetime-local',
  'color',
  'file',
  'url',
];
