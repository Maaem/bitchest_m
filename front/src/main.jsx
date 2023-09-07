import ReactDOM from "react-dom/client";

import App from "./App.jsx";

const rootElement = document.getElementById("root");

if (!rootElement.innerHTML) {
  const root = ReactDOM.createRoot(rootElement);
  root.render(<App />);
}
