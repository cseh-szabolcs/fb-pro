import {useAppSelector} from "app/store";
import type {ReactNode} from "react";

export function Initializing({children}: {
  children: ReactNode;
}) {

  const ready = useAppSelector(state => state.main.ready);

  if (!ready) {
    return <div>Loading...</div>;
  }

  return <>{children}</>;
}
