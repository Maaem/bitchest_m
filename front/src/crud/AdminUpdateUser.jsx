import { useLoader, useNavigate } from "@tanstack/react-router";
import { Button, Flex, FormControl, FormLabel, Input, Select, Text } from "@chakra-ui/react";
import { updateUserById } from "@/api/index.js";

export const AdminUpdateUser = () => {
  /**
   * @typedef {import("./Admin.jsx").User} User
   * @type {User}
   */
  const user = useLoader();
  const navigate = useNavigate();
  const otherRole = user.role === "admin" ? "client" : "admin";

  const modifyUserInfo = async (e) => {
    e.preventDefault();
    const payload = { role: e.target.role.value };
    try {
      const response = await updateUserById(user.id, payload);
      if (response.status === 200) {
        navigate({ to: "admin", from: "/" });
      }
    } catch (err) {
      console.log(err);
    }
  };

  return (
    <>
      <Flex
        alignItems={"center"}
        justifyContent={"center"}
        flexDir={"column"}
        mt={["5rem", "5rem", "0rem"]}>
        <Text as={"h1"} my={"1rem"}>
          Modifier un utilisateur
        </Text>
        <Flex
          p={"2rem"}
          border={"1px"}
          borderColor="gray.200"
          as={"form"}
          gap={"1rem"}
          flexDir={"column"}
          onSubmit={(e) => modifyUserInfo(e)}>
          <FormControl>
            <FormLabel>Email address</FormLabel>
            <Input name={"email"} readOnly={true} value={user.email} type="email" />
          </FormControl>
          <FormControl>
            <FormLabel>Rôle</FormLabel>
            <Select name={"role"}>
              <option>{user.role}</option>
              <option>{otherRole}</option>
            </Select>
          </FormControl>
          <Button type={"submit"}>Modifier</Button>
        </Flex>
      </Flex>
    </>
  );
};
