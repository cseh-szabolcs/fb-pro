import {Test} from "app/Test/Test.tsx";
import {useDocument} from "app/hooks/useDocument.ts";
import {ElementRenderer} from "app/components/ElementRenderer.tsx";

export function EditorPage() {
  const document = useDocument();

  return (
    <>
      <Test></Test>
      <ElementRenderer elementId={document.uuid} />
    </>
  );
}
