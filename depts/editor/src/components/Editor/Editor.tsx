import {createEditor, type Descendant} from "slate";
import {withHistory} from "slate-history";
import {Editable, Slate, withReact} from "slate-react";
import {useMemo, useState} from "react";
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
    <Slate editor={editor} initialValue={value} onChange={handleChange}>
      <Editable
        placeholder="Tippe etwas..."
        style={{ minHeight: 200, border: '4px solid limegreen', padding: 8 }}
      />
    </Slate>
  );
}
