/* eslint-disable prettier/prettier */
import { Box, Flex, IconButton, Image } from "@chakra-ui/react";
import { HamburgerIcon } from "@chakra-ui/icons";

import { NavigationLinks } from "@/components/navBar/navLinks";
import { useSidebarStore } from "@/store/sidebarStore";
import { userStore } from "@/store/userStore";
import { useLoader } from "@tanstack/react-router";

export const Sidebar = () => {
  const { isOpen, toggleSidebar } = useSidebarStore((store) => store);
  const { getState } = userStore;

  /**
   * @type {import("@/crud/clientWallets").Wallet}
   */
  const wallet = useLoader();

  return (
    <>
      <Box
        bg={"gray.400"}
        maxW={["100%", "100%", "250px"]}
        w={"100%"}
        position={["fixed", "fixed", "initial"]}
        h={["auto", "auto", "100vh"]}
        zIndex={10}
        as="nav"
        display={"inline-block"}>
        <Box
          justifyContent={"center"}
          maxW={200}
          mx={"auto"}
          boxSize="sm"
          w={200}
          h={"auto"}
          hideBelow="md"
          aria-hidden={true}>
          <Image src="/bitchest_logo.png" alt="Logo bitchest" />
        </Box>
        <Flex
          justifyContent={"space-between"}
          flexDir={"column"}
          alignItems={"center"}>
          <Flex
            justifyContent={["space-between", "space-between", "center"]}
            w={"100%"}
            alignItems={"center"}>
            {getState().user === "client" && (
              <Box as={"span"} fontWeight={"700"} p={2}>
                Solde : {wallet.quantity} €
              </Box>
            )}
            <Flex p={2} hideFrom="md" justifyContent={"flex-end"}>
              <IconButton
                _hover={{ bg: "gray.300" }}
                aria-pressed={isOpen}
                aria-label={"Ouvrir/Fermer le menu latéral"}
                icon={<HamburgerIcon />}
                onClick={() => {
                  toggleSidebar();
                }}
              />
            </Flex>
          </Flex>
          <NavigationLinks />
        </Flex>
      </Box>
    </>
  );
};
