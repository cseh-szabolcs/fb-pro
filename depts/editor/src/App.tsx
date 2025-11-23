import {Provider} from "react-redux";
import {store} from "app/store";
import {EditorPage} from "app/page/EditorPage.tsx";
import 'app/App.css'

export function App() {

  return (
    <Provider store={store}>
      <EditorPage />
    </Provider>
  );
}
