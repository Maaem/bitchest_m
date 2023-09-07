import { Router } from "@tanstack/react-router";
import {
  indexRoute,
  adminRoute,
  clientRoute,
  rootRoute,
  updateUserRoute,
  createUserRoute,
  currenciesListRoute,
  currencyRate,
  purchaseRoute,
  walletRoute,
  walletDetailRoute,
} from "@/router/route";

const routeTree = rootRoute.addChildren([
  indexRoute,
  adminRoute,
  clientRoute,
  updateUserRoute,
  createUserRoute,
  currenciesListRoute,
  currencyRate,
  purchaseRoute,
  walletRoute,
  walletDetailRoute,
]);

export const router = new Router({ routeTree, defaultPreload: "intent" });
