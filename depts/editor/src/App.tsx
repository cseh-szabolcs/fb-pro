import {useFetchData} from "app/hooks/useFetchData.ts";
import {EditorPage} from "app/page/EditorPage.tsx";
import {Initializing} from "app/components/Initializing.tsx";

export function App() {
  useFetchData();

  return (
    <Initializing>
      <EditorPage />
    </Initializing>
  );
}
