import {useFetchData} from "app/store/action/main/fetchData.ts";
import {Test} from "app/Test/Test.tsx";

export function EditorPage() {
  useFetchData();


  return (
    <Test></Test>
  );
}