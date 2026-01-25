import {useDocument} from "app/hooks/useDocument.ts";
import {Header} from "app/components/Header/Header.tsx";
import {ElementRenderer} from "app/components/ElementRenderer.tsx";
import {Settings} from "app/components/Settings/Settings.tsx";
import {FixturesRenderer} from "app/components/FixturesRenderer.tsx";
import {Editor} from "app/components/Editor.tsx";

export function EditorPage() {
  const document = useDocument();

  return (
    <div className="d-flex" style={{height: '100vh'}}>
      <FixturesRenderer elementId={document.children[0]} />
      <div className="d-flex flex-column flex-1 h-100" style={{backgroundColor: '#dedede'}}>
        <Header />
        <Editor>
          <ElementRenderer elementId={document.uuid} />
        </Editor>
      </div>
      <Settings />
    </div>
  );
}
