import type {ReactNode} from "react";

export function Workspace({children}: {
  children: ReactNode,
}) {

  return (
    <div className="flex-1 d-flex flex-column app-scroll">
      {children}
    </div>
  );
}
