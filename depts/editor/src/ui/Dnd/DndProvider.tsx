import {DndContext, pointerWithin, type DragEndEvent} from "@dnd-kit/core";
import type {ReactNode} from "react";

export function DndProvider({scope, children}: {
  scope: string;
  children: ReactNode;
}) {

  const handleDragEnd = (event: DragEndEvent) => {
    if (event.over) {
      window.dispatchEvent(new CustomEvent(`${scope}:drop`, {
        detail: event,
      }));
    }
  };

  return (
    <DndContext onDragEnd={handleDragEnd} collisionDetection={pointerWithin}>
      {children}
    </DndContext>
  );
}
