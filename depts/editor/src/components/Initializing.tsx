import {useAppSelector} from "app/store";
import {selectIsReady} from "app/store/slice/mainSlice.ts";
import type {ReactNode} from "react";

export function Initializing({children}: {
  children: ReactNode;
}) {

  const ready = useAppSelector(selectIsReady);

  if (!ready) {
    return <div>Loading...</div>;
  }

  return <>{children}</>;
}
