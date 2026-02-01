import {DndContext, pointerWithin, type DragEndEvent} from "@dnd-kit/core";
import type {ReactNode} from "react";

export function DndProvider({context, children}: {
  context: string;
  children: ReactNode;
}) {

  const handleDragEnd = (event: DragEndEvent) => {
    if (event.over) {
      window.dispatchEvent(new CustomEvent(`${context}:drop`, {
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
