import {useDocument} from "app/hooks/useDocument.ts";
import {Header} from "app/components/Header/Header.tsx";
import {ElementRenderer} from "app/components/ElementRenderer.tsx";
import {Settings} from "app/components/Settings/Settings.tsx";
import {FixturesRenderer} from "app/components/FixturesRenderer.tsx";
import {Workspace} from "app/components/Workspace.tsx";
import {DndActionProvider} from "app/components/DndActionProvider.tsx";
import {Editor} from "app/components/Editor/Editor.tsx";

export function EditorPage() {
  const document = useDocument();

  return (
    <DndActionProvider>
      <div className="d-flex" style={{height: '100vh'}}>
        <FixturesRenderer />
        <div className="d-flex flex-column flex-1 h-100" style={{backgroundColor: '#dedede'}}>
          <Header />
          <Workspace>
            <Editor />
            <ElementRenderer elementId={document.uuid} />
          </Workspace>
        </div>
        <Settings />
      </div>
    </DndActionProvider>
  );
}
