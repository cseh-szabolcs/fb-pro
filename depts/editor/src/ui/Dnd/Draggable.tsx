import {useDraggable} from "@dnd-kit/core";
import type {CSSProperties, ReactNode} from "react";

export function Draggable({id, children}: {
  id: string;
  children: ReactNode;
}) {
  const dg = useDraggable({id});

  const style: CSSProperties|undefined = dg.transform ? {
    transform: `translate3d(${dg.transform.x}px, ${dg.transform.y}px, 0)`,
  } : undefined;

  return (
    <div
      style={style}
      ref={dg.setNodeRef}
      {...dg.listeners}
      {...dg.attributes}
    >
      {children}
    </div>
  );
}
