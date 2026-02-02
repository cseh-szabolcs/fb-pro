import {useListener} from "app/hooks/useListener.ts";
import {DndProvider, type DropEvent} from "app/ui/Dnd";
import type {ReactNode} from "react";

export function DndActionProvider({children}: {
  children: ReactNode;
}) {

  useListener('dnd:element:drop', (e: DropEvent) => {
    alert(e.detail.over?.id);
  });

  return (
    <DndProvider scope="dnd:element">
      {children}
    </DndProvider>
  );
}
