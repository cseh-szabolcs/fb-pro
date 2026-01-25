import {StrictMode} from 'react'
import {createRoot} from 'react-dom/client'
import {App} from './App.tsx'
import {store} from "app/store";
import {Provider} from "react-redux";
import 'bootstrap/dist/css/bootstrap.min.css';
import 'app/assets/styles/app.css'

createRoot(document.getElementById('root')!).render(
  <StrictMode>
    <Provider store={store}>
      <App />
    </Provider>
  </StrictMode>,
);

declare global {
    interface Window {
        APP_URL: string;
        APP_LOCALE: string;
        DATA_ID: string;
        DATA_TYPE: string;
        AUTH_TOKEN: string;
    }
}
