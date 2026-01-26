import {useMemo, type ReactNode} from "react";
import type {Element} from "app/types/element.ts";
import {SideModel} from "app/models/SideModel.ts";

export function ElementOuter({margin, children}: Pick<Element, 'margin'> & {children?: ReactNode}) {
  const styleMargin = useMemo(
    () => new SideModel<number>(margin).toCssPadding(10),
    [margin],
  );

  return (
    <div style={styleMargin}>
      {children}
    </div>
  );
}
