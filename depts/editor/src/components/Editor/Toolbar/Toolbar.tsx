import type {MouseEvent} from "react";
import {useMark} from "app/components/Editor/hooks/useMark.ts";

export function Toolbar() {
  const [toggleBold, isBold] = useMark('bold');

  const handleBold = (e: MouseEvent) => {
    e.preventDefault();
    toggleBold();
  }

  return (
    <div style={{border:"4px solid navy", borderRadius:6}}>
      <button onMouseDown={handleBold} style={{backgroundColor: isBold ? 'red' : 'green'}}>
        Fett
      </button>
    </div>
  );
}
