import { RootRoute, Route, Outlet, redirect } from "@tanstack/react-router";

import * as Crud from "@/crud/index.js";
import { Layout } from "@/components/navBar/Layout";
import {
  getAllUsers,
  getCurrencies,
  getCurrencyRate,
  getUserById,
  getUsersCryptoWallet,
  getUserCryptoWalletDetail,
  isAuthenticated,
  getUserWallet,
} from "@/api/index.js";
import { router } from "@/router/index.js";
import { userStore } from "@/store/userStore.js";

const { setState, getState } = userStore;

let rootRoute = new RootRoute({
  component: () => (
    <>
      <Layout>
        <Outlet />
      </Layout>
    </>
  ),
  loader: async () => {
    if (getState().user === "client") {
      return getUserWallet();
    }
  },
});

//
const indexRoute = new Route({
  getParentRoute: () => rootRoute,
  path: "/",
  component: Crud.Login,
  beforeLoad: async ({ search }) => {
    try {
      const response = await isAuthenticated();
      setState({ user: response });
      if (response === "admin") {
        if (search?.redirect !== undefined) {
          return router.history.push(search.redirect);
        }
        router.navigate({ to: "admin" });
      } else {
        if (search?.redirect !== undefined) {
          return router.history.push(search.redirect);
        }
        router.navigate({ to: "client" });
      }
    } catch (err) {
      return Crud.Login;
    }
  },
});
const adminRoute = new Route({
  getParentRoute: () => rootRoute,
  path: "admin",
  component: () => (
    <>
      <Crud.Admin />
    </>
  ),
  loader: async () => {
    const res = await getAllUsers();
    return res;
  },
  beforeLoad: async () => {
    if (getState().user === null) {
      throw redirect({
        to: "/",
      });
    }
  },
});
const updateUserRoute = new Route({
  getParentRoute: () => rootRoute,
  path: "update-user/$id",
  loader: async ({ params: { id } }) => {
    const res = await getUserById(id);
    return res;
  },
  beforeLoad: async () => {
    if (getState().user === null) {
      throw redirect({
        to: "/",
      });
    }
  },
  component: Crud.AdminUpdateUser,
});
const createUserRoute = new Route({
  getParentRoute: () => rootRoute,
  path: "create-user",
  component: Crud.AdminCreateUser,
  beforeLoad: async () => {
    if (getState().user === null) {
      throw redirect({
        to: "/",
      });
    }
  },
});
const clientRoute = new Route({
  getParentRoute: () => rootRoute,
  path: "client",
  beforeLoad: async () => {
    if (getState().user === null) {
      throw redirect({
        to: "/",
      });
    }
  },
});
const cryptoListRoute = new Route({
  getParentRoute: () => rootRoute,
  path: "currencies",
  component: Crud.CryptoList,
  beforeLoad: async () => {
    if (getState().user === null) {
      throw redirect({
        to: "/",
        search: {
          redirect: router.state.location.href,
        },
      });
    }
  },
  loader: async () => {
    return await getCurrencies();
  },
});

const currencyRate = new Route({
  getParentRoute: () => rootRoute,
  path: "currency/$id",
  component: Crud.CurrencyRate,
  beforeLoad: async () => {
    if (getState().user === null) {
      throw redirect({
        to: "/",
        search: {
          redirect: router.state.location.href,
        },
      });
    }
  },
  loader: async ({ params: { id } }) => {
    return await getCurrencyRate(id);
  },
});

const purchaseRoute = new Route({
  getParentRoute: () => rootRoute,
  path: "purchase",
  beforeLoad: async () => {
    if (getState().user === null) {
      throw redirect({
        to: "/",
      });
    }
  },
  component: Crud.PurchaseCurrency,
  validateSearch: (search) => {
    return {
      currency_id: search.currency_id,
      currency_name: search.currency_name,
    };
  },
});

const walletRoute = new Route({
  path: "wallet",
  getParentRoute: () => rootRoute,
  beforeLoad: async () => {
    if (getState().user === null) {
      throw redirect({
        to: "/",
      });
    }
  },
  component: Crud.clientWallets,
  loader: async () => {
    return getUsersCryptoWallet();
  },
});

const walletDetailRoute = new Route({
  getParentRoute: () => rootRoute,
  path: "wallet/detail/$id",
  beforeLoad: () => {
    if (getState().user === null) {
      throw redirect({
        to: "/",
      });
    }
  },
  loader: async ({ params: { id } }) => {
    return getUserCryptoWalletDetail(id);
  },
  component: Crud.UserDetailWallet,
});

export {
  indexRoute,
  adminRoute,
  clientRoute,
  rootRoute,
  updateUserRoute,
  createUserRoute,
  cryptoListRoute,
  currencyRate,
  purchaseRoute,
  walletRoute,
  walletDetailRoute,
};
