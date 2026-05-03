import {useGetActiveElementBreadcrumbs} from "app/hooks/useActiveElement.ts";

export function Breadcrumb() {
  const tree = useGetActiveElementBreadcrumbs();

  return (
    <div className="d-flex gap-2">
      {tree.map((node) => (
        <div key={node.uuid}>
          <span>{node.label}</span>
        </div>
      ))}
    </div>
  );
}
