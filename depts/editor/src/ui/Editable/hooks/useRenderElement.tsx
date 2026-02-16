import {type RenderElementProps} from "slate-react";
import {type CSSProperties, useCallback} from "react";

export function useRenderElement() {
  return useCallback(({attributes, element, children}: RenderElementProps) => {
    let style: CSSProperties = {
      ...(element.align && {textAlign: element.align}),
    };

    const props = {...attributes, style, children};

    switch (element.type) {
      case "paragraph": {
        return <p {...props} />;
      }
      case "heading": {
        const Heading = `h${element.level}`;

        return <Heading {...props} />;
      }
      default: {
        return <span {...props} />;
      }
    }
  }, []);
}
