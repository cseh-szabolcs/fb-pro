import {Provider} from "react-redux";
import {store} from "app/store";
import {Test} from "./Test/Test.tsx"
import 'app/App.css'


function App() {
    console.log("DDDDDD", window, window.APP_URL);

  return (
    <Provider store={store}>
        <Test />
    </Provider>
  )
}

export default App
