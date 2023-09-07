import { RouterProvider } from "@tanstack/react-router";
import { ChakraProvider } from "@chakra-ui/react";
import { TanStackRouterDevtools } from "@tanstack/router-devtools";

import { router } from "@/router";

function App() {
  return (
    <>
      <ChakraProvider>
        <RouterProvider router={router} />
        <TanStackRouterDevtools router={router} />
      </ChakraProvider>
    </>
  );
}

export default App;
