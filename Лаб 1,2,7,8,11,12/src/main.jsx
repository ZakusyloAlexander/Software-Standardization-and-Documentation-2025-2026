import React from "react";
import ReactDOM from "react-dom/client";
import { BrowserRouter } from "react-router-dom";
import { Provider } from "react-redux";
import { store } from "./store/index.js";
import App from "./App.jsx";
import { CookieConsent } from "./components/CookieConsent.jsx";

ReactDOM.createRoot(document.getElementById("root")).render(
  <React.StrictMode>
    <Provider store={store}>
      <BrowserRouter>
        <App />
        <CookieConsent />
      </BrowserRouter>
    </Provider>
  </React.StrictMode>,
);



