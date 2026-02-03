import * as React from "react";
import {useMemo, useState} from "react";
import {createEditor, type Descendant} from "slate";
import {Editable, Slate, withReact} from "slate-react";
import {withHistory} from "slate-history";
import {useRenderLeaf} from "app/components/Editor/hooks/useRenderLeaf.tsx";
import {useShortCuts} from "app/components/Editor/hooks/useShortCuts.ts";
import {Toolbar} from "app/components/Editor/Toolbar/Toolbar.tsx";
import "app/types/editor.ts";

export function Editor() {
  const editor = useMemo(() => withHistory(withReact(createEditor())), []);

  const [value, setValue] = useState<Descendant[]>([
    { type: 'paragraph', children: [{ text: '' }] },
  ]);

  const handleChange = (newValue: Descendant[]) => {
    setValue(newValue);

    const operations = editor.operations;
    console.log("Editor-Operations", operations);
    console.log("Editor-State", value);
  };

  return (
    <div style={{padding:20, border:'4px solid gray'}}>
      <Slate editor={editor} initialValue={value} onChange={handleChange}>
        <EditorInput />
        <div style={{border: '1px solid limegreen', padding: '10px'}}>
          <span>{JSON.stringify(value)}</span>
        </div>
      </Slate>
    </div>
  );
}

const EditorInput = React.memo(() => {
  const renderLeaf = useRenderLeaf();
  const shortCuts = useShortCuts();

  return (
    <>
      <Toolbar />
      <Editable
        renderLeaf={renderLeaf}
        onKeyDown={shortCuts}
        placeholder="Tippe etwas..."
        style={{ minHeight: 60, border: '4px solid limegreen', padding: 8 }}
      />
    </>
  );
});
