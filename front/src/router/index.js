import { Router } from "@tanstack/react-router";
import {
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
} from "@/router/route";

const routeTree = rootRoute.addChildren([
  indexRoute,
  adminRoute,
  clientRoute,
  updateUserRoute,
  createUserRoute,
  cryptoListRoute,
  currencyRate,
  purchaseRoute,
  walletRoute,
  walletDetailRoute,
]);

export const router = new Router({ routeTree, defaultPreload: "intent" });
