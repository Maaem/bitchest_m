import { useState } from "react";
import { useRouter, useSearch } from "@tanstack/react-router";
import { purchaseRoute } from "@/router/route";
import { achatCrypto } from "/src/api/index";

export const PurchaseCurrency = () => {
  const { currency_id, currency_name } = useSearch({ from: purchaseRoute.id });
  const [success, setSuccess] = useState(false);
  const [error, setError] = useState(null);
  const router = useRouter();

  const makePurchase = async (e) => {
    e.preventDefault();
    const target = e.target;
    const payload = {
      quantity: target.quantity.value,
      currency_id: currency_id,
    };
    try {
      const response = await achatCrypto(payload);
      if (response.status === 201) {
        setSuccess(true);
        router.invalidate();
        router.navigate({ to: "/currencies", from: "/" });
      }
    } catch (err) {
      setError(err.message);
    }
  };

  return (
    <div className="mt-10 sm:mx-auto sm:w-full sm:max-w-[480px]">
      {success && (
        <div className="bg-green-200 border border-green-600 text-green-800 px-4 py-2 mb-4 rounded">
          Achat effectué. Nous avons pris en compte votre achat.
        </div>
      )}
      {error !== null && (
        <div className="bg-red-200 border border-red-600 text-red-800 px-4 py-2 mb-4 rounded">
          Une erreur est survenue: {error}
        </div>
      )}
      <h1 className="text-2xl font-bold my-4">
        Sélectionner une quantité pour : <span className="font-semibold">{currency_name}</span>
      </h1>
      <form
        onSubmit={(e) => makePurchase(e)}
        className="bg-white p-12 border border-gray-300 rounded shadow-md max-w-md">
        <div className="mb-4">
          <label className="block text-sm font-medium text-gray-700">Quantité</label>
          <input
            type="number"
            required={true}
            name="quantity"
            className="w-full px-3 py-2 border rounded focus:outline-none focus:border-blue-500"
          />
        </div>
        <button
          type="submit"
          className="w-full px-4 py-2 bg-pink-400 hover:bg-pink-800 text-white font-semibold rounded">
          Acheter
        </button>
      </form>
    </div>
  );
};
