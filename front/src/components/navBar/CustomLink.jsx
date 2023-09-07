import { Link as ChakraLink } from "@chakra-ui/react";
import { Link } from "@tanstack/react-router";
import { useSidebarStore } from "@/store/sidebarStore";

/**
 * @param {Object} props
 * @param {import("@tanstack/react-router").LinkPropsOptions} props.to
 * @param {JSX.Element} props.children
 * @param {Object} props.style
 * @returns {JSX.Element}
 * @constructor
 */
export const CustomLink = ({ to, children, ...style }) => {
  const closeSidebar = useSidebarStore((state) => state.closeSideBar);
  const shouldCloseSideBar = () => {
    if (window.innerWidth < 768) {
      closeSidebar();
    }
  };

  return (
    <>
      <ChakraLink onClick={() => shouldCloseSideBar()} as={Link} {...to} {...style}>
        {children}
      </ChakraLink>
    </>
  );
};
