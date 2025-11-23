import {useFetchData} from "app/hooks/useFetchData.ts";
import {EditorPage} from "app/page/EditorPage.tsx";
import 'app/App.css'

export function App() {
  useFetchData();

  return (
    <EditorPage />
  );
}
