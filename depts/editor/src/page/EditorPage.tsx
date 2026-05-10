import {useDocument} from "app/hooks/useDocument.ts";
import {Editor} from "app/components/Editor.tsx";
import {Content as Workspace} from "app/components/Workspace/Content.tsx";
import {Header} from "app/components/Workspace/Header.tsx";
import {Elements} from "app/components/Workspace/Elements.tsx";
import {ElementRenderer} from "app/components/ElementRenderer.tsx";
import {FixturesRenderer} from "app/components/FixturesRenderer.tsx";
import {Editable} from "app/ui/Editable";
import {Panel as SettingsPanel} from "app/components/Settings/Panel.tsx";
import {Panel as FixturePanel} from "app/components/Fixtures/Panel.tsx";

export function EditorPage() {
  const document = useDocument();

  return (
    <Editor>
      <FixturePanel>
        <FixturesRenderer />
      </FixturePanel>
      <Workspace>
        <Header />
        <Elements>
          <Editable />
          <ElementRenderer elementId={document.id} />
        </Elements>
      </Workspace>
      <SettingsPanel />
    </Editor>
  );
}
