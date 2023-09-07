import { Box, Flex } from "@chakra-ui/react";
import { Sidebar } from "@/components/navBar/Sidebar";

/**
 * @param {Object} props
 * @param {React.ReactNode} props.children
 * @returns {JSX.Element}
 */
export const Layout = ({ children }) => {
  return (
    <>
      <Flex>
        <Sidebar />
        <Box as="main" w={"100%"} ml={["0%"]} px={2} pt={2} display={"inline"}>
          {children}
        </Box>
      </Flex>
    </>
  );
};
