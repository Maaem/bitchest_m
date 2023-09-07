import { CustomLink } from "@/components/navBar/CustomLink";

export const AdminNavLink = () => {
  return (
    <>
      <CustomLink
        to={{ to: "/admin", from: "/" }}
        bg={"green.400"}
        px={"16px"}
        py={"8px"}
        verticalAlign={"middle"}
        borderRadius={"6px"}
        minW={"130px"}
        textAlign={"center"}
        color={"white"}>
        Dashboard
      </CustomLink>
    </>
  );
};
