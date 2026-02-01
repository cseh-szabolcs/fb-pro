import type {ReactNode} from "react"; // CSSProperties
import {useDroppable} from "@dnd-kit/core";

export function Droppable({id, children}: {
  id: string;
  children: ReactNode;
}) {
  const dp = useDroppable({id});

  const style: string = dp.isOver
    ? 'opacity-100'
    : dp.active
    ? 'opacity-50'
    : 'opacity-0';

  return (
    <div className={style} ref={dp.setNodeRef}>
      {children}
    </div>
  );
}
