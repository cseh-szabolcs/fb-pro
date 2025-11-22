import {Provider} from "react-redux";
import {store} from "app/store";
import {Test} from "./Test/Test.tsx"
import 'app/App.css'


export function App() {

  return (
    <Provider store={store}>
      <Test/>
    </Provider>
  )
}

