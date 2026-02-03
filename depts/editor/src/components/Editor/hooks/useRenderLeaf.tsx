import {type RenderLeafProps} from "slate-react";
import {type CSSProperties, useCallback} from "react";

export function useRenderLeaf() {
  return useCallback(({attributes, children, leaf}: RenderLeafProps) => {
    let style: CSSProperties = {};

    if (leaf.bold) style.fontWeight = 'bold';
    if (leaf.italic) style.fontStyle = 'italic';
    if (leaf.underline) style.textDecoration = 'underline';

    return (
      <span {...attributes} style={style}>
        {children}
      </span>
    );
  }, []);
}
