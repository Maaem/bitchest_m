/* eslint-disable react/no-unescaped-entities */
/* eslint-disable react-hooks/rules-of-hooks */
import React, { useState, useEffect } from "react";
import { useLoader, useRouter } from "@tanstack/react-router";
import { sellCurrency } from "@/api";

/**
 * @typedef {Object} CryptoWallet
 * @property {string} quantity - La quantité de crypto-monnaie dans le portefeuille.
 * @property {string} id - La quantit�� de crypto-monnaie dans le portefeuille.
 * @property {string} created_at - La date de création du portefeuille au format "JJ-MM-AAAA".
 * @property {string} sell_at - La date de vente du portefeuille au format "JJ-MM-AAAA".
 * @property {number|null} capital_gain - Le gain en capital (peut être null).
 * @property {import("@/pages/clientWallets").Currency} currency - Les informations sur la devise crypto associée.
 */

export const clientWallets = () => {
  const usersWithWallet = useLoader();
  const router = useRouter();

  const [cryptoWallets, setCryptoWallets] = useState(usersWithWallet[0]?.crypto_wallets);

  const sellACurrency = async (e, currencyId) => {
    e.preventDefault();
    try {
      const { data: { sell_at } = {} } = await sellCurrency(currencyId);
      if (sell_at) {
        // Trouver l'index de la crypto-monnaie vendue dans le tableau
        const index = cryptoWallets.findIndex((wallet) => wallet.currency.id === currencyId);
        if (index !== -1) {
          
          const updatedCryptoWallets = [...cryptoWallets];
          updatedCryptoWallets[index].sell_at = sell_at;
          setCryptoWallets(updatedCryptoWallets);
        }
        router.invalidate();
      }
    } catch (err) {
      console.log(err);
    }
  };

  useEffect(() => {
    setCryptoWallets(usersWithWallet[0]?.crypto_wallets);
  }, [usersWithWallet]);

  return (

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
                      Cours sur la période
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
                {cryptoWallets.map((val) => {
                  return (
                    <tr key={val.id}>
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
                        <a
                          href={`currency/${val.currency.id}`}
                          className="bg-blue-500 text-white rounded-md py-2 px-4 text-center inline-block">
                          Voir le détail
                        </a>
                      </td>
                      <td className="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                        {val.sell_at ? (
                          "Vendu"
                        ) : (
                          <button
                            className="bg-purple-600 text-white rounded-md py-2 px-4 text-center border-none cursor-pointer"
                            alt="bouton vendre"
                            onClick={(e) => sellACurrency(e, val.currency.id)}
                          >
                            Vendre
                          </button>
                        )}
                      </td>
                    </tr>
                  );
                })}
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};
