import classNames from "classnames";
import {useGetActiveElementBreadcrumbs, useSetActiveElement} from "app/hooks/useActiveElement.ts";
import {useEffect, useState} from "react";
import type {Node} from "app/types/element.ts";

export function Breadcrumb() {
  const tree = useGetActiveElementBreadcrumbs();
  const [treeMemorized, setTreeMemorized] = useState<Node[]>();
  const setActiveElement = useSetActiveElement();

  useEffect(() => {
    if (!treeMemorized) {
      setTreeMemorized(tree);
    }
    for (const node of tree) {
      if (!treeMemorized?.find(item => item.uuid === node.uuid)) {
        setTreeMemorized(tree);
      }
    }
  }, [tree, treeMemorized]);

  return (
    <div className="d-flex gap-2">
      {(treeMemorized ?? []).map((node) => (
        <div
            key={node.uuid}
            onClick={() => setActiveElement(node.uuid)}
            className={classNames("pointer", {'opacity-50': !tree?.find(item => item.uuid === node.uuid)})}
        >
          <span>
            {node.label}
          </span>
        </div>
      ))}
    </div>
  );
}
