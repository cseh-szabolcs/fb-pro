import type {ChangeEvent, MouseEvent} from "react";
import {useMark} from "../hooks/useMark.ts";
import {useBlock, useCurrentBlock} from "app/ui/Editable/hooks/useBlock.ts";
import type {EElement, Heading} from "app/types/editor.ts";

export function Toolbar() {
  const [toggleTextBold, isTextBold] = useMark('bold');
  const [toggleBlockLeft, isBlockLeft] = useBlock({align: 'left'});
  const [toggleBlockCenter, isBlockCenter] = useBlock({align: 'center'});
  const [toggleBlockJustify, isBlockJustify] = useBlock({align: 'justify'});
  const [toggleBlockRight, isBlockRight] = useBlock({align: 'right'});
  const [switchBlock, block] = useCurrentBlock();

  const handleTextBold = (e: MouseEvent) => {
    e.preventDefault();
    toggleTextBold();
  }

  const handleBlockLeft = (e: MouseEvent) => {
    e.preventDefault();
    toggleBlockLeft();
  }

  const handleTextCenter = (e: MouseEvent) => {
    e.preventDefault();
    toggleBlockCenter();
  }

  const handleBlockJustify = (e: MouseEvent) => {
    e.preventDefault();
    toggleBlockJustify();
  }

  const handleBlockRight = (e: MouseEvent) => {
    e.preventDefault();
    toggleBlockRight();
  }

  const handleBlockTypeChange = (e: ChangeEvent<HTMLSelectElement>) => {
    switch (e.target.value) {
      case 'p':
        return switchBlock('paragraph');
      case 'h1':
        return switchBlock<Heading>('heading', {level: 1});
      case 'h2':
        return switchBlock<Heading>('heading', {level: 2});
      case 'h3':
        return switchBlock<Heading>('heading', {level: 3});
    }
  }

  return (
    <div style={{border:"4px solid navy", borderRadius:6}}>
      <select value={translateBlockType(block as EElement)} onChange={handleBlockTypeChange}>
        <option value="p">Paragraph</option>
        <option value="h1">Überschrift 1</option>
        <option value="h2">Überschrift 2</option>
        <option value="h3">Überschrift 3</option>
      </select>
      <button onMouseDown={handleTextBold} style={{backgroundColor: isTextBold ? 'red' : 'green'}}>
        Fett
      </button>
      <button onMouseDown={handleBlockLeft} style={{backgroundColor: isBlockLeft ? 'red' : 'green'}}>
        L
      </button>
      <button onMouseDown={handleTextCenter} style={{backgroundColor: isBlockCenter ? 'red' : 'green'}}>
        C
      </button>
      <button onMouseDown={handleBlockJustify} style={{backgroundColor: isBlockJustify ? 'red' : 'green'}}>
        J
      </button>
      <button onMouseDown={handleBlockRight} style={{backgroundColor: isBlockRight ? 'red' : 'green'}}>
        R
      </button>
    </div>
  );
}

function translateBlockType(block?: EElement) {
  if (block?.type === 'paragraph') {
    return 'p';
  }

  if (block?.type === 'heading') {
    return `h${block.level}`
  }
}
