import { StrictMode } from 'react'
import { createRoot } from 'react-dom/client'
import {App} from './App.tsx'
import './index.css'

createRoot(document.getElementById('root')!).render(
  <StrictMode>
    <App />
  </StrictMode>,
)

declare global {
    interface Window {
        APP_URL: string;
        DATA_SRC: string;
        APP_AUTHORIZATION: string;
    }
}
