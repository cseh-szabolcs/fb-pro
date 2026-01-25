import type {ReactNode} from "react";

export function Panel({children}: { children: ReactNode }) {

  return (
    <div className="h-100" style={{backgroundColor: '#f0f0f0'}}>
      <h1>Fixtures</h1>
      <div>
        {children}
      </div>
    </div>
  );
}
