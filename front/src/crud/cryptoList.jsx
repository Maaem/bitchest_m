/* eslint-disable react-hooks/rules-of-hooks */
import { useLoader } from "@tanstack/react-router";
import { userStore } from "@/store/userStore";
import { CustomLink } from "@/components/navBar/CustomLink";

export const cryptoList = () => {
  const currencies = useLoader();
  const { getState } = userStore;

  const thead = (
    <tr>
      <th
        scope="col"
        className="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
        ID
      </th>
      <th scope="col" className="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
        Cryptomonnaie
      </th>
      <th scope="col" className="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
        Cours actuel
      </th>
      <th scope="col" className="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
        Cours sur la période
      </th>
      {getState().user === "client" && (
        <th scope="col" className="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
          Acheter
        </th>
      )}
    </tr>
  );

  const tbody = (
    <>
      {currencies.map((val) => {
        return (
          <tr key={val.id}>
            <td className="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{val.id}</td>
            <td className="px-3 py-4 text-sm font-medium text-gray-900">{val.crypto_name}</td>
            <td className="px-3 py-4 text-sm font-medium text-gray-900">
              {val.currency_histories[0].quoting} €
            </td>
            <td className="px-3 py-4 text-sm font-medium text-gray-900">
              <CustomLink
                to={{ to: `currency/${val.id}`, from: "/", params: { id: val.id } }}
                p={2}
                bg={"green.400"}
                color={"white"}
                borderRadius={"6px"}>
                Voir le cours
              </CustomLink>
            </td>
            {getState().user === "client" && (
              <td className="px-3 py-4 text-sm font-medium text-gray-900">
                <CustomLink
                  to={{
                    to: "purchase",
                    from: "/",
                    search: { currency_id: val.id, currency_name: val.crypto_name },
                  }}
                  p={2.5}
                  bg={"pink.400"}
                  color={"white"}
                  borderRadius={"6px"}>
                  Acheter
                </CustomLink>
              </td>
            )}
          </tr>
        );
      })}
    </>
  );

  return (
    <div className="px-4 sm:px-6 lg:px-8">
      <div className="mt-8 flow-root">
        <div className="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
          <div className="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <div className="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
              <table className="min-w-full divide-y divide-gray-300">
                <thead className="bg-gray-50">{thead}</thead>
                <tbody className="divide-y divide-gray-200 bg-white">{tbody}</tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};
