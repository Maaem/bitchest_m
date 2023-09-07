import { createStore } from "zustand/vanilla";
import { devtools } from "zustand/middleware";

/**
 * Create user vanilla store to use outside react
 */
export const userStore = createStore(
  devtools(
    (set) => ({
      user: null,
      setUser: (user) => set({ user: user }),
    }),
    { name: "userStore", store: "user", type: "user" },
  ),
);
