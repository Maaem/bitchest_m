import { Flex, Table, Thead, Tbody, Tr, Th, Td } from "@chakra-ui/react";
import { useLoader } from "@tanstack/react-router";

export const UserDetailWallet = () => {
  const userDetailedWallet = useLoader();

  return (
    <Flex justifyContent={"center"} alignItems={"center"} height={"100%"}>
      <Table>
        <Thead>
          <Tr>
            <Th>Crypto-monnaie</Th>
            <Th>Date dachat</Th>
            <Th>Quantité</Th>
            <Th>Bénéfices</Th>
          </Tr>
        </Thead>
        <Tbody>
          {userDetailedWallet[0].crypto_wallets.map((val) => (
            <Tr key={val.currency.id}>
              <Td>{val.currency.crypto_name}</Td>
              <Td>{val.created_at}</Td>
              <Td>{val.quantity}</Td>
              <Td>{val.capital_gain ?? 0}</Td>
            </Tr>
          ))}
        </Tbody>
      </Table>
    </Flex>
  );
};
