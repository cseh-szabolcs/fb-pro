import type {ReactNode} from "react";
import {DndActionProvider} from "app/components/DndActionProvider.tsx";

export function Editor({children}: { children: ReactNode }) {

  return (
    <DndActionProvider>
      <div className="d-flex" style={{height: '100vh'}}>
        {children}
      </div>
    </DndActionProvider>
  );
}
