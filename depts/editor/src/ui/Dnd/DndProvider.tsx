import {
  DndContext,
  pointerWithin,
  type DragEndEvent,
  DragOverlay,
  type Modifier,
  type DragStartEvent
} from "@dnd-kit/core";
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

  const handleDragStart = (event: DragStartEvent) => {
    window.dispatchEvent(new CustomEvent(`${scope}:drag`, {
      detail: event,
    }));
  };

  const offsetOverlay: Modifier = ({transform, activeNodeRect, activatorEvent}) => {
    if (!transform || !activeNodeRect || !(activatorEvent instanceof PointerEvent)) {
      return transform;
    }

    const offsetX = activatorEvent.clientX - activeNodeRect.left;
    const offsetY = activatorEvent.clientY - activeNodeRect.top;

    return {
      ...transform,
      x: transform.x + offsetX,
      y: transform.y + offsetY,
    };
  };

  return (
    <DndContext
      onDragStart={handleDragStart}
      onDragEnd={handleDragEnd}
      modifiers={[offsetOverlay]}
      collisionDetection={pointerWithin}
    >
      {children}
      <DragOverlay>
        <p style={{border:'1px solid red', background:'red', width:140}}>Ziehe mich</p>
      </DragOverlay>
    </DndContext>
  );
}
