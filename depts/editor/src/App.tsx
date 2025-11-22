import {Provider} from "react-redux";
import {store} from "app/store";
import {Test} from "./Test/Test.tsx"
import 'app/App.css'


function App() {

  return (
    <Provider store={store}>
        <Test />
    </Provider>
  )
}

export default App
