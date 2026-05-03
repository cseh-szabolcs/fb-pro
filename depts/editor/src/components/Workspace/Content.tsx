import type {ReactNode} from "react";

export function Content({children}: {
  children: ReactNode,
}) {

  return (
    <div className="d-flex flex-column flex-1 h-100" style={{backgroundColor: '#dedede'}}>
      {children}
    </div>
  );
}
