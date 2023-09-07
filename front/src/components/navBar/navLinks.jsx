import { useEffect } from "react";
import { useNavigate } from "@tanstack/react-router";
import { Button, Collapse, Flex } from "@chakra-ui/react";

import { userStore } from "@/store/userStore";
import { signOut } from "@/api";
import { AdminNavLink } from "@/components/navBar/AdminNavLink";
import { ClientNavLink } from "@/components/navBar/navBarClient";
import { CustomLink } from "@/components/navBar/CustomLink";
import { useSidebarStore } from "@/store/sidebarStore";

export const NavigationLinks = () => {
  const { setState, getState } = userStore;
  const { isOpen, openSideBar, closeSideBar } = useSidebarStore((store) => store);
  const navigate = useNavigate();

  useEffect(() => {
    const resize = () => {
      if (window.innerWidth >= 768) {
        openSideBar();
      } else {
        closeSideBar();
      }
    };
    window.addEventListener("resize", resize);
    return () => window.removeEventListener("resize", resize);
  });

  const signOutAndRedirect = async () => {
    try {
      const response = await signOut();
      if (response.status === 200) {
        setState({ user: null });
        navigate({ to: "/", replace: true });
      }
    } catch (err) {
      console.log(err);
    }
  };

  return (
    <>
      {getState().user !== null && (
        <>
          <Collapse animateOpacity={true} in={isOpen}>
            <Flex
              position={["initial", "initial"]}
              p={5}
              justifyContent={"center"}
              flexDir={"column-reverse"}
              alignItems={"center"}
              gap={3}>
              <Button onClick={() => signOutAndRedirect()}>Déconnexion</Button>
              <CustomLink
                to={{ to: "/currencies", from: "/" }}
                bg={"green.400"}
                px={"16px"}
                py={"8px"}
                verticalAlign={"middle"}
                borderRadius={"6px"}
                minW={"130px"}
                textAlign={"center"}
                color={"white"}>
                Liste des crypto-monnaies
              </CustomLink>
              {getState().user === "admin" && <AdminNavLink />}
              {getState().user === "client" && <ClientNavLink />}
            </Flex>
          </Collapse>
        </>
      )}
    </>
  );
};
