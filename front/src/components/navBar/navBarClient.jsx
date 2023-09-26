import { CustomLink } from "@/components/navBar/CustomLink";

export const ClientNavLink = () => {
  return (
    <>
      <CustomLink
        to={{ to: "/wallet", from: "/" }}
        bg={"green.400"}
        px={"16px"}
        py={"8px"}
        verticalAlign={"middle"}
        borderRadius={"6px"}
        alt="afficher mon portefeuille"
        minW={"130px"}
        textAlign={"center"}
        color={"white"}>
        Mon portefeuille
      </CustomLink>
    </>
  );
};
