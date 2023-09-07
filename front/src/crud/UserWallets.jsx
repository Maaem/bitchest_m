/* eslint-disable react/no-unescaped-entities */
import { useLoader, useRouter } from "@tanstack/react-router";
import { sellCurrency } from "@/api";
import { CustomLink } from "@/components/navBar/CustomLink";

/**
 * Représentation d'un utilisateur et les informations relatives à son portefeuille de cryptomonnaies.
 * @typedef {Object} User
 * @property {number} id - ID utilisateur.
 * @property {string} email - adresse mail utilisateur.
 * @property {CryptoWallet[]} crypto_wallets - tableau portefeuilles de cryptomonnaies appartenant à l'utilisateur.
 * @property {Wallet} wallet - Infos portefeuille utilisateur.
 */

/**
 * Représentation portefeuille crypto-monnaie.
 * @typedef {Object} CryptoWallet
 * @property {string} quantity - quantité de crypto-monnaie dans le portefeuille.
 * @property {Currency} currency - infos sur la devise de la crypto-monnaie.
 */

/**
 * Représentation crypto-monnaie.
 * @typedef {Object} Currency
 * @property {number} id - ID crypto-monnaie.
 * @property {string} crypto_name - nom crypto-monnaie.
 */

/**
 * Portefeuille utilisateur.
 * @typedef {Object} Wallet
 * @property {number} id - ID portefeuille.
 * @property {number} quantity - quantité portefeuille.
 */

export const UserWallets = () => {
  /**
   * tableau contenant des informations sur les utilisateurs et leurs portefeuilles de crypto-monnaie.
   * @type {User[]}
   */
  const userWithWallet = useLoader();
  const router = useRouter();

  /**
   * @param {React.SyntheticEvent} e
   * @param {string} currencyId
   * @returns {Promise<void>}
   */
  const sellACurrency = async (e, currencyId) => {
    e.preventDefault();
    try {
      const res = await sellCurrency(currencyId);
      if (res.status === 201) {
        router.invalidate();
      }
    } catch (err) {
      console.log(err);
    }
  };

  return (
    <>
      <div className="px-4 sm:px-6 lg:px-8">
        <div className="sm:flex sm:items-center">
          <div className="sm:flex-auto">
            <h1 className="text-base font-semibold leading-6 text-gray-900">Mon portefeuille</h1>
          </div>
          <div className="mt-4 sm:ml-16 sm:mt-0 sm:flex-none"></div>
        </div>
        <div className="mt-8 flow-root">
          <div className="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div className="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
              <div className="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                <table className="min-w-full divide-y divide-gray-300">
                  <thead className="bg-gray-50">
                    <tr>
                      <th
                        scope="col"
                        className="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                        Crypto-monnaie
                      </th>
                      <th
                        scope="col"
                        className="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                        ID
                      </th>
                      <th
                        scope="col"
                        className="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                        Quantité
                      </th>
                      <th
                        scope="col"
                        className="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                        Date d'achat
                      </th>
                      <th
                        scope="col"
                        className="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                        Prix d'achat
                      </th>
                      <th
                        scope="col"
                        className="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                        Prix de vente
                      </th>
                      <th
                        scope="col"
                        className="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                        Plus values
                      </th>
                      <th
                        scope="col"
                        className="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                        Actions
                      </th>
                      <th scope="col" className="relative py-3.5 pl-3 pr-4 sm:pr-6">
                        <span className="sr-only">Edit</span>
                      </th>
                    </tr>
                  </thead>
                  <tbody className="divide-y divide-gray-200 bg-white">
                    {userWithWallet[0]?.crypto_wallets.map((val) => (
                      <tr key={val.currency.id}>
                        <td className="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                          {val.currency.crypto_name}
                        </td>
                        <td className="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                          {val.currency.id}
                        </td>
                        <td className="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                          {val.quantity}
                        </td>
                        <td className="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                          {val.purchase_date}
                        </td>
                        <td className="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                          {val.purchase_price}
                        </td>
                        <td className="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                          {val.sale_price}
                        </td>
                        <td className="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                          {val.profit}
                        </td>
                        <td className="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                          <CustomLink
                            to={{
                              pathname: `/wallet/detail/${val.currency.id}`,
                              state: { from: "/" },
                            }}
                            style={{
                              backgroundColor: "#0077b6",
                              color: "white",
                              borderRadius: "6px",
                              padding: "8px 12px",
                              textDecoration: "none",
                              display: "inline-block",
                            }}>
                            Voir le détail
                          </CustomLink>
                        </td>
                        <td className="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                          <button
                            style={{
                              backgroundColor: "#8338ec",
                              color: "white",
                              borderRadius: "6px",
                              padding: "8px 12px",
                              border: "none",
                              cursor: "pointer",
                            }}
                            onClick={(e) => sellACurrency(e, val.currency.id)}>
                            Vendre
                          </button>
                        </td>
                      </tr>
                    ))}
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </>
  );
};
