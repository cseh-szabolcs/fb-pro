import {createEditor, type Descendant} from "slate";
import {withHistory} from "slate-history";
import {Editable, Slate, withReact, type RenderLeafProps} from "slate-react";
import {useCallback, useMemo, useState, type CSSProperties} from "react";
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

  const renderLeaf = useCallback(({ attributes, children, leaf }: RenderLeafProps) => {
    let style: CSSProperties = {};

    if (leaf.bold) style.fontWeight = 'bold';
    if (leaf.italic) style.fontStyle = 'italic';
    if (leaf.underline) style.textDecoration = 'underline';

    return (
      <span style={style} {...attributes}>{children}</span>
    );
  }, []);

  return (
    <div style={{padding:20, border:'4px solid gray'}}>
      <Slate editor={editor} initialValue={value} onChange={handleChange}>
        <Toolbar />
        <Editable
          renderLeaf={renderLeaf}
          placeholder="Tippe etwas..."
          style={{ minHeight: 60, border: '4px solid limegreen', padding: 8 }}
        />
        <div style={{border: '1px solid limegreen', padding: '10px'}}>
          <span>{JSON.stringify(value)}</span>
        </div>
      </Slate>
    </div>
  );
}
